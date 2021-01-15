<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_tags
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Tags\Site\Helper\RouteHelper;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('com_tags.tag-default');

// Get the user object.
$user = Factory::getUser();

// Check if user is allowed to add/edit based on tags permissions.
// Do we really have to make it so people can see unpublished tags???
$canEdit      = $user->authorise('core.edit', 'com_tags');
$canCreate    = $user->authorise('core.create', 'com_tags');
$canEditState = $user->authorise('core.edit.state', 'com_tags');
?>
<div class="com-tags__items">
	<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
		<?php if ($this->params->get('filter_field') || $this->params->get('show_pagination_limit')) : ?>
			<?php if ($this->params->get('filter_field')) : ?>
				<div class="com-tags-tags__filter btn-group">
					<label class="filter-search-lbl sr-only" for="filter-search">
						<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL'); ?>
					</label>
					<input
						type="text"
						name="filter-search"
						id="filter-search"
						value="<?php echo $this->escape($this->state->get('list.filter')); ?>"
						class="inputbox" onchange="document.adminForm.submit();"
						placeholder="<?php echo Text::_('COM_TAGS_TITLE_FILTER_LABEL'); ?>"
					>
					<button type="submit" name="filter_submit" class="btn btn-primary"><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button>
					<button type="reset" name="filter-clear-button" class="btn btn-secondary"><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button>
				</div>
			<?php endif; ?>
			<?php if ($this->params->get('show_pagination_limit')) : ?>
				<div class="btn-group float-end">
					<label for="limit" class="sr-only">
						<?php echo Text::_('JGLOBAL_DISPLAY_NUM'); ?>
					</label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
			<?php endif; ?>

			<input type="hidden" name="limitstart" value="">
			<input type="hidden" name="task" value="">
		<?php endif; ?>
	</form>

	<?php if (empty($this->items)) : ?>
		<div class="alert alert-info">
			<span class="icon-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span>
			<?php echo Text::_('COM_TAGS_NO_ITEMS'); ?>
		</div>
	<?php else : ?>
		<ul class="com-tags-tag__category category list-group">
			<?php foreach ($this->items as $i => $item) : ?>
				<?php if ($item->core_state == 0) : ?>
					<li class="list-group-item-danger">
				<?php else : ?>
					<li class="list-group-item list-group-item-action">
				<?php endif; ?>
				<?php if (($item->type_alias === 'com_users.category') || ($item->type_alias === 'com_banners.category')) : ?>
					<h3>
						<?php echo $this->escape($item->core_title); ?>
					</h3>
				<?php else : ?>
					<h3>
						<a href="<?php echo Route::_($item->link); ?>">
							<?php echo $this->escape($item->core_title); ?>
						</a>
					</h3>
				<?php endif; ?>
				<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
				<?php echo $item->event->afterDisplayTitle; ?>
				<?php $images  = json_decode($item->core_images); ?>
				<?php if ($this->params->get('tag_list_show_item_image', 1) == 1 && !empty($images->image_intro)) : ?>
					<a href="<?php echo Route::_(RouteHelper::getItemRoute($item->content_item_id, $item->core_alias, $item->core_catid, $item->core_language, $item->type_alias, $item->router)); ?>">
						<img src="<?php echo htmlspecialchars($images->image_intro); ?>"
							alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>">
					</a>
				<?php endif; ?>
				<?php if ($this->params->get('tag_list_show_item_description', 1)) : ?>
					<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
					<?php echo $item->event->beforeDisplayContent; ?>
					<span class="tag-body">
						<?php echo HTMLHelper::_('string.truncate', $item->core_body, $this->params->get('tag_list_item_maximum_characters')); ?>
					</span>
					<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
					<?php echo $item->event->afterDisplayContent; ?>
				<?php endif; ?>
					</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
