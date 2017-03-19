<?php
/**
 * @package    Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var InstallationViewPreinstallHtml $this */

?>
<!--<form action="index.php" method="post" id="languageForm">-->
<!--	<div class="btn-toolbar justify-content-end">-->
<!--		<div class="btn-group">-->
<!--			<a href="#" class="btn btn-primary" onclick="Install.submitform();" title="--><?php //echo JText::_('JCHECK_AGAIN'); ?><!--"><span class="icon-refresh icon-white"></span> --><?php //echo JText::_('JCHECK_AGAIN'); ?><!--</a>-->
<!--		</div>-->
<!--	</div>-->
<!--	<div class="form-group">-->
<!--		<label for="jform_language" class="control-label">--><?php //echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?><!--</label>-->
<!--		--><?php //echo $this->form->getInput('language'); ?>
<!--	</div>-->
<!--	<input type="hidden" name="view" value="preinstall">-->
<!--	<input type="hidden" name="task" value="setlanguage">-->
<!--	--><?php //echo JHtml::_('form.token'); ?>
<!--</form>-->
<form action="index.php" method="post" id="adminForm">
		<div class="row">
			<div class="col-md-12">
				<h3><?php echo JText::_('INSTL_PRECHECK_TITLE'); ?></h3>
				<hr class="hr-condensed" />
				<p class="install-text">
				<?php echo JText::_('INSTL_PRECHECK_DESC'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 pt-3">
				<table class="table table-striped">
					<tbody>
						<?php foreach ($this->options as $option) : ?>
						<tr>
							<td class="item">
								<?php echo $option->label; ?>
							</td>
							<td>
								<span class="badge badge-<?php echo ($option->state) ? 'success' : 'danger'; ?>">
									<?php echo JText::_($option->state ? 'JYES' : 'JNO'); ?>
									<?php if ($option->notice) : ?>
										<span class="icon-info-sign icon-white hasTooltip" title="<?php echo $option->notice; ?>"></span>
									<?php endif;?>
								</span>
							</td>
							<td>
								<?php if (!$option->state) : ?>
									<button class="btn btn-outline-danger">Help me resolve this</button>
								<?php endif; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
						</tr>
					</tfoot>
				</table>
			</div>	
	</div>
	<ul class="nav nav-tabs nav-justified install-nav-footer">
		<li class="nav-item">
			<a href="#" class="nav-button prev-button" onclick="Install.submitform();" title="<?php echo JText::_('JCHECK_AGAIN'); ?>"><span class="icon-refresh icon-white"></span> <?php echo JText::_('JCHECK_AGAIN'); ?></a>
		</li>
	</ul>
	<input type="hidden" name="task" value="preinstall">
	<?php echo JHtml::_('form.token'); ?>
</form>
