<?php
/**
 * @package	Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

// Add Stylesheets
JHtml::_('bootstrap.loadCss', true, $this->direction);
JHtml::_('stylesheet', 'installation/template/css/template.css');
JHtml::_('stylesheet', 'media/vendor/font-awesome/css/font-awesome.min.css');

// Output as HTML5
$this->setHtml5(true);

JHtml::_('behavior.core');
JHtml::_('jquery.framework');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

// Add installation js
JHtml::_('script', 'installation/template/js/installation.js', array('version' => 'auto'));

// Add Stylesheets
JHtml::_('stylesheet', 'installation/template/css/template.css', array('version' => 'auto'));

// Load JavaScript message titles
JText::script('ERROR');
JText::script('WARNING');
JText::script('NOTICE');
JText::script('MESSAGE');

// Add strings for JavaScript error translations.
JText::script('JLIB_JS_AJAX_ERROR_CONNECTION_ABORT');
JText::script('JLIB_JS_AJAX_ERROR_NO_CONTENT');
JText::script('JLIB_JS_AJAX_ERROR_OTHER');
JText::script('JLIB_JS_AJAX_ERROR_PARSE');
JText::script('JLIB_JS_AJAX_ERROR_TIMEOUT');

// Load the JavaScript translated messages
JText::script('INSTL_PROCESS_BUSY');
JText::script('INSTL_FTP_SETTINGS_CORRECT');

// Add script options
$this->addScriptOptions('system.installation', array('url' => JRoute::_('index.php')));
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<jdoc:include type="metas" />
		<jdoc:include type="styles" />
	</head>
	<body data-basepath="<?php echo JUri::root(true); ?>">
		<?php // Header ?>
		<div class="header">
			<div id="top-header" class="container container-header d-flex align-items-center justify-content-center">
				<img src="<?php echo $this->baseurl ?>/template/images/logo.svg" alt="Joomla" class="logo"/>
			</div>
		</div>
		<?php // Container ?>
		<div class="container container-main">
			<ul class="nav-steps">
				<li class="step" id="site " data-step="1">
					<a class="nav-link" href="#">Configuration</a></li>
				<li class="step" data-step="2">
					<a class="nav-link"  id="database" href="#" >Database</a>
				</li>
				<li class="step disabled " id="summary " data-step="3">
					<a class="nav-link disabled">Overview</a>
				</li>
			</ul>
			<jdoc:include type="message" />
			<div id="javascript-warning">
				<noscript>
					<div class="alert alert-danger text-center">
						<?php echo JText::_('INSTL_WARNJAVASCRIPT'); ?>
					</div>
				</noscript>
			</div>
			<div id="container-installation" class="container-installation flex no-js">
				<jdoc:include type="component" />
			</div>
			<hr>
		</div>
		<jdoc:include type="scripts" />
	</body>
</html>
