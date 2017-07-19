// Initialize the Installation object
Joomla.installation = function(_container, _base) {
	var container, busy, baseUrl, view,
	    /**
	     * Method to submit a form from the installer via AJAX
	     *
	     * @return {Boolean}
	     */
	    submitform = function() {
		    var form = document.getElementById('adminForm'),
		        data = Joomla.serialiseForm(form);

		    if (busy) {
			    alert(Joomla.JText._('INSTL_PROCESS_BUSY', 'Process is in progress. Please wait...'));
			    return false;
		    }

		    Joomla.loadingLayer("show");
		    busy = true;
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
					    busy = false;
				    } else {

					    var lang = document.getElementsByTagName('html')[0].getAttribute('lang');
					    console.log(response.data.view)
					    window.location = baseUrl + '?view=' + response.data.view + '&layout=default';
					    // if (response.lang && lang.toLowerCase() === response.lang.toLowerCase()) {
					    // 	if (response.data && response.data.view)
					    //     Install.goToPage(response.data.view, true);
					    // } else {
					    //    window.location = baseUrl + '?view=' + response.data.view + '&layout=default';
					    // }
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

		    if (busy) {
			    alert(Joomla.JText._('INSTL_PROCESS_BUSY', 'Process is in progress. Please wait...'));
			    return false;
		    }

		    var sel = document.getElementById('jform_language');

		    console.log(form)
		    Joomla.loadingLayer("show");
		    busy = true;
		    Joomla.removeMessages();
		    var data = Joomla.serialiseForm(form);
		    console.log(data)
		    Joomla.request({
			    url: baseUrl,
			    method: 'POST',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    response = JSON.parse(response);
				    console.log(response)
				    Joomla.replaceTokens(response.token);

				    // if (response.messages) {
				    //    Joomla.renderMessages(response.messages);
				    // }

				    if (response.error) {
					    Joomla.renderMessages({'error': [response.message]});
					    Joomla.loadingLayer("hide");
					    busy = false;
				    } else {

					    var lang = document.getElementsByTagName('html')[0].getAttribute('lang');
					    console.log(response.data.view)
					    window.location = baseUrl + '?view=' + response.data.view + '&layout=default';
					    if (lang.toLowerCase() === response.lang.toLowerCase()) {
						    // Install.goToPage(response.data.view, true);
					    } else {
						    // window.location = baseUrl + '?view=' + response.data.view + '&layout=default';
					    }
				    }
			    },
			    onError:   function(xhr){
				    Joomla.loadingLayer("hide");
				    busy = false;
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
		    console.log(page)
		    if (page === 'remove') {
			    window.location = baseUrl + '?view=' + page + '&layout=default';
		    }

		    return false;
	    },

	    /**
	     * Executes the required tasks to complete site installation
	     *
	     * @param tasks       An array of install tasks to execute
	     * @param step_width  The width of the progress bar element
	     */
	    install = function(tasks) {
		    var progressWrapper = document.getElementById('install_progress');
		    var $progress        = '';//jQuery(progressWrapper).find('.progress-bar');

		    if (!tasks.length) {
			    // $progress.css('width', parseFloat($progress.get(0).style.width) + (step_width * 3) + '%');
			    // progressWrapperesponse.value = parseFloat(($progress.get(0).style.width) + (step_width * 3));
			    goToPage('remove');
			    return;
		    }

		    // if (!step_width) {
		    //    var step_width = (100 / tasks.length) / 11;
		    // }

		    var task = tasks.shift();
		    var form = document.getElementById('adminForm');
		    var data = Joomla.serialiseForm(form);
		    console.log(task)
		    // $progress.css('width', parseFloat($progress.get(0).style.width) + step_width + '%');
		    // progressWrapper.value = parseFloat(($progress.get(0).style.width) + step_width);
		    // $tr.addClass('active');
		    Joomla.loadingLayer("show");

		    Joomla.request({
			    type: "POST",
			    url : baseUrl + '?task=Install' + task  + '&layout=default',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    response = JSON.parse(response);
				    console.log(response.data.view)
				    Joomla.replaceTokens(response.token);
				    // Install.install(['Database']);
				    if (response.messages) {
					    Joomla.renderMessages(response.messages);
					    console.log(response.data.view)
					    Install.goToPage(response.data.view, true);
				    } else {
					    // $progress.css('width', parseFloat($progress.get(0).style.width) + (step_width * 10) + '%');
					    // progressWrapper.value = parseFloat(($progress.get(0).style.width) + (step_width * 10));
					    // $tr.removeClass('active');
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

	    checkDbCredentials = () => {
		    Joomla.loadingLayer("show");

		    var form = document.getElementById('adminForm'),
		        data = Joomla.serialiseForm(form);

		    console.log(data)
		    console.log(Joomla.installationBaseUrl + '?task=InstallDbcheck&format=json')
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
	var symbols = '0123456789abcdefghijklmnopqrstuvwxyz', letters = 'abcdefghijklmnopqrstuvwxyz';
	var prefix = letters[Math.floor(Math.random() * 24)];

	for (var i = 0; i < 4; i++ ) {
		prefix += symbols[Math.floor(Math.random() * 34)];
	}

	document.getElementById('jform_db_prefix').value = prefix + '_';

	return prefix + '_';
};

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
		if (document.getElementById('installStep2')) {
			document.getElementById('installStep2').removeAttribute('hidden');
			document.getElementById('installStep2').classList.add('active');
			document.getElementById('step1').parentNode.removeChild(document.getElementById('step1'));

			document.getElementById('installStep2').scrollIntoView();
		}
	})
}

if (document.getElementById('step2')) {
	document.getElementById('step2').addEventListener('click', function(e) {
		// e.preventDefault();
		if (document.getElementById('installStep3')) {
			document.getElementById('installStep3').removeAttribute('hidden');
			document.getElementById('installStep3').classList.add('active');
			document.getElementById('step2').parentNode.removeChild(document.getElementById('step2'))

			document.getElementById('installStep3').scrollIntoView();
		}
	})
}

Joomla.checkInputs = function() {
	document.getElementById('jform_admin_password2').value = document.getElementById('jform_admin_password').value;
	// document.getElementById('jform_admin_password2').type = 'text';
	document.getElementById('jform_db_prefix').value = Joomla.makeRandomDbPrefix();

	// alert(document.getElementById('jform_db_prefix').value)
	var inputs = [].slice.call(document.querySelectorAll('input[type="password"], input[type="text"], input[type="email"], select')),
	    state = true;
	inputs.forEach(function(item) {
		if (!item.valid) state = false;
	});


	console.log(Joomla.makeRandomDbPrefix())

	Install.checkDbCredentials();
};

// Init installation
window.Install = new Joomla.installation(
	Joomla.getOptions('system.installation'),
	Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php'
);
