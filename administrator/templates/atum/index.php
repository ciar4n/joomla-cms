<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Atum
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       4.0
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/** @var JDocumentHtml $this */

$app   = Factory::getApplication();
$input = $app->input;
$wa    = $this->getWebAssetManager();

// Detecting Active Variables
$option     = $input->get('option', '');
$view       = $input->get('view', '');
$layout     = $input->get('layout', 'default');
$task       = $input->get('task', 'display');
$cpanel     = $option === 'com_cpanel' || ($option === 'com_admin' && $view === 'help');
$hiddenMenu = $app->input->get('hidemainmenu');

// Getting user accessibility settings
$a11y_mono      = (bool) $app->getIdentity()->getParam('a11y_mono', '');
$a11y_contrast  = (bool) $app->getIdentity()->getParam('a11y_contrast', '');
$a11y_highlight = (bool) $app->getIdentity()->getParam('a11y_highlight', '');
$a11y_font      = (bool) $app->getIdentity()->getParam('a11y_font', '');

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'joomla-favicon-pinned.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#000']);

// Template params
$logoBrandLarge  = $this->params->get('logoBrandLarge')
	? Uri::root() . htmlspecialchars($this->params->get('logoBrandLarge'), ENT_QUOTES)
	: $this->baseurl . '/templates/' . $this->template . '/images/logos/brand-large.svg';
$logoBrandSmall = $this->params->get('logoBrandSmall')
	? Uri::root() . htmlspecialchars($this->params->get('logoBrandSmall'), ENT_QUOTES)
	: $this->baseurl . '/templates/' . $this->template . '/images/logos/brand-small.svg';

$logoBrandLargeAlt = empty($this->params->get('logoBrandLargeAlt')) && empty($this->params->get('emptyLogoBrandLargeAlt'))
	? ''
	: 'alt="' . htmlspecialchars($this->params->get('logoBrandLargeAlt'), ENT_COMPAT, 'UTF-8') . '"';
$logoBrandSmallAlt = empty($this->params->get('logoBrandSmallAlt')) && empty($this->params->get('emptyLogoBrandSmallAlt'))
	? ''
	: 'alt="' . htmlspecialchars($this->params->get('logoBrandSmallAlt'), ENT_COMPAT, 'UTF-8') . '"';

// Get the hue value
preg_match('#^hsla?\(([0-9]+)[\D]+([0-9]+)[\D]+([0-9]+)[\D]+([0-9](?:.\d+)?)?\)$#i', $this->params->get('hue', 'hsl(214,63%,20%)'), $matches);

// Enable assets
$wa->usePreset('template.atum.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'))
		->useStyle('template.active.language')
		->useStyle('template.user')
		->addInlineStyle(':root {
		--hue: ' . $matches[1] . ';
		--atum-bg-light: ' . $this->params->get('bg-light', '--atum-bg-light') . ';
		--atum-text-dark: ' . $this->params->get('text-dark', '--atum-text-dark') . ';
		--atum-text-light: ' . $this->params->get('text-light', '--atum-text-light') . ';
		--atum-link-color: ' . $this->params->get('link-color', '--atum-link-color') . ';
		--atum-special-color: ' . $this->params->get('special-color', '--atum-special-color') . ';
		--atum-sidebar-link-color: ' . $this->params->get('sidebar-link-color', '--atum-sidebar-link-color') . ';
	}');

// Override 'template.active' asset to set correct ltr/rtl dependency
$wa->registerStyle('template.active', '', [], [], ['template.atum.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr')]);

// Set some meta data
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
// @TODO sync with _variables.scss
$this->setMetaData('theme-color', '#1c3d5c');

$monochrome = (bool) $this->params->get('monochrome');

Text::script('TPL_ATUM_MORE_ELEMENTS');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"<?php echo $a11y_font ? ' class="a11y_font"' : ''; ?>>
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
</head>

<body class="admin <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($task ? ' task-' . $task : '') . ($monochrome || $a11y_mono ? ' monochrome' : '') . ($a11y_contrast ? ' a11y_contrast' : '') . ($a11y_highlight ? ' a11y_highlight' : ''); ?>">
<noscript>
	<div class="alert alert-danger" role="alert">
		<?php echo Text::_('JGLOBAL_WARNJAVASCRIPT'); ?>
	</div>
</noscript>

