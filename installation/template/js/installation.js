/**
 * @package     Joomla.Installation
 * @subpackage  JavaScript
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

Joomla = window.Joomla || {};

window.nothing = function() {

};

// Initialize the Installation object
Joomla.installation = function(_container, _base) {
	var container, busy, baseUrl, view,
	    serialiseForm = function( form ) {
		    var i, l, obj = [];
		    var elements = form.querySelectorAll( "input, select, textarea" );
		    for(i = 0, l = elements.length; i < l; i++) {
			    var name = elements[i].name, value = elements[i].value;
			    if(name) {
				    obj.push(name.replace('[', '%5B').replace(']', '%5D') + '=' + value);
			    }
		    }
		    return obj.join("&");
	    },

	    /**
	     * Initializes JavaScript events on each request, required for AJAX
	     */
	    pageInit = function() {
		    // Attach the validator
		    [].slice.call(document.querySelectorAll('form.form-validate')).forEach(function(form) {
			    document.formvalidator.attachToForm(form);
		    });

		    // Create and append the loading layer.
		    Joomla.loadingLayer("load");
	    },

	    /**
	     * Method to submit a form from the installer via AJAX
	     *
	     * @return {Boolean}
	     */
	    submitform = function() {
		    var form = document.getElementById('adminForm'),
		        data = serialiseForm(form);

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
		    var data = serialiseForm(form);
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
		    if (page === 'summary') {
			    window.location = baseUrl + '?view=' + page + '&layout=default';
		    } else {
			    if (page === 'install') {
				    Joomla.request({
					    url      : baseUrl + '?tmpl=body&view=' + page + '&layout=default',
					    method   : 'GET',
					    perform  : true,
					    onSuccess: function (result, xhr) {
						    document.getElementById('container-installation').innerHTML = result;
						    view                                                        = page;

						    // Attach JS behaviors to the newly loaded HTML
						    pageInit();

						    Joomla.loadingLayer("hide");
						    busy = false;

						    // initElements();
					    }
				    });
			    }
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
		    var $progress        = jQuery(progressWrapper).find('.progress-bar');

		    if (!tasks.length) {
			    // $progress.css('width', parseFloat($progress.get(0).style.width) + (step_width * 3) + '%');
			    // progressWrapperesponse.value = parseFloat(($progress.get(0).style.width) + (step_width * 3));
			    goToPage('summary');
			    return;
		    }

		    // if (!step_width) {
			 //    var step_width = (100 / tasks.length) / 11;
		    // }

		    var task = tasks.shift();
		    var $form = jQuery('#adminForm');
		    var $tr = jQuery('#install_' + task);
		    var data = $form.serialize();

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
				    Install.goToPage('summary');

				    try {
					    var r = $.parseJSON(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(r.message);
				    } catch (e) {
				    }
			    }
		    });
	    },

	    resolveDatabase = new Promise((resolve, reject) => {
				    // We call resolve(...) when what we were doing made async successful, and reject(...) when it failed.
				    // In this example, we use setTimeout(...) to simulate async code.
				    // In reality, you will probably be using something like XHR or an HTML5 API.
				    setTimeout(() => {
					    resolve(JustAlert()); // Yay! Everything went well!
				    }, 250);
	    }),

	    checkDbCredentials = () => {
		    Joomla.loadingLayer("show");

		    var form = document.getElementById('adminForm'),
		        data = serialiseForm(form);

		    console.log(data)
		    console.log(baseUrl)
		    Joomla.request({
			    type: "POST",
			    url : baseUrl + '?task=Database',
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
					    install(['Database', 'Config']);
				    }
			    },
			    onError:   function(xhr){
				    Joomla.renderMessages([['', Joomla.JText._('JLIB_DATABASE_ERROR_DATABASE_CONNECT', 'A Database error occurred.')]]);
				    Install.goToPage('summary');

				    try {
					    var r = $.parseJSON(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(r.message);
				    } catch (e) {
				    }
			    }
		    });
	    },

	    JustAlert = () => {
	    	alert('Yay');
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

		    // pageInit();
	    };

	initialize(_container, _base);

	return {
		submitform : submitform,
		setlanguage : setlanguage,
		goToPage : goToPage,
		install : install,
		resolveDatabase : resolveDatabase,
		checkDbCredentials: checkDbCredentials

	}

