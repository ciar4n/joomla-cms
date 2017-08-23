/**
 * @package     Joomla.Installation
 * @subpackage  JavaScript
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
(function() {
	// Make sure that we have the Joomla object
	Joomla = window.Joomla || {};
	Joomla.installation = Joomla.installation || {};

	Joomla.serialiseForm = function( form ) {
		var i, l, obj = [], elements = form.querySelectorAll( "input, select, textarea" );
		for(i = 0, l = elements.length; i < l; i++) {
			var name = elements[i].name, value = elements[i].value;
			if(name) {
				obj.push(name.replace('[', '%5B').replace(']', '%5D') + '=' + value);
			}
		}
		return obj.join("&");
	};

	/**
	 * Initializes JavaScript events on each request, required for AJAX
	 */
	Joomla.pageInit = function() {
		// Attach the validator
		[].slice.call(document.querySelectorAll('form.form-validate')).forEach(function(form) {
			document.formvalidator.attachToForm(form);
		});

		// Create and append the loading layer.
		Joomla.loadingLayer("load");

		// Check for FTP credentials
		Joomla.installation = Joomla.installation || {};

		// Initialize the FTP installation data
		if (sessionStorage && sessionStorage.getItem('installation-data')) {
			var data = sessionStorage.getItem('installData').split(',');
			Joomla.installation.data = {
				ftpUsername: data[0],
				ftpPassword: data[1],
				ftpHost: data[2],
				ftpPort: data[3],
				ftpRoot: data[4]
			};
		}
		return 'Loaded...'
	};

	/* Load scripts async */
	document.addEventListener('DOMContentLoaded', function() {
		var page = document.getElementById('installer-view');

		// Show the container
		var container = document.getElementById('container-installation');
		if (container) {
			Joomla.installationBaseUrl = container.getAttribute('data-base-url');
			Joomla.installationBaseUrl += "installation/index.php"
		} else {
			throw new Error('Javascript required to be enabled!')
		}

		if (page && page.getAttribute('data-page-name')) {
			var script = document.querySelector('script[src*="template.js"]');
			el = document.createElement('script');
			el.src = script.src.replace("template.js", page.getAttribute('data-page-name') + '.js');
			document.head.appendChild(el);
		}

		if (container) {
			container.classList.remove('no-js');
			container.style.display = "block";
		}
	});
})();

