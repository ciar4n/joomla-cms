
// Initialize the Installation object
Joomla.installation = function(_container, _base) {
	var container, baseUrl, view,
	    /**
	     * Method to submit a form from the installer via AJAX
	     *
	     * @return {Boolean}
	     */
	    submitform = function() {
		    var form = document.getElementById('adminForm'),
		        data = Joomla.serialiseForm(form);

		    Joomla.loadingLayer("show");
		    Joomla.removeMessages();

		    Joomla.request({
			    type     : "POST",
			    url      : baseUrl,
			    data     : data,
			    dataType : 'json',
			    onSuccess: function (response, xhr) {
				    response = JSON.parse(response);

				    if (response.messages) {
					    Joomla.renderMessages(response.messages);
				    }

				    if (response.error) {
					    Joomla.renderMessages({'error': [response.message]});
					    Joomla.loadingLayer("hide");
				    } else {
					    Joomla.loadingLayer("hide");
					    if (response.data && response.data.view) {
						    Install.goToPage(response.data.view, true);
					    }
				    }
			    },
			    onError  : function (xhr) {
				    Joomla.loadingLayer("hide");
				    busy = false;
				    try {
					    var r = JSON.parse(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(r.message);
				    } catch (e) {
				    }
			    }
		    });

		    return false;
	    },

	    /**
	     * Method to set the language for the installation UI via AJAX
	     *
	     * @return {Boolean}
	     */
	    setlanguage = function() {
		    var form = document.getElementById('languageForm');
		    var data = Joomla.serialiseForm(form);

		    Joomla.loadingLayer("show");
		    Joomla.removeMessages();

		    Joomla.request({
			    url: baseUrl,
			    method: 'POST',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    response = JSON.parse(response);
				    console.log(response)
				    Joomla.replaceTokens(response.token);

				    if (response.messages) {
					    Joomla.renderMessages(response.messages);
				    }

				    if (response.error) {
					    Joomla.renderMessages({'error': [response.message]});
					    Joomla.loadingLayer("hide");
				    } else {
					    Joomla.loadingLayer("hide");
					    Install.goToPage(response.data.view, true);
				    }
			    },
			    onError:   function(xhr){
				    Joomla.loadingLayer("hide");
				    try {
					    var r = JSON.parse(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(r.message);
				    } catch (e) {}
			    }
		    });

		    return false;
	    },

	    /**
	     * Method to request a different page via AJAX
	     *
	     * @param  page        The name of the view to request
	     * @param  fromSubmit  Unknown use
	     *
	     * @return {Boolean}
	     */
	    goToPage = function(page, fromSubmit) {
		    if (!fromSubmit) {
			    Joomla.removeMessages();
			    Joomla.loadingLayer("show");
		    }

		    if (page === 'remove') {
			    window.location = baseUrl + '?view=' + page + '&layout=default';
		    }

		    return false;
	    },

	    /**
	     * Executes the required tasks to complete site installation
	     *
	     * @param tasks       An array of install tasks to execute
	     */
	    install = function(tasks) {
		    if (!tasks.length) {
			    goToPage('remove');
			    return;
		    }

		    var task = tasks.shift();
		    var form = document.getElementById('adminForm');
		    var data = Joomla.serialiseForm(form);
		    Joomla.loadingLayer("show");

		    Joomla.request({
			    type: "POST",
			    url : baseUrl + '?task=Install' + task  + '&layout=default',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    response = JSON.parse(response);
				    Joomla.replaceTokens(response.token);

				    if (response.messages) {
					    Joomla.renderMessages(response.messages);
					    Install.goToPage(response.data.view, true);
				    } else {
					    Joomla.loadingLayer('hide');
					    install(tasks);
				    }
			    },
			    onError:   function(xhr){
				    Joomla.renderMessages([['', Joomla.JText._('JLIB_DATABASE_ERROR_DATABASE_CONNECT', 'A Database error occurred.')]]);
				    Install.goToPage('remove');

				    try {
					    var r = JSON.parse(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(r.message);
				    } catch (e) {
				    }
			    }
		    });
	    },

	    checkDbCredentials = function() {
		    Joomla.loadingLayer("show");

		    var form = document.getElementById('adminForm'),
		        data = Joomla.serialiseForm(form);

		    Joomla.request({
			    type: "POST",
			    url : Joomla.installationBaseUrl + '?task=InstallDbcheck&format=json',
			    data: data,
			    perform: true,
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			    onSuccess: function(response, xhr){
				    response = JSON.parse(response);
				    Joomla.loadingLayer('hide');
				    Joomla.replaceTokens(response.token);
				    if (response.messages) {
					    Joomla.loadingLayer('hide');
					    Joomla.renderMessages(response.messages);
					    // You shall not pass, DB credentials error!!!!
				    } else {
					    Joomla.loadingLayer('hide');
					    alert('good to go')
					    // You shall pass
					    install(['Config']);

					    // If all good (we need some code here)
					    goToPage('remove');
				    }
			    },
			    onError:   function(xhr){
				    Joomla.renderMessages([['', Joomla.JText._('JLIB_DATABASE_ERROR_DATABASE_CONNECT', 'A Database error occurred.')]]);
				    //Install.goToPage('summary');
				    Joomla.loadingLayer('hide');
				    try {
					    var r = JSON.parse(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(r.message);
				    } catch (e) {
				    }
			    }
		    });
	    },
	    /**
	     * Initializes the Installation class
	     *
	     * @param _container  The name of the container which the view is rendered in
	     * @param _base       The URL of the current page
	     */
	    initialize = function(_container, _base) {
		    busy = false;
		    container = _container;
		    baseUrl = _base;
		    view = '';

		    // Merge options from the session storage
		    Joomla.extend(this.options, sessionStorage.getItem('installation-data'));

		    Joomla.pageInit();
		    var el = document.querySelector('.nav-steps.hidden');
		    if (el) {
			    el.classList.remove('hidden');
		    }
	    };

	initialize(_container, _base);

	return {
		submitform : submitform,
		setlanguage : setlanguage,
		goToPage : goToPage,
		install : install,
		checkDbCredentials: checkDbCredentials
	}
};

// Init on dom content loaded event
Joomla.makeRandomDbPrefix = function() {
	var numbers = '0123456789', letters = 'abcdefghijklmnopqrstuvwxyz', symbols = numbers + letters;
	var prefix = letters[Math.floor(Math.random() * 24)];

	for (var i = 0; i < 4; i++ ) {
		prefix += symbols[Math.floor(Math.random() * 34)];
	}

	document.getElementById('jform_db_prefix').value = prefix + '_';

	return prefix + '_';
};

Joomla.checkFormField = function(fields) {
	var state = [];
	fields.forEach(function(field) {
		state.push(document.formvalidator.validate(document.querySelector(field)));
	});

	console.log(state)
	if (state.indexOf(false) > -1) {
		return false;
	}
	return true;
};

Joomla.checkInputs = function() {
	document.getElementById('jform_admin_password2').value = document.getElementById('jform_admin_password').value;
	document.getElementById('jform_db_prefix').value = Joomla.makeRandomDbPrefix();

	var inputs = [].slice.call(document.querySelectorAll('input[type="password"], input[type="text"], input[type="email"], select')),
	    state = true;
	inputs.forEach(function(item) {
		if (!item.valid) state = false;
	});

	if (Joomla.checkFormField(['#jform_site_name', '#jform_admin_user', '#jform_admin_email', '#jform_admin_password', '#jform_db_type', '#jform_db_host', '#jform_db_user', '#jform_db_name'])) {
		Install.checkDbCredentials();
	}
};

Joomla.scrollTo = function (elem, pos)
{
	var y = elem.scrollTop;
	y += (pos - y) * 0.3;
	if (Math.abs(y-pos) < 2)
	{
		elem.scrollTop = pos;
		return;
	}
	elem.scrollTop = y;
	setTimeout(Joomla.scrollTo, 40, elem, pos);
};

// Init installation
window.Install = new Joomla.installation(
	Joomla.getOptions('system.installation'),
	Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php'
);

(function() {
	// Focus to the next field
	if (document.getElementById('jform_site_name')) {
		document.getElementById('jform_site_name').focus();
	}

// Are we in the main form?
	if (document.getElementById('jform_admin_password')) {
		var elemmm = document.getElementById('jform_admin_password').parentNode;
		elemmm.querySelector('span.input-group-addon').addEventListener('click', function(e) {
			var input = document.getElementById('jform_admin_password');
			if (e.target.classList.contains('fa-eye')) {
				e.target.classList.remove('fa-eye');
				e.target.classList.add('fa-eye-slash');
				input.type = 'text';
			} else {
				e.target.classList.add('fa-eye');
				e.target.classList.remove('fa-eye-slash');
				input.type = 'password';
			}
		})
	}

	if (document.getElementById('step1')) {
		document.getElementById('step1').addEventListener('click', function(e) {
			e.preventDefault();
			if (Joomla.checkFormField(['#jform_site_name'])) {
				if (document.getElementById('installStep2')) {
					document.getElementById('installStep2').removeAttribute('hidden');
					document.getElementById('installStep2').classList.add('active');
					document.getElementById('step1').parentNode.removeChild(document.getElementById('step1'));
					document.getElementById('installStep1').classList.remove('active');
					document.querySelector('li[data-step="2"]').classList.add('active');
					Joomla.scrollTo(document.getElementById('installStep2'), document.getElementById('installStep2').offsetTop);

					// Focus to the next field
					if (document.getElementById('jform_admin_user')) {
						document.getElementById('jform_admin_user').focus();
					}
				}
			}
		})
	}

	if (document.getElementById('step2')) {
		document.getElementById('step2').addEventListener('click', function(e) {
			e.preventDefault();
			if (Joomla.checkFormField(['#jform_admin_user', '#jform_admin_email', '#jform_admin_password'])) {
				if (document.getElementById('installStep3')) {
					document.getElementById('installStep3').removeAttribute('hidden');
					document.getElementById('installStep3').classList.add('active');
					document.getElementById('step2').parentNode.removeChild(document.getElementById('step2'));
					document.getElementById('installStep2').classList.remove('active');
					document.querySelector('li[data-step="3"]').classList.add('active');
					Joomla.scrollTo(document.getElementById('installStep3'), document.getElementById('installStep3').offsetTop);
					document.getElementById('setupButton').style.display = 'block';

					// Focus to the next field
					if (document.getElementById('jform_db_type')) {
						document.getElementById('jform_db_type').focus();
					}
				}
			}
		})
	}

})();