<jdoc:include type="modules" name="customtop" style="none" />

<?php // Header ?>
<header id="header" class="header">
	<div class="d-flex">
		<div class="header-title d-flex">
			<div class="d-flex align-items-center">
				<?php // No home link in edit mode (so users can not jump out) and control panel (for a11y reasons) ?>
				<?php if ($hiddenMenu || $cpanel) : ?>
					<div class="logo">
					<img src="<?php echo $logoBrandLarge; ?>" <?php echo $logoBrandLargeAlt; ?>>
					<img class="logo-collapsed" src="<?php echo $logoBrandSmall; ?>" <?php echo $logoBrandSmallAlt; ?>>
					</div>
				<?php else : ?>
					<a class="logo" href="<?php echo Route::_('index.php'); ?>"
						aria-label="<?php echo Text::_('TPL_ATUM_BACK_TO_CONTROL_PANEL'); ?>">
						<img src="<?php echo $logoBrandLarge; ?>" <?php echo $logoBrandLargeAlt; ?>>
						<img class="logo-collapsed" src="<?php echo $logoBrandSmall; ?>" <?php echo $logoBrandSmallAlt; ?>>
					</a>
				<?php endif; ?>
			</div>
			<jdoc:include type="modules" name="title" />
		</div>
		<div class="header-items d-flex ms-auto">
			<jdoc:include type="modules" name="status" style="header-item" />
		</div>
	</div>
</header>

<?php // Wrapper ?>
<div id="wrapper" class="d-flex wrapper<?php echo $hiddenMenu ? '0' : ''; ?>">
	<?php // Sidebar ?>
	<?php if (!$hiddenMenu) : ?>
	<?php HTMLHelper::_('bootstrap.collapse', '.toggler-burger'); ?>
		<button class="navbar-toggler toggler-burger collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-wrapper" aria-controls="sidebar-wrapper" aria-expanded="false" aria-label="<?php echo Text::_('JTOGGLE_SIDEBAR_MENU'); ?>">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div id="sidebar-wrapper" class="sidebar-wrapper sidebar-menu" <?php echo $hiddenMenu ? 'data-hidden="' . $hiddenMenu . '"' : ''; ?>>
			<div id="sidebarmenu" class="sidebar-sticky">
				<div class="sidebar-toggle item item-level-1">
					<a id="menu-collapse" href="#" aria-label="<?php echo Text::_('JTOGGLE_SIDEBAR_MENU'); ?>">
						<span id="menu-collapse-icon" class="icon-toggle-off icon-fw" aria-hidden="true"></span>
						<span class="sidebar-item-title"><?php echo Text::_('JTOGGLE_SIDEBAR_MENU'); ?></span>
					</a>
				</div>
				<jdoc:include type="modules" name="menu" style="none" />
			</div>
		</div>
	<?php endif; ?>

	<?php // container-fluid ?>
	<div class="container-fluid container-main">
		<?php if (!$cpanel) : ?>
			<?php // Subheader ?>
			<?php HTMLHelper::_('bootstrap.collapse', '.toggler-toolbar'); ?>
			<button class="navbar-toggler toggler-toolbar toggler-burger collapsed" type="button" data-bs-toggle="collapse" data-bs-target=".subhead" aria-controls="subhead" aria-expanded="false" aria-label="<?php echo Text::_('TPL_ATUM_TOOLBAR'); ?>">
				<span class="toggler-toolbar-icon"></span>
			</button>
			<div id="subhead" class="subhead mb-3">
				<div id="container-collapse" class="container-collapse"></div>
				<div class="row">
					<div class="col-md-12">
						<jdoc:include type="modules" name="toolbar" style="none" />
					</div>
				</div>
			</div>
		<?php endif; ?>
		<section id="content" class="content">
			<?php // Begin Content ?>
			<jdoc:include type="modules" name="top" style="xhtml" />
			<div class="row">
				<div class="col-md-12">
					<main>
						<jdoc:include type="message" />
						<jdoc:include type="component" />
					</main>
				</div>
				<?php if ($this->countModules('bottom')) : ?>
					<jdoc:include type="modules" name="bottom" style="xhtml" />
				<?php endif; ?>
			</div>
			<?php // End Content ?>
		</section>
	</div>
</div>
<jdoc:include type="modules" name="debug" style="none" />
<jdoc:include type="scripts" />
</body>
</html>
