<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Atum
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       4.0
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$lang            = JFactory::getLanguage();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;
$input           = $app->input;

// Add JavaScript
JHtml::_('bootstrap.framework');
JHtml::_('script', 'media/vendor/flying-focus-a11y/js/flying-focus.min.js', array('version' => 'auto'));
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add Stylesheets
JHtml::_('stylesheet', 'template.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

// Load specific language related CSS
$languageCss = 'language/' . $lang->getTag() . '/' . $lang->getTag() . '.css';

if (file_exists($languageCss) && filesize($languageCss) > 0)
{
	JHtml::_('stylesheet', $languageCss, array('version' => 'auto'));
}

// Load custom.css
$customCss = 'templates/' . $this->template . '/css/custom.css';

if (file_exists($customCss) && filesize($customCss) > 0)
{
	JHtml::_('stylesheet', $customCss, array('version' => 'auto'));
}

// Detecting Active Variables
$option      = $input->get('option', '');
$view        = $input->get('view', '');
$layout      = $input->get('layout', '');
$task        = $input->get('task', '');
$itemid      = $input->get('Itemid', '');
$sitename    = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');
$cpanel      = ($option === 'com_cpanel');
$hidden      = $app->input->get('hidemainmenu');
$logoLg      = $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';
$logoSm      = $this->baseurl . '/templates/' . $this->template . '/images/logo-icon.svg';

// Set some meta data
$doc->setMetaData('viewport', 'width=device-width, initial-scale=1');
// @TODO sync with _variables.scss
$doc->setMetaData('theme-color', '#1c3d5c');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="head" />
</head>

<body class="admin <?php echo $option . ' view-' . $view . ' layout-' . $layout . ' task-' . $task . ' itemid-' . $itemid; ?>">

	<noscript>
		<div class="alert alert-danger" role="alert">
			<?php echo JText::_('JGLOBAL_WARNJAVASCRIPT'); ?>
		</div>
	</noscript>

	<?php // Wrapper ?>
	<div id="wrapper" class="wrapper<?php echo $hidden ? '0' : ''; ?>">

		<?php // Sidebar ?>
		<?php if (!$hidden) : ?>
		<div id="sidebar-wrapper" class="sidebar-wrapper" <?php echo $hidden ? 'data-hidden="' . $hidden . '"' :''; ?>>
			<div id="main-brand" class="main-brand align-items-center">
				<a href="<?php echo JRoute::_('index.php'); ?>" aria-label="<?php echo JText::_('TPL_BACK_TO_CONTROL_PANEL'); ?>">
					<img src="<?php echo $logoLg; ?>" class="logo" alt="<?php echo $sitename;?>">
				</a>
			</div>
			<jdoc:include type="modules" name="menu" style="none" />
		</div>
		<?php endif; ?>

		<?php // Header ?>
		<header id="header" class="header">
			<div class="container-fluid">
				<div class="d-flex">
					<div class="d-flex col">
						<div class="menu-collapse">
							<a id="menu-collapse" class="menu-toggle" href="#">
								<span class="menu-toggle-icon fa fa-chevron-left fa-fw" aria-hidden="true">
									<span class="sr-only"><?php echo JText::_('TPL_ATUM_CONTROL_PANEL_MENU'); ?></span>
								</span>
							</a>
						</div>

						<div class="container-title hidden-md-down">
							<jdoc:include type="modules" name="title" />
						</div>
					</div>

					<a class="navbar-brand d-flex col justify-content-center align-items-center hidden-md-down" href="<?php echo JUri::root(); ?>" title="<?php echo JText::sprintf('TPL_ATUM_PREVIEW', $sitename); ?>" target="_blank">
						<?php echo JHtml::_('string.truncate', $sitename, 28, false, false); ?>
						<span class="icon-out-2 small"></span>
					</a>

					<div class="container-title hidden-lg-up col">
						<jdoc:include type="modules" name="title" />
					</div>

					<nav class="d-flex col justify-content-end">
						<ul class="nav text-center">
							<li class="nav-item">
								<a class="nav-link dropdown-toggle" href="<?php echo JRoute::_('index.php?option=com_messages'); ?>" title="<?php echo JText::_('TPL_ATUM_PRIVATE_MESSAGES'); ?>">
									<span class="fa fa-envelope"><span class="sr-only"><?php echo JText::_('TPL_ATUM_PRIVATE_MESSAGES'); ?></span>
									<?php $countUnread = JFactory::getSession()->get('messages.unread'); ?>
									<?php if ($countUnread > 0) : ?>
										<span class="badge badge-pill badge-success"><?php echo $countUnread; ?></span>
									<?php endif; ?>
								</a>
							</li>
							<?php
								try
								{
									$messagesModel = new \Joomla\Component\Postinstall\Administrator\Model\Messages(array('ignore_request' => true));
									$messages      = $messagesModel->getItems();
								}
								catch (RuntimeException $e)
								{
									$messages = array();

									// Still render the error message from the Exception object
									JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');
								}
								$lang->load('com_postinstall', JPATH_ADMINISTRATOR, 'en-GB', true);
							?>
							<?php if ($user->authorise('core.manage', 'com_postinstall')) : ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" title="<?php echo JText::_('TPL_ATUM_POST_INSTALLATION_MESSAGES'); ?>">
									<span class="fa fa-bell"></span>
									<?php if (count($messages) > 0) : ?>
										<span class="badge badge-pill badge-success"><?php echo count($messages); ?></span>
									<?php endif; ?>
								</a>
								<div class="dropdown-menu dropdown-menu-right dropdown-notifications">
									<div class="list-group">
										<?php if (empty($messages)) : ?>
										<p class="list-group-item text-center">
											<b><?php echo JText::_('COM_POSTINSTALL_LBL_NOMESSAGES_TITLE'); ?></b>
										</p>
										<?php endif; ?>
										<?php foreach ($messages as $message) : ?>
										<a href="<?php echo JRoute::_('index.php?option=com_postinstall&amp;eid=700'); ?>" class="list-group-item list-group-item-action">
											<h5 class="list-group-item-heading"><?php echo JHtml::_('string.truncate', JText::_($message->title_key), 28, false, false); ?></h5>
											<p class="list-group-item-text small">
												<?php echo JHtml::_('string.truncate', JText::_($message->description_key), 120, false, false); ?>
											</p>
										</a>
										<?php endforeach; ?>
									</div>
								</div>
							</li>
							<?php endif; ?>
							<li class="nav-item dropdown header-profile">
								<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
									<span class="fa fa-user">
										<span class="sr-only"><?php echo JText::_('TPL_ATUM_ADMIN_USER_MENU'); ?></span>
									</span>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<div class="dropdown-item header-profile-user">
										<span class="fa fa-user"></span>
										<?php echo $user->name; ?>
									</div>
									<?php $route = 'index.php?option=com_admin&amp;task=profile.edit&amp;id=' . $user->id; ?>
									<a class="dropdown-item" href="<?php echo JRoute::_($route); ?>">
										<?php echo JText::_('TPL_ATUM_EDIT_ACCOUNT'); ?></a>
									<a class="dropdown-item" href="<?php echo JRoute::_('index.php?option=com_login&task=logout&'
										. JSession::getFormToken() . '=1') ?>"><?php echo JText::_('TPL_ATUM_LOGOUT'); ?></a>
								</div>
							</li>
						</ul>
					</nav>

				</div>
			</div>
		</header>

		<?php // container-fluid ?>
		<div class="container-fluid container-main">
		<div class="sidebar-nav">
			<ul class="nav flex-row">
				<li class="active">
					<a href="index.php?option=com_content&view=articles">Articles</a>
				</li>
				<li>
					<a href="index.php?option=com_categories&extension=com_content">Categories</a>
				</li>
				<li>
					<a href="index.php?option=com_fields&context=com_content.article">Fields</a>
				</li>
				<li>
					<a href="index.php?option=com_fields&view=groups&context=com_content.article">Field Groups</a>
				</li>
				<li>
					<a href="index.php?option=com_content&view=featured">Featured Articles</a>
				</li>
			</ul>
		</div>
			<?php if (!$cpanel) : ?>
				<?php // Subheader ?>
				<a class="btn btn-subhead hidden-md-up" data-toggle="collapse" data-target=".subhead-collapse"><?php echo JText::_('TPL_ATUM_TOOLBAR'); ?>
					<span class="icon-wrench"></span></a>
				<div class="subhead-collapse" data-scroll="<?php echo $hidden; ?>">
					<div id="subhead" class="subhead">
						<div class="container-fluid">
							<div id="container-collapse" class="container-collapse"></div>
							<div class="row">
								<div class="col-md-12">
									<!-- <jdoc:include type="modules" name="toolbar" style="no" /> -->

								<div class="btn-toolbar d-flex" role="toolbar" aria-label="Toolbar" id="toolbar">
									<button onclick="Joomla.submitbutton('article.add');" class="toolbar-new btn btn-sm btn-success">
										<span class="icon-new"></span>
										<span class="text">New</span></button>

									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.publish'); }" class="toolbar-publish select-action btn btn-sm btn-success">
										<span class="icon-publish"></span>
										Publish</button>

									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.unpublish'); }" class="toolbar-unpublish select-action btn btn-sm btn-danger">
										<span class="icon-unpublish"></span>
										Unpublish</button>

									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.featured'); }" class="toolbar-feature select-action btn btn-sm btn-warning">
										<span class="icon-featured"></span>
										Feature</button>

									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.unfeatured'); }" class="toolbar-unfeature select-action btn btn-sm btn-primary">
										<span class="icon-unfeatured"></span>
										Unfeature</button>

									<!-- <i class="fa fa-ellipsis-h" aria-hidden="true"></i> -->

