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

<form action="index.php" method="post" id="languageForm">
	<div class="row">
		<div class="form-group">
			<label for="jform_language" class="control-label"><?php echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?></label>
			<?php echo $this->form->getInput('language'); ?>
		</div>
	</div>
	<input type="hidden" name="view" value="preinstall">
	<input type="hidden" name="task" value="setlanguage">
	<?php echo JHtml::_('form.token'); ?>
</form>

<form action="index.php" method="post" id="adminForm">
		<div class="row">
			<div>
				<h3>Attention<?php //echo JText::_('INSTL_PRECHECK_TITLE'); ?></h3>
				<hr class="hr-condensed" />
				<p class="install-text">We encountered some failures that needs to be resolved to continue the installation process </p>
				<?php // echo JText::_('INSTL_PRECHECK_DESC'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 pt-3">
				<table class="table table-striped">
					<tbody>
						<?php foreach ($this->options as $option) : ?>
							<?php if ($option->state) continue; ?>
						<tr>
							<td class="item">
								<?php echo $option->label; ?>
							</td>
							<td>
<!--								<span class="badge badge---><?php //echo ($option->state) ? 'success' : 'danger'; ?><!--">-->
<!--									--><?php //echo JText::_($option->state ? 'JYES' : 'JNO'); ?>
<!--									--><?php //if ($option->notice) : ?>
<!--										<span class="icon-info-sign icon-white hasTooltip" title="--><?php //echo $option->notice; ?><!--"></span>-->
<!--									--><?php //endif;?>
<!--								</span>-->
							</td>
							<td>
								<?php if (!$option->state) : ?>
									<?php if (preg_match('#configuration.php#', $option->label)) : ?>
										<span>Help me resolve this using: </span>
										<div class="btn btn-group">
											<button class="btn btn-danger">Native filesystem</button>
											<button class="btn btn-warning">FTP layer</button>
										</div>
									<?php else : ?>
										<button class="btn btn-outline-danger">Help me resolve this</button>
									<?php endif; ?>
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
<div class="hidden">
		<h3><?php echo JText::_('INSTL_FTP'); ?></h3>
		<hr class="hr-condensed" />
		<div class="form-group">
			<?php echo $this->form->getLabel('ftp_user'); ?>
			<?php echo $this->form->getInput('ftp_user'); ?>
			<p class="form-text text-muted small"><?php echo JText::_('INSTL_FTP_USER_DESC'); ?></p>
		</div>
		<div class="form-group">
			<?php echo $this->form->getLabel('ftp_pass'); ?>
			<?php echo $this->form->getInput('ftp_pass'); ?>
			<p class="form-text text-muted small"><?php echo JText::_('INSTL_FTP_PASSWORD_DESC'); ?></p>
		</div>
		<div class="form-group">
			<?php echo $this->form->getLabel('ftp_host'); ?>
			<div class="input-append">
				<?php echo $this->form->getInput('ftp_host'); ?><button id="findbutton" class="btn btn-secondary" onclick="Install.detectFtpRoot(this);"><span class="icon-folder-open"></span> <?php echo JText::_('INSTL_AUTOFIND_FTP_PATH'); ?></button>
			</div>
		</div>
		<div class="form-group">
			<?php echo $this->form->getLabel('ftp_port'); ?>
			<?php echo $this->form->getInput('ftp_port'); ?>
		</div>
		<div class="btn-toolbar justify-content-end">
			<div class="form-group">
				<button id="verifybutton" class="btn btn-success" onclick="Install.verifyFtpSettings(this);"><span class="icon-ok icon-white"></span> <?php echo JText::_('INSTL_VERIFY_FTP_SETTINGS'); ?></button>
			</div>
		</div>

</div>
	<ul class="nav nav-tabs nav-justified install-nav-footer">
		<li class="nav-item">
			<a href="#" class="nav-button prev-button disabled" onclick="Install.submitform();" title="<?php //echo JText::_('JCHECK_AGAIN'); ?>"><span class="icon-refresh icon-white"></span> Continue<?php //echo JText::_('JCHECK_AGAIN'); ?></a>
		</li>
	</ul>
	<input type="hidden" name="task" value="ftp">
	<input type="hidden" name="format" value="json">
	<?php echo JHtml::_('form.token'); ?>
</form>
<hr>

