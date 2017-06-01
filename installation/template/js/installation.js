/**
 * @package     Joomla.Installation
 * @subpackage  JavaScript
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

Joomla = window.Joomla || {};

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
		    var form = document.getElementById('adminForm');

		    if (busy) {
			    alert(Joomla.JText._('INSTL_PROCESS_BUSY', 'Process is in progress. Please wait...'));
			    return false;
		    }

		    Joomla.loadingLayer("show");
		    busy = true;
		    Joomla.removeMessages();
		    var data = serialiseForm(form);

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

					    if (response.lang && lang.toLowerCase() === response.lang.toLowerCase()) {
					    	if (response.data && response.data.view)
							    Install.goToPage(response.data.view, true);
					    } else {
						    window.location = baseUrl + '?view=' + response.data.view + '&layout=default';
					    }
				    }
			    },
			    onError  : function (xhr) {
				    Joomla.loadingLayer("hide");
				    busy = false;
				    try {
					    var r = $.parseJSON(xhr.responseText);
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

		    Joomla.loadingLayer("show");
		    busy = true;
		    Joomla.removeMessages();
		    var data = serialiseForm(form);

		    Joomla.request({
			    url: baseUrl,
			    method: 'POST',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    response = JSON.parse(response);

				    Joomla.replaceTokens(response.token);

				    if (response.messages) {
					    Joomla.renderMessages(response.messages);
				    }

				    if (response.error) {
					    Joomla.renderMessages({'error': [response.message]});
					    Joomla.loadingLayer("hide");
					    busy = false;
				    } else {

					    var lang = document.getElementsByTagName('html')[0].getAttribute('lang');

					    if (lang.toLowerCase() === response.lang.toLowerCase()) {
						    Install.goToPage(response.data.view, true);
					    } else {
						    window.location = baseUrl + '?view=' + response.data.view + '&layout=default';
					    }
				    }
			    },
			    onError:   function(xhr){
				    Joomla.loadingLayer("hide");
				    busy = false;
				    try {
					    var r = $.parseJSON(xhr.responseText);
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
			    Joomla.request({
			       url      : baseUrl + '?tmpl=body&view=' + page + '&layout=default',
			       method   : 'GET',
			       perform  : true,
			       onSuccess: function (result, xhr) {
			        document.getElementById('container-installation').innerHTML = result;
			        view = page;

			        // Attach JS behaviors to the newly loaded HTML
			        pageInit();

			        Joomla.loadingLayer("hide");
			        busy = false;

			        // initElements();
			       }
			    });
		    }

		    return false;
	    },

	    /**
	     * Executes the required tasks to complete site installation
	     *
	     * @param tasks       An array of install tasks to execute
	     * @param step_width  The width of the progress bar element
	     */
	    install = function(tasks, step_width) {
		    var progressWrapper = document.getElementById('install_progress');
		    var $progress        = jQuery(progressWrapper).find('.progress-bar');

		    if (!tasks.length) {
			    // $progress.css('width', parseFloat($progress.get(0).style.width) + (step_width * 3) + '%');
			    // progressWrapperesponse.value = parseFloat(($progress.get(0).style.width) + (step_width * 3));
			    goToPage('summary');
			    return;
		    }

		    if (!step_width) {
			    var step_width = (100 / tasks.length) / 11;
		    }

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

					    install(tasks, step_width);
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

	    /**
	     * Method to detect the FTP root via AJAX request.
	     *
	     * @param el  The page element requesting the event
	     */
	    detectFtpRoot = function(el) {
		    var $el = jQuery(el), data = $el.closest('form').serialize();

		    $el.attr('disabled', 'disabled');
var task = 'detectftproot';
		    Joomla.request({
			    type: "POST",
			    url : baseUrl + '?task=Install' + task  + '&layout=default',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    var r = JSON.parse(response);

				    if (r) {
					    Joomla.replaceTokens(r.token)
					    if (r.error == false) {
						    jQuery('#jform_ftp_root').val(r.data.root);
					    } else {
						    alert(r.message);
					    }
				    }
				    $el.removeAttr('disabled');
			    },
			    onError:   function(xhr){
				    try {
					    var r = $.parseJSON(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(xhr.status + ': ' + r.message);
				    } catch (e) {
					    alert(xhr.status + ': ' + xhr.statusText);
				    }
			    }
		    });
	    },

	    /**
	     * Method to verify the supplied FTP settings are valid via AJAX request.
	     *
	     * @param el  The page element requesting the event
	     */
	    verifyFtpSettings = function(el) {
		    // make the ajax call
		    var $el = jQuery(el), data = $el.closest('form').serialize();
console.log(data)
		    $el.attr('disabled', 'disabled');

		    Joomla.request({
			    type : "POST",
			    url : baseUrl + '?format=json&task=verifyftpsettings' + '&layout=default',
			    data: data,
			    perform: true,
			    onSuccess: function(response, xhr){
				    var r = JSON.parse(response);

				    if (r) {
					    Joomla.replaceTokens(r.token)
					    if (r.error == false) {
						    alert(Joomla.JText._('INSTL_FTP_SETTINGS_CORRECT', 'Settings correct'));
					    } else {
						    alert(r.message);
					    }
				    }
				    $el.removeAttr('disabled');
			    },
			    onError:   function(xhr){
				    try {
					    var r = $.parseJSON(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    alert(xhr.status + ': ' + r.message);
				    } catch (e) {
					    alert(xhr.status + ': ' + xhr.statusText);
				    }
			    }
		    });
	    },

	    /**
	     * Method to remove the installation Folder after a successful installation.
	     *
	     * @param el  The page element requesting the event
	     */
	    removeFolder = function(el) {
		    var $el = jQuery(el), $languages = jQuery("#languages"), $defaultError = jQuery('#theDefaultError'), $defualtErrorMessage = jQuery('#theDefaultErrorMessage'), data = 'format: json&' + $el.closest('form').serialize();

		    if ($languages.length) {
			    $languages.fadeOut();
		    }

		    $el.attr('disabled', 'disabled');
		    $defaultError.hide();


		    Joomla.request({
			    type : "POST",
			    url : baseUrl + '?task=removefolder' + '&layout=default',
			    data: data,
			    dataType : 'json',
			    perform: true,
			    onSuccess: function(response, xhr){
				    var r = JSON.parse(response);

				    if (r) {
					    Joomla.replaceTokens(r.token);
					    if (r.error === false) {
						    $el.val(r.data.text);
						    $el.attr('onclick', '').unbind('click');
						    $el.attr('disabled', 'disabled');
						    // Stop keep alive requests
						    window.keepAlive = function() {
						    };
					    } else {
						    $defaultError.show();
						    $defualtErrorMessage.html(r.message);
						    $el.removeAttr('disabled');
					    }
				    } else {
					    $defaultError.show();
					    $defualtErrorMessage.html(r);
					    $el.attr('disabled', 'disabled');
				    }
			    },
			    onError:   function(xhr){
				    try {
					    var r = $.parseJSON(xhr.responseText);
					    Joomla.replaceTokens(r.token);
					    jQuery('#theDefaultError').show();
					    jQuery('#theDefaultErrorMessage').html(r.message);
				    } catch (e) {
				    }
				    $el.removeAttr('disabled');
			    }
		    });
	    },

	    toggle = function(id, el, value) {
		    var val = jQuery('input[name="jform[' + el + ']"]:checked').val(),
		        $id = jQuery('#' + id);
		    if (val === value.toString()) {
			    $id.show();
		    } else {
			    $id.hide();
		    }
	    },

	    options = {
		    // The language used
		    language: "",

		    // Admin
		    adminName: "",
		    // adminPassword: "",
		    adminEmail: "",

		    // Site
		    siteName: "",
		    siteDescription: "",
		    siteOffline: false,

		    // Database
		    dbType: "MySQLi",
		    dbLocation: "localhost",
		    dbPrefix: Joomla.makeRandomDbPrefix(),
		    dbBackup: true,
		    dbName: "",
		    dbUsername: "",
		    dbPassword: "",

		    // Extra
		    sampleData: false,
		    extraLanguages: [],
		    components: [],
		    modules: [],
		    plugins: [],
		    templates: [],
		    libraries: []
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

		    pageInit();
	    };

	initialize(_container, _base);

	return {
		submitform : submitform,
		setlanguage : setlanguage,
		goToPage : goToPage,
		install : install,
		detectFtpRoot : detectFtpRoot,
		verifyFtpSettings : verifyFtpSettings,
		removeFolder : removeFolder,
		toggle : toggle
	}
};

// /**
//  * Initializes the elements
//  */
// function initElements()
// {
// 	"use strict";
// 	var hidables = document.querySelectorAll('.optional-entries');
//
// 	for (var i = 0; i < hidables.length; i++) {
// 		hidables[i].style.display = 'none';
// 	}
//
// 	var hideAble = document.querySelector('.hidables');
// 	if (hideAble) {
// 		hideAble.addEventListener('click', function(e) {
//
// 			hidables = document.querySelectorAll('.optional-entries');
// 			for (var i = 0; i < hidables.length; i++) {
// 				if (hidables[i].style.display === 'none') {
// 					hidables[i].style.display = 'block';
// 					e.target.innerHTML = '<span class="fa fa-eye-slash"></span> '  + e.target.getAttribute('data-simple');
// 				} else {
// 					hidables[i].style.display = 'none';
// 					e.target.innerHTML = '<span class="fa fa-exclamation-triangle"></span> '  + e.target.getAttribute('data-advanced');
// 				}
// 			}
// 		});
// 	}
// }

// Init on dom content loaded event
document.addEventListener('DOMContentLoaded', function() {

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

		// Admin
		adminName: "",
		// adminPassword: "",
		adminEmail: "",

		// Site
		siteName: "",
		siteDescription: "",
		siteOffline: false,

		// Database
		dbType: "MySQLi",
		dbLocation: "localhost",
		dbPrefix: Joomla.makeRandomDbPrefix(),
		dbBackup: true,
		dbName: "",
		dbUsername: "",
		dbPassword: "",

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

		Install.install(['config', 'database'])

		//if (state === true) Install.install(['config']);
	};

	var langSel = document.getElementById('languageForm');

	if (langSel)
		document.getElementById('top-header').appendChild(langSel);

	var inputs = [].slice.call(document.querySelectorAll('input[type="password"], input[type="text"], input[type="email"], select'));
	console.log(inputs)
	//<select id="jform_language" class="custom-select required ml-2"></select>

	// Init installation
	window.Install = new Joomla.installation(
		Joomla.getOptions('system.installation'),
		Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php'
	);
});
