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

// Load the JavaScript behaviors
JHtml::_('bootstrap.framework');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.core');

// Add installation js
JHtml::_('script', 'installation/template/js/installation.js', array('version' => 'auto'));

// Add Stylesheets
// JHtml::_('bootstrap.loadCss', true, $this->direction);
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
		<jdoc:include type="head" />
	</head>
	<body data-basepath="<?php echo JUri::root(true); ?>" style="height: 100vh">

		<?php // Header ?>
		<div class="header">
			<div class="container container-header d-flex align-items-center justify-content-center">
				<img src="<?php echo $this->baseurl ?>/template/images/logo.svg" alt="Joomla" class="logo"/>
			</div>
		</div>
		<div class="container">
			<jdoc:include type="message" />
		</div>
		<?php // Container ?>
		<div class="container container-main">

			<div id="javascript-warning">
				<noscript>
					<div class="alert alert-danger">
						<?php echo JText::_('INSTL_WARNJAVASCRIPT'); ?>
					</div>
				</noscript>
			</div>
			<div id="container-installation" class="container-installation d-flex">
				<jdoc:include type="component" />
			</div>
			<hr>
		</div>
	</body>
</html>
