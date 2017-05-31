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
	<div class="btn-toolbar justify-content-end">
		<div class="btn-group">
			<a href="#" class="btn btn-primary" onclick="Install.submitform();" title="<?php echo JText::_('JCHECK_AGAIN'); ?>"><span class="icon-refresh icon-white"></span> <?php echo JText::_('JCHECK_AGAIN'); ?></a>
		</div>
	</div>
<!-- 	<div class="form-group row">
		<label for="jform_language" class="control-label"><?php echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?></label>
		<?php echo $this->form->getInput('language'); ?>
	</div>
	<input type="hidden" name="view" value="preinstall">
	<input type="hidden" name="task" value="setlanguage">
	<?php echo JHtml::_('form.token'); ?> -->
</form>
<form action="index.php" method="post" id="adminForm">
	<div class="row">
		<div class="col-md-12 mb-4">
			<h3><?php echo JText::_('INSTL_PRECHECK_TITLE'); ?></h3>
			<hr>
			<p class="install-text">
				<?php echo JText::_('INSTL_PRECHECK_DESC'); ?>
			</p>	
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<?php foreach ($this->options as $option) : ?>
					<?php if ($option->state === 'JNO' || $option->state === false) : ?>
					<div class="alert preinstall-alert">		
						<strong><?php echo $option->label; ?></strong>
						<p class="form-text text-muted small"><?php echo $option->notice; ?></p>
					</div>
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div>
			<?php if ($option->state === false && preg_match('$configuration.php$', $option->label)) : ?>
			<div id="ftpOptions" class="ftp-options mb-4">
				<form action="index.php" method="post" id="adminForm" class="form-validate">
<!-- 					<h3><?php echo JText::_('INSTL_FTP'); ?></h3>
					<hr> -->
					<div class="form-group row">
						<div class="col-md-8 offset-md-2">
							<?php echo $this->form->getLabel('ftp_user'); ?>
							<?php echo $this->form->getInput('ftp_user'); ?>
							<p class="form-text text-muted small"><?php echo JText::_('INSTL_FTP_USER_DESC'); ?></p>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 offset-md-2">
							<?php echo $this->form->getLabel('ftp_pass'); ?>
							<?php echo $this->form->getInput('ftp_pass'); ?>
							<p class="form-text text-muted small"><?php echo JText::_('INSTL_FTP_PASSWORD_DESC'); ?></p>
						</div>
					</div>
					<div class="form-group row mb-4">
						<div class="col-md-8 offset-md-2">
							<?php echo $this->form->getLabel('ftp_host'); ?>
							<div class="input-append d-flex">
								<?php echo $this->form->getInput('ftp_host'); ?><button id="findbutton" class="btn btn-secondary ml-2" onclick="Install.detectFtpRoot(this);"><span class="icon-folder-open"></span> <?php echo JText::_('INSTL_AUTOFIND_FTP_PATH'); ?></button>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 offset-md-2">
							<?php echo $this->form->getLabel('ftp_port'); ?>
							<?php echo $this->form->getInput('ftp_port'); ?>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-8 offset-md-2 justify-content-end d-flex">
							<button id="verifybutton" class="btn btn-success" onclick="Install.verifyFtpSettings(this);"><span class="icon-ok icon-white"></span> <?php echo JText::_('INSTL_VERIFY_FTP_SETTINGS'); ?></button>
						</div>
					</div>
					<input type="hidden" name="task" value="ftp">
					<input type="hidden" name="format" value="json">
					<?php echo JHtml::_('form.token'); ?>
				</form>
			</div>
			<?php endif; ?>
		</div>
		<div class="col-md-12">
			<h3><?php echo JText::_('INSTL_PRECHECK_RECOMMENDED_SETTINGS_TITLE'); ?></h3>
			<hr>
			<p class="install-text"><?php echo JText::_('INSTL_PRECHECK_RECOMMENDED_SETTINGS_DESC'); ?></p>
			<table class="table table-striped table-sm">
				<thead>
					<tr>
						<th>
							<?php echo JText::_('INSTL_PRECHECK_DIRECTIVE'); ?>
						</th>
						<th>
							<?php echo JText::_('INSTL_PRECHECK_RECOMMENDED'); ?>
						</th>
						<th>
							<?php echo JText::_('INSTL_PRECHECK_ACTUAL'); ?>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($this->settings as $setting) : ?>
						<?php if ($setting->state !== $setting->recommended) : ?>
							<tr>
								<td>
									<?php echo $setting->label; ?>
								</td>
								<td>
									<span class="badge badge-success disabled">
										<?php echo JText::_($setting->recommended ? 'JON' : 'JOFF'); ?>
									</span>
								</td>
								<td>
									<span class="badge badge-<?php echo ($setting->state === $setting->recommended) ? 'success' : 'warning'; ?>">
										<?php echo JText::_($setting->state ? 'JON' : 'JOFF'); ?>
									</span>
								</td>
							</tr>
							<?php endif; ?>
				<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="btn-toolbar justify-content-end">
		<div class="btn-group">
			<a href="#" class="btn btn-primary" onclick="Install.submitform();" title="<?php echo JText::_('JCHECK_AGAIN'); ?>"><span class="icon-refresh icon-white"></span> <?php echo JText::_('JCHECK_AGAIN'); ?></a>
		</div>
	</div>
	<input type="hidden" name="task" value="preinstall">
	<?php echo JHtml::_('form.token'); ?>
</form>