// 	myFirstPromise.then((successMessage) => {
// 		// successMessage is whatever we passed in the resolve(...) function above.
// 		// It doesn't have to be a string, but if it is only a succeed message, it probably will be.
// 		alert("Yay! " + successMessage);
// 	});
// }
};

// Init on dom content loaded event
document.addEventListener('DOMContentLoaded', function() {

	var url = Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php';
	// Show the container
	if (document.getElementById('container-installation')) {
		document.getElementById('container-installation').classList.remove('no-js');
	} else {
		throw new Error('WTF?')
	}

	// We don't match the base requirements
	if (document.getElementById('prerequisites')) {
		console.log(document.getElementById('prerequisites'))
		console.log(document.getElementById('showFtp'))
		console.log(document.getElementById('prerequisites'))
		if (document.getElementById('showFtp')) {
			document.getElementById('showFtp').addEventListener('click', function(e) {
				e.preventDefault();
				if (document.getElementById('ftpOptions').classList.contains('hidden')) {
					document.getElementById('ftpOptions').classList.remove('hidden')
				} else {
					document.getElementById('ftpOptions').classList.add('hidden')
				}
			})
		}
	}

	// Init the elements
	// initElements();

	Joomla.makeRandomDbPrefix = function() {
		var symbols = '0123456789abcdefghijklmnopqrstuvwxyz', letters = 'abcdefghijklmnopqrstuvwxyz';
		var prefix = letters[Math.floor(Math.random() * 24)];

		for (var i = 0; i < 4; i++ ) {
			prefix += symbols[Math.floor(Math.random() * 34)];
		}

		return prefix + '_';
	};

	// Initialize the installation data
	Joomla.installation.data = {
		// The language used
		language: "",

		// FTP
		ftpUsername: "",
		ftpPassword: "",
		ftpHost: "",
		ftpPort: 21,
		ftpRoot: "/",

		// Extra
		sampleData: false,
		extraLanguages: [],
		components: [],
		modules: [],
		plugins: [],
		templates: [],
		libraries: []
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

		var inputs = [].slice.call(document.querySelectorAll('input[type="password"], input[type="text"], input[type="email"], select')),
		    state = true;
		inputs.forEach(function(item) {
			if (!item.valid) state = false;
		});

		document.getElementById('jform_admin_password2').value = document.getElementById('jform_admin_password').value;
		// document.getElementById('jform_admin_password2').type = 'text';
		document.getElementById('jform_db_prefix').value = Joomla.makeRandomDbPrefix();
console.log(Joomla.makeRandomDbPrefix())

		Install.checkDbCredentials();
		Install.install(['config']);
//
 		window.location = url + '?view=install'
		// Install.goToPage('summary');
		// Install.install(['Config']);

		//if (state === true) Install.install(['config']);
	};


	// if (document.getElementById('submitForm')) {
	// 	document.getElementById('submitForm').addEventListener('click', function(e) {
	// 		e.preventDefault();
	// 		Joomla.checkInputs();
	//
	// 	})
	// }

	// var langSel = document.getElementById('languageForm');
	//
	// if (langSel)
	// 	document.getElementById('top-header').appendChild(langSel);

	// var inputs = [].slice.call(document.querySelectorAll('input[type="password"], input[type="text"], input[type="email"], select'));
	// console.log(inputs)
	//<select id="jform_language" class="custom-select required ml-2"></select>

	// Init installation
	window.Install = new Joomla.installation(
		Joomla.getOptions('system.installation'),
		Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php'
	);
});