<!-- 									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.archive'); }" class="select-action btn btn-sm btn-primary">
										<span class="icon-archive"></span>
										Archive</button>

									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.checkin'); }" class="select-action btn btn-sm btn-outline-primary">
										<span class="icon-checkin"></span>
										Check-in</button>
									<button data-toggle="modal" onclick="if (document.adminForm.boxchecked.value==0){Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]})}else{jQuery( '#collapseModal' ).modal('show'); return true;}" class="select-action btn btn-outline-primary btn-sm">
										<span class="icon-checkbox-partial" title="Batch"></span>
										Batch</button>

									<button onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.trash'); }" class="select-action btn btn-sm btn-outline-primary">
										<span class="icon-trash"></span>
										Trash</button> -->

									<div class="dropdown">
									  <button class="select-action btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  <span class="fa fa-ellipsis-h" title="Batch"></span>
									    More
									  </button>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									    <a class="dropdown-item" href="#">Archive</a>
									    <a class="dropdown-item" href="#">Check-in</a>
									    <a class="dropdown-item" href="#">Batch</a>
									    <a class="dropdown-item" href="#">Trash</a>
									  </div>
									</div>

									<button onclick="location.href='index.php?option=com_config&amp;view=component&amp;component=com_content&amp;path=&amp;return=aHR0cDovL2xvY2FsaG9zdC9qb29tbGEtNC1kZXYvYWRtaW5pc3RyYXRvci9pbmRleC5waHA%2Fb3B0aW9uPWNvbV9jb250ZW50';" class="btn btn-outline-danger btn-sm ml-auto">
										<span class="icon-options"></span>
										Options</button>
									<button onclick="Joomla.popupWindow('https://help.joomla.org/proxy?keyref=Help40:Content_Article_Manager&amp;lang=en', 'Help', 700, 500, 1)" rel="help" class="btn btn-outline-info btn-sm">
										<span class="icon-question-sign"></span>
										Help</button>


								</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

			<section id="content" class="content">
				<?php // Begin Content ?>
				<jdoc:include type="modules" name="top" style="xhtml" />
				<div class="row">
					<div class="col-md-12">
						<jdoc:include type="component" />
					</div>

					<?php if ($this->countModules('bottom')) : ?>
						<jdoc:include type="modules" name="bottom" style="xhtml" />
					<?php endif; ?>
				</div>
				<?php // End Content ?>
			</section>

			<?php if (!$this->countModules('status')) : ?>
				<footer class="footer">
					<p class="text-center">
						<jdoc:include type="modules" name="footer" style="no" />
						&copy; <?php echo $sitename; ?> <?php echo date('Y'); ?></p>
				</footer>
			<?php endif; ?>

			<?php if ($this->countModules('status')) : ?>
				<?php // Begin Status Module ?>
				<nav id="status" class="status navbar fixed-bottom hidden-sm-down">
					<ul class="nav d-flex justify-content-start">
						<jdoc:include type="modules" name="status" style="no" />
						<li class="ml-auto">
							<jdoc:include type="modules" name="footer" style="no" />
							&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
						</li>
					</ul>
				</nav>
				<?php // End Status Module ?>
			<?php endif; ?>

			<div class="notify-alerts">
				<jdoc:include type="message" />
			</div>

		</div>

	</div>

	<jdoc:include type="modules" name="debug" style="none" />

</body>
</html>
