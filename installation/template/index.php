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
JHtml::_('stylesheet', 'installation/template/css/template.css', array('version' => 'auto'));
JHtml::_('stylesheet', 'media/vendor/font-awesome/css/font-awesome.min.css');

// Add scripts
JHtml::_('behavior.core');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('script', 'installation/template/js/template.js', array('version' => 'auto'));

// Add script options
$this->addScriptOptions('system.installation', array('url' => JRoute::_('index.php')));

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
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<jdoc:include type="metas" />
		<jdoc:include type="styles" />
	</head>
	<body data-basepath="<?php echo JUri::root(true); ?>">
		<?php // Header ?>
		<header class="header" role="banner">
			<div id="top-header" class="container container-header d-flex justify-content-center">
				<img src="<?php echo $this->baseurl ?>/template/images/logo.svg" alt="Joomla" class="logo"/>
				<ul class="nav-steps hidden">
					<li class="step active" id="site" data-step="1">
						<a class="nav-link" href="#"></a></li>
					<li class="step" data-step="2">
						<a class="nav-link"  id="database" href="#" ></a>
					</li>
					<li class="step disabled " id="summary " data-step="3">
						<a class="nav-link disabled"></a>
					</li>
				</ul>
			</div>
		</header>
		<?php // Container ?>
		<section class="container container-main" role="main">
			<jdoc:include type="message" />
			<div id="javascript-warning">
				<noscript>
					<div class="alert alert-danger text-center">
						<?php echo JText::_('INSTL_WARNJAVASCRIPT'); ?>
					</div>
				</noscript>
			</div>
			<div id="container-installation" class="container-installation flex no-js" data-base-url="<?php echo JUri::root(); ?>" style="display:none">
				<jdoc:include type="component" />
			</div>
		</section>
		<jdoc:include type="scripts" />
	</body>
</html>
