<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.aurora
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app = JFactory::getApplication();

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add template js
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add Stylesheets
JHtml::_('stylesheet', 'template.min.css', array('version' => 'auto', 'relative' => true));

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'user.js', array('version' => 'auto', 'relative' => true));

// Load optional RTL Bootstrap CSS
//JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('sidebar-left') && $this->countModules('sidebar-right'))
{
	$col = $this->params->get('sidebarLeftWidth', 3) + $this->params->get('sidebarLeftWidth', 3);
	$col = 12 - $col;
	$col = 'col-md-' . $col;
}
elseif (!$this->countModules('sidebar-left') && $this->countModules('sidebar-right'))
{
	$col = 12 - $this->params->get('sidebarRightWidth', 3);
	$col = 'col-md-' . $col;
}
elseif ($this->countModules('sidebar-left') && !$this->countModules('sidebar-right'))
{
	$col = 12 - $this->params->get('sidebarLeftWidth', 3);
	$col = 'col-md-' . $col;
}
else
{
	$col = 'col-md-12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '">';
}
elseif ($this->params->get('siteTitle'))
{
	$logo = '<span title="' . $sitename . '">' . htmlspecialchars($this->params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<img src="' . $this->baseurl . '/templates/' . $this->template . '/images/logo.svg' . '" class="logo d-inline-block align-top" alt="' . $sitename . '">';
}

// Header bottom margin
$headerMargin = !$this->countModules('banner') ? ' mb-4' : '';

// Container
$container = $params->get('fluidContainer') ? 'container-fluid' : 'container';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
	<jdoc:include type="scripts" />
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '');
	echo ($this->direction == 'rtl' ? ' rtl' : '');
?>">

<header class="header<?php echo $headerMargin; ?>">
	<nav class="navbar navbar-toggleable-md navbar-full <?php echo $container; ?>">
		<div class="navbar-brand">
			<a href="<?php echo $this->baseurl; ?>/">
				<?php echo $logo; ?>
			</a>
			<?php if ($this->params->get('siteDescription')) : ?>
				<div class="site-description"><?php echo htmlspecialchars($this->params->get('siteDescription')); ?></div>
			<?php endif; ?>
		</div>

		<?php if ($this->countModules('menu')) : ?>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="<?php echo JText::_('TPL_AURORA_TOGGLE'); ?>">
				<span class="fa fa-bars"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar">
				<jdoc:include type="modules" name="menu" style="none" />
				<?php if ($this->countModules('search')) : ?>
					<div class="form-inline">
						<jdoc:include type="modules" name="search" style="none" />
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</nav>
</header>

<jdoc:include type="modules" name="banner" style="xhtml" />

<div id="top-a" class="d-flex">
	<jdoc:include type="modules" name="top-a" style="cardGrey" />
</div>
<div id="top-b" class="d-flex">
	<jdoc:include type="modules" name="top-b" style="card" />
</div>
<div id="sidebar-left">
	<jdoc:include type="modules" name="sidebar-left" style="default" />
</div>
<div id="main-top">
	<jdoc:include type="modules" name="main-top" style="cardGrey" />
</div>
<div id="component" class="grid-block">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</div>
<div id="bradcrumbs">
	<jdoc:include type="modules" name="breadcrumbs" style="none" />
</div>
<div id="main-bottom">
	<jdoc:include type="modules" name="main-bottom" style="cardGrey" />
</div>
<div id="sidebar-right">
	<jdoc:include type="modules" name="sidebar-right" style="default" />
</div>
<div id="bottom-a" class="d-flex">
	<jdoc:include type="modules" name="bottom-a" style="cardGrey" />
</div>
<div id="bottom-b" class="d-flex">
	<jdoc:include type="modules" name="bottom-b" style="card" />
</div>
<div id="footer">
	<jdoc:include type="modules" name="footer" style="none" />
</div>
<jdoc:include type="modules" name="debug" style="none" />

<a href="#top" id="back-top" class="back-top">
	<span class="icon-arrow-up-4"><span class="sr-only"><?php echo JText::_('TPL_AURORA_BACKTOTOP'); ?></span></span>
</a>
</body>
</html>
