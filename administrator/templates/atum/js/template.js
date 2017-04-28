/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Atum
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       4.0
 */

(function() {
	"use strict";

	document.addEventListener('DOMContentLoaded', function() {
		var wrapper = document.getElementById('wrapper');

		/** http://stackoverflow.com/questions/18663941/finding-closest-element-without-jquery */
		function closest(el, selector) {
			var parent;

			// traverse parents
			while (el) {
				parent = el.parentElement;
				if (parent && parent['matches'](selector)) {
					return parent;
				}
				el = parent;
			}

			return null;
		}

		/**
		 * Bootstrap tooltips
		 */
		jQuery('*[rel=tooltip]').tooltip({
			html: true
		});

		// Fix toolbar and footer width for edit views
		if (document.getElementById('wrapper').classList.contains('wrapper0')) {
			document.querySelector('.subhead').style.left = 0;
			document.getElementById('status').style.marginLeft = 0;
		}
		if (document.getElementById('sidebar-wrapper') && !document.getElementById('sidebar-wrapper').getAttribute('data-hidden')) {
			/** Sidebar */
			var sidebar       = document.getElementById('sidebar-wrapper'),
			    menu          = sidebar.querySelector('#menu'),
			    logo          = document.getElementById('main-brand'),
			    logoSm        = document.getElementById('main-brand-sm'),
			    menuToggle    = document.getElementById('header').querySelector('.menu-toggle'),
			    wrapperClosed = document.querySelector('#wrapper.closed'),
			    // Apply 2nd level collapse
			    first         = menu.querySelectorAll('.collapse-level-1');

			for (var i = 0; i < first.length; i++) {
				var second = first[i].querySelectorAll('.collapse-level-1');
				for (var j = 0; j < second.length; j++) {
					if (second[j]) {
						second[j].classList.remove('collapse-level-1');
						second[j].classList.add('collapse-level-2');
					}
				}
			}

			var menuClose = function() {
				sidebar.querySelector('.collapse').classList.remove('in');
				sidebar.querySelector('.collapse-arrow').classList.add('collapsed');
			};

			// Toggle menu
			menuToggle.addEventListener('click', function(e) {
				wrapper.classList.toggle("closed");

				var listItems = document.querySelectorAll('.main-nav li');
				for (var i = 0; i < listItems.length; i++) {
				 	listItems[i].classList.remove('open');
				}
				document.querySelector('.child-open').classList.remove('child-open');
			});
			

			/**
			 * Sidebar Nav
			 */

			var allLinks     = wrapper.querySelectorAll("a.no-dropdown, a.collapse-arrow"),
			    currentUrl   = window.location.href.toLowerCase(),
			    mainNav      = document.getElementById('menu'),
		 	    menuParents  = mainNav.querySelectorAll('li.parent > a'),
			    subMenuClose = mainNav.querySelectorAll('li.parent .close');

			// Set active class
			for (var i = 0; i < allLinks.length; i++) {
				if (currentUrl === allLinks[i].href) {
					allLinks[i].classList.add('active');
					// Auto Expand First Level
					if (!allLinks[i].parentNode.classList.contains('parent')) {
						mainNav.classList.add('child-open');
						allLinks[i].closest('.collapse-level-1').parentNode.classList.add('open');
					}
				}
			}
			
			// Child open toggle
			function openToggle() {
				var menuItem = this.parentNode;

				if (menuItem.classList.contains('open')) {
					menuItem.classList.remove('open');
					mainNav.classList.remove('child-open');
				}
				else {
					var siblings = menuItem.parentNode.children;
					for (var i = 0; i < siblings.length; i++) {
					 	siblings[i].classList.remove('open');
					}
					wrapper.classList.remove('closed');
					menuItem.classList.add('open');
					mainNav.classList.add('child-open');
				}
			}

			for (var i = 0; i < menuParents.length; i += 1) {
			 	menuParents[i].addEventListener('click', openToggle);
			}

			// Menu close 
			for(var i=0;i<subMenuClose.length;i++){
				subMenuClose[i].addEventListener('click', function(e) {
					var menuChildOpen = mainNav.querySelectorAll('.open');

					for (var i = 0; i < menuChildOpen.length; i++) {
						menuChildOpen[i].classList.remove('open');
					}
					mainNav.classList.remove('child-open');	
				});
			}

			/** Accessibility */
			var allLiEl = sidebar.querySelectorAll('ul[role="menubar"] li');
			for (var i = 0; i < allLiEl.length; i++) {
				// We care for enter and space
				allLiEl[i].addEventListener('keyup', function(e) { if (e.keyCode == 32 || e.keyCode == 13 ) e.target.querySelector('a').click(); });
			}

			// Set the height of the menu to prevent overlapping
			var setMenuHeight = function() {
				var height = document.getElementById('header').offsetHeight + document.getElementById('main-brand').offsetHeight;
				document.getElementById('menu').height = window.height - height ;
			};

			setMenuHeight();

			// Remove 'closed' class on resize
			window.addEventListener('resize', function() {
				setMenuHeight();
			});

			if (typeof(Storage) !== 'undefined') {
				if (localStorage.getItem('adminMenuState') == "true") {
					menuClose();
				}
			}

		} else {
			if (document.getElementById('sidebar-wrapper')) {
				document.getElementById('sidebar-wrapper').style.display = 'none';
				document.getElementById('sidebar-wrapper').style.width = '0';
			}

			if (document.getElementsByClassName('wrapper').length)
				document.getElementsByClassName('wrapper')[0].style.paddingLeft = '0';
		}



		/**
		 * Turn radios into btn-group
		 */
		var container = document.querySelectorAll('.btn-group');
		for (var i = 0; i < container.length; i++) {
			var labels = container[i].querySelectorAll('label');
			for (var j = 0; j < labels.length; j++) {
				labels[j].classList.add('btn');
				if ((j % 2) == 1) {
					labels[j].classList.add('btn-outline-danger');
				} else {
					labels[j].classList.add('btn-outline-success');

				}
			}
		}

		var btnNotActive = document.querySelector('.btn-group label:not(.active)');
		if (btnNotActive) {
			btnNotActive.addEventListener('click', function(event) {
				var label = event.target,
					input = document.getElementById(label.getAttribute('for'));

				if (input.getAttribute('checked') !== 'checked') {
					var label = closest(label, '.btn-group').querySelector('label');
					label.classList.remove('active');
					label.classList.remove('btn-success');
					label.classList.remove('btn-danger');
					label.classList.remove('btn-primary');

					if (closest(label, '.btn-group').classList.contains('btn-group-reversed')) {
						if (!label.classList.contains('btn')) label.classList.add('btn');
						if (input.value == '') {
							label.classList.add('active');
							label.classList.add('btn');
							label.classList.add('btn-outline-primary');
						} else if (input.value == 0) {
							label.classList.add('active');
							label.classList.add('btn');
							label.classList.add('btn-outline-success');
						} else {
							label.classList.add('active');
							label.classList.add('btn');
							label.classList.add('btn-outline-danger');
						}
					} else {
						if (input.value == '') {
							label.classList.add('active');
							label.classList.add('btn');
							label.classList.add('btn-outline-primary');
						} else if (input.value == 0) {
							label.classList.add('active');
							label.classList.add('btn');
							label.classList.add('btn-outline-danger');
						} else {
							label.classList.add('active');
							label.classList.add('btn');
							label.classList.add('btn-outline-success');
						}
					}
					input.setAttribute('checked', true);
					//input.dispatchEvent('change');
				}
			});
		}

		var btsGrouped = document.querySelectorAll('.btn-group input[checked=checked]');
		for (var i = 0, l = btsGrouped.length; l>i; i++) {
			var self   = btsGrouped[i],
			    attrId = self.id;
			if (self.parentNode.parentNode.classList.contains('btn-group-reversed')) {
				var label = document.querySelector('label[for=' + attrId + ']');
				if (self.value == '') {
					label.classList.add('active');
					label.classList.add('btn');
					label.classList.add('btn-outline-primary');
				} else if (self.value == 0) {
					label.classList.add('active');
					label.classList.add('btn');
					label.classList.add('btn-outline-success');
				} else {
					label.classList.add('active');
					label.classList.add('btn');
					label.classList.add('btn-outline-danger');
				}
			} else {
				var label = document.querySelector('label[for=' + attrId + ']');
				if (self.value == '') {
					label.classList.add('active');
					label.classList.add('btn-outline-primary');
				} else if (self.value == 0) {
					label.classList.add('active');
					label.classList.add('btn');
					label.classList.add('btn-outline-danger');
				} else {
					label.classList.add('active');
					label.classList.add('btn');
					label.classList.add('btn-outline-success');
				}
			}
		}

		/**
		 * Sticky Toolbar
		 */
		var navTop;
		var isFixed = false;

		processScrollInit();
		processScroll();

		document.addEventListener('resize', processScrollInit, false);
		document.addEventListener('scroll', processScroll);

		function processScrollInit() {
			var subhead = document.getElementById('subhead');

			if (subhead) {
				navTop = document.querySelector('.subhead').offsetHeight;

				if (document.getElementById('sidebar-wrapper') && document.getElementById('sidebar-wrapper').style.display === 'none') {
					subhead.style.left = 0;
				}

				// Only apply the scrollspy when the toolbar is not collapsed
				if (document.body.clientWidth > 480) {
					document.querySelector('.subhead-collapse').style.height = document.querySelector('.subhead').style.height;
					subhead.style.width = 'auto';
				}
			}
		}

		function processScroll() {
			var subhead = document.getElementById('subhead');

			if (subhead) {
				var scrollTop = (window.pageYOffset || subhead.scrollTop)  - (subhead.clientTop || 40);

				if (scrollTop >= navTop && !isFixed) {
					isFixed = true;
					subhead.classList.add('subhead-fixed');

					if (document.getElementById('sidebar-wrapper') && document.getElementById('sidebar-wrapper').style.display === 'none') {
						subhead.style.left = 0;
					}
				} else if (scrollTop <= navTop && isFixed) {
					isFixed = false;
					subhead.classList.remove('subhead-fixed');
				}
			}
		}
	});
})();
