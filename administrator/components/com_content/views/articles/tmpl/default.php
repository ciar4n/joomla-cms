<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');

$app       = JFactory::getApplication();
$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = str_replace(' ' . $this->state->get('list.direction'), '', $this->state->get('list.fullordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';
$columns   = 10;

if (strpos($listOrder, 'publish_up') !== false)
{
	$orderingColumn = 'publish_up';
}
elseif (strpos($listOrder, 'publish_down') !== false)
{
	$orderingColumn = 'publish_down';
}
else
{
	$orderingColumn = 'created';
}

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_content&task=articles.saveOrderAjax&tmpl=component' . JSession::getFormToken() . '=1';
	JHtml::_('draggablelist.draggable');
}

$assoc = JLanguageAssociations::isEnabled();
?>

<form action="<?php echo JRoute::_('index.php?option=com_content&view=articles'); ?>" method="post" name="adminForm" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<div id="j-main-container" class="j-main-container">
				<?php
				// Search tools bar
				echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
				?>
				<?php if (empty($this->items)) : ?>
					<div class="alert alert-warning alert-no-items">
						<?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
					</div>
				<?php else : ?>
					<table class="table table-striped" id="articleList">
						<thead>
							<tr>
								<th style="width:3%" class="nowrap text-center hidden-sm-down">
									<?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
								</th>
								<th style="width:3%;" class="text-center">
									<?php echo JHtml::_('grid.checkall'); ?>
								</th>
   								<th style="width:5%" class="nowrap text-center">
									<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
								</th>
								<th style="width:3%" class="nowrap text-center row-actions-head">
									<div class="dropdown tools">
									  <a class="dropdown-toggle" style="color: #006898" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    Actions<span class="ml-1 fa fa-caret-down"></span>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<!-- 									  	<a class="dropdown-item" href="#">Select All</a>
									  	<div class="dropdown-divider"></div> -->
									    <a class="dropdown-item" onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.publish'); }">Publish</a>
									    <a class="dropdown-item" onclick="if (document.adminForm.boxchecked.value == 0) { Joomla.renderMessages({'error': [Joomla.JText._('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST')]}) } else { Joomla.submitbutton('articles.unpublish'); }">Unpublish</a>
									    <a class="dropdown-item" href="#">Feature</a>
									    <a class="dropdown-item" href="#">Unfeature</a>
									    <a class="dropdown-item" href="#">Archive</a>
									    <a class="dropdown-item" href="#">Batch</a>
									    <a class="dropdown-item" href="#">Trash</a>
									  </div>
									</div>
									<!-- <a href="#"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a> -->
								</th>
						
								<th style="width:28%" class="nowrap">
									<?php echo JHtml::_('searchtools.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
								</th>
								
								<th style="width:10%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort',  'JGRID_HEADING_ACCESS', 'a.access', $listDirn, $listOrder); ?>
								</th>
								<?php if ($assoc) : ?>
									<?php $columns++; ?>
									<th style="width:5%" class="nowrap hidden-sm-down text-center">
										<?php echo JHtml::_('searchtools.sort', 'COM_CONTENT_HEADING_ASSOCIATION', 'association', $listDirn, $listOrder); ?>
									</th>
								<?php endif; ?>
								<th style="width:10%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort',  'JAUTHOR', 'a.created_by', $listDirn, $listOrder); ?>
								</th>
								<th style="width:10%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'language', $listDirn, $listOrder); ?>
								</th>
								<th style="width:10%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort', 'COM_CONTENT_HEADING_DATE_' . strtoupper($orderingColumn), 'a.' . $orderingColumn, $listDirn, $listOrder); ?>
								</th>
								<th style="width:5%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
								</th>
								<?php if ($this->vote) : ?>
									<?php $columns++; ?>
									<th style="width:5%" class="nowrap hidden-sm-down text-center">
										<?php echo JHtml::_('searchtools.sort', 'JGLOBAL_VOTES', 'rating_count', $listDirn, $listOrder); ?>
									</th>
									<?php $columns++; ?>
									<th style="width:5%" class="nowrap hidden-sm-down text-center">
										<?php echo JHtml::_('searchtools.sort', 'JGLOBAL_RATINGS', 'rating', $listDirn, $listOrder); ?>
									</th>
								<?php endif; ?>
								<th style="width:5%" class="nowrap hidden-sm-down text-center">
									<?php echo JHtml::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
								</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<td colspan="<?php echo $columns; ?>">
								</td>
							</tr>
						</tfoot>
						<tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="true"<?php endif; ?>>
						<?php foreach ($this->items as $i => $item) :
							$item->max_ordering = 0;
							$ordering   = ($listOrder == 'a.ordering');
							$canCreate  = $user->authorise('core.create',     'com_content.category.' . $item->catid);
							$canEdit    = $user->authorise('core.edit',       'com_content.article.' . $item->id);
							$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
							$canEditOwn = $user->authorise('core.edit.own',   'com_content.article.' . $item->id) && $item->created_by == $userId;
							$canChange  = $user->authorise('core.edit.state', 'com_content.article.' . $item->id) && $canCheckin;
							?>
							<tr class="row<?php echo $i % 2; ?> <?php if ($item->state) {echo 'published';} else {echo 'unpublished';} ?> <?php if ($item->featured) {echo 'featured';} ?>" data-dragable-group="<?php echo $item->catid; ?>">
								<td class="order nowrap text-center hidden-sm-down" style="width:3%">
									<?php
									$iconClass = '';
									if (!$canChange)
									{
										$iconClass = ' inactive';
									}
									elseif (!$saveOrder)
									{
										$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::_('tooltipText', 'JORDERINGDISABLED');
									}
									?>
									<span class="sortable-handler<?php echo $iconClass ?>">
										<span class="icon-menu" aria-hidden="true"></span>
									</span>
									<?php if ($canChange && $saveOrder) : ?>
										<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order ">
									<?php endif; ?>
								</td>
								<td class="text-center" style="width:3%;">
									<?php echo JHtml::_('grid.id', $i, $item->id); ?>
								</td>
  								<td class="text-center column-status" style="width:5%">
									<div style="width: 86px;">
										<?php echo JHtml::_('jgrid.published', $item->state, $i, 'articles.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
										<?php if ($item->checked_out) { ?>
											<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'articles.', $canCheckin); ?>
										<?php } else { ?>
											<?php echo JHtml::_('contentadministrator.featured', $item->featured, $i, $canChange); ?>
										<?php } ?>
<!-- 										<div class="dropdown tools">
										  <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
										  </a>
										  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										    <a class="dropdown-item" href="javascript:void(0);" onclick="return listItemTask('cb2','articles.unpublish')" title="" data-original-title="Publish Item<br>Start: 2011-01-01 00:00:01">Unpublish</a>
										    <a class="dropdown-item" href="#">Feature</a>
										    <a class="dropdown-item" href="#">Trash</a>
										    <a class="dropdown-item" href="#">Archive</a>
										  </div>
										</div> -->
									</div>
								</td>
								<td style="width:3%" class="nowrap text-center row-actions">
									<div class="dropdown tools">
									  <a class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									    <a class="dropdown-item" href="javascript:void(0);" onclick="return listItemTask('cb2','articles.unpublish')" title="" data-original-title="Publish Item<br>Start: 2011-01-01 00:00:01">Unpublish</a>
									    <a class="dropdown-item" href="#">Feature</a>
									    <a class="dropdown-item" href="#">Trash</a>
									    <a class="dropdown-item" href="#">Archive</a>
									  </div>
									</div>
									<!-- <a href="#"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a> -->
								</td>
								
								<td class="has-context" style="width:28%">
									<div class="float-left break-word">
<!-- 										<?php if ($item->checked_out) : ?>
											<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'articles.', $canCheckin); ?>
										<?php endif; ?> -->
										<?php if ($item->language == '*') : ?>
											<?php $language = JText::alt('JALL', 'language'); ?>
										<?php else : ?>
											<?php $language = $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
										<?php endif; ?>
										<?php if ($canEdit || $canEditOwn) : ?>
											<a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_content&task=article.edit&id=' . $item->id); ?>" title="<?php echo JText::_('JACTION_EDIT'); ?>">
												<?php echo $this->escape($item->title); ?></a>
										<?php else : ?>
											<span title="<?php echo JText::sprintf('JFIELD_ALIAS_LABEL', $this->escape($item->alias)); ?>"><?php echo $this->escape($item->title); ?></span>
										<?php endif; ?>
										<div class="small">
											<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
										</div>
										<div class="small">
											<?php echo JText::_('JCATEGORY') . ': ' . $this->escape($item->category_title); ?>
										</div>
									</div>
								</td>

								<td class="hidden-sm-down text-center" style="width:10%">
									<?php echo $this->escape($item->access_level); ?>
								</td>
								<?php if ($assoc) : ?>
								<td class="hidden-sm-down text-center">
									<?php if ($item->association) : ?>
										<?php echo JHtml::_('contentadministrator.association', $item->id); ?>
									<?php endif; ?>
								</td>
								<?php endif; ?>
								<td class="hidden-sm-down text-center" style="width:10%">
									<?php if ($item->created_by_alias) : ?>
										<a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by); ?>" title="<?php echo JText::_('JAUTHOR'); ?>">
										<?php echo $this->escape($item->author_name); ?></a>
										<div class="small"><?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->created_by_alias)); ?></div>
									<?php else : ?>
										<a class="hasTooltip" href="<?php echo JRoute::_('index.php?option=com_users&task=user.edit&id=' . (int) $item->created_by); ?>" title="<?php echo JText::_('JAUTHOR'); ?>">
										<?php echo $this->escape($item->author_name); ?></a>
									<?php endif; ?>
								</td>
								<td class="hidden-sm-down text-center" style="width:10%">
									<?php echo JLayoutHelper::render('joomla.content.language', $item); ?>
								</td>
								<td class="nowrap hidden-sm-down text-center" style="width:10%">
									<?php
									$date = $item->{$orderingColumn};
									echo $date > 0 ? JHtml::_('date', $date, JText::_('DATE_FORMAT_LC4')) : '-';
									?>
								</td>
								<td class="hidden-sm-down text-center" style="width:5%">
									<span class="badge badge-info">
										<?php echo (int) $item->hits; ?>
									</span>
								</td>
								<?php if ($this->vote) : ?>
									<td class="hidden-sm-down text-center" style="width:5%">
										<span class="badge badge-success">
										<?php echo (int) $item->rating_count; ?>
										</span>
									</td>
									<td class="hidden-sm-down text-center" style="width:5%">
										<span class="badge badge-warning">
										<?php echo (int) $item->rating; ?>
										</span>
									</td>
								<?php endif; ?>
								<td class="hidden-sm-down text-center" style="width:5%">
									<?php echo (int) $item->id; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php // Load the batch processing form. ?>
					<?php if ($user->authorise('core.create', 'com_content')
						&& $user->authorise('core.edit', 'com_content')
						&& $user->authorise('core.edit.state', 'com_content')) : ?>
						<?php echo JHtml::_(
							'bootstrap.renderModal',
							'collapseModal',
							array(
								'title' => JText::_('COM_CONTENT_BATCH_OPTIONS'),
								'footer' => $this->loadTemplate('batch_footer')
							),
							$this->loadTemplate('batch_body')
						); ?>
					<?php endif; ?>
				<?php endif; ?>

				<?php echo $this->pagination->getListFooter(); ?>

				<input type="hidden" name="task" value="">
				<input type="hidden" name="boxchecked" value="0">
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
