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
	<div class="form-group">
		<label for="jform_language" class="control-label"><?php echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?></label>
		<?php echo $this->form->getInput('language'); ?>
	</div>
	<input type="hidden" name="view" value="preinstall">
	<input type="hidden" name="task" value="setlanguage">
	<?php echo JHtml::_('form.token'); ?>
</form>
<form action="index.php" method="post" id="adminForm">
	<div class="row">
		<div class="col-md-12">
			<h3><?php echo JText::_('INSTL_PRECHECK_TITLE'); ?></h3>
			<hr>
			<p class="install-text">
				<?php echo JText::_('INSTL_PRECHECK_DESC'); ?>
			</p>
			<table class="table table-striped table-sm">
				<tbody>
					<?php foreach ($this->options as $option) : ?>
					<?php if ($option->state === 'JNO' || $option->state === false) : ?>
					<tr>
						<td class="item">
							<?php echo $option->label; ?>
						</td>
						<td>
							<span class="badge badge-<?php echo ($option->state) ? 'success' : 'important'; ?>">
								<?php echo JText::_($option->state ? 'JYES' : 'JNO'); ?>
								<?php if ($option->notice) : ?>
									<span class="icon-info-sign icon-white hasTooltip" title="<?php echo $option->notice; ?>"></span>
								<?php endif;?>
							</span>
						</td>
					</tr>
						<?php if ($option->state === false && preg_match('$configuration.php$', $option->label)) : ?>
						<tr>
							<form action="index.php" method="post" id="adminForm" class="form-validate">
								<h3><?php echo JText::_('INSTL_FTP'); ?></h3>
								<hr>
								<div class="form-group">
									<?php echo $this->form->getLabel('ftp_enable'); ?>
									<?php echo $this->form->getInput('ftp_enable'); ?>
								</div>
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
									<button id="verifybutton" class="btn btn-success" onclick="Install.verifyFtpSettings(this);"><span class="icon-ok icon-white"></span> <?php echo JText::_('INSTL_VERIFY_FTP_SETTINGS'); ?></button>
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
								<div class="form-group">
									<?php echo $this->form->getLabel('ftp_save'); ?>
									<?php echo $this->form->getInput('ftp_save'); ?>
								</div>
								<div class="btn-toolbar justify-content-end">
									<div class="btn-group">
										<a class="btn btn-secondary" href="#" onclick="return Install.goToPage('database');" rel="prev" title="<?php echo JText::_('JPREVIOUS'); ?>"><span class="fa fa-arrow-left"></span> <?php echo JText::_('JPREVIOUS'); ?></a>
										<a class="btn btn-primary" href="#" onclick="Install.submitform();" rel="next" title="<?php echo JText::_('JNEXT'); ?>"><span class="fa fa-arrow-right icon-white"></span> <?php echo JText::_('JNEXT'); ?></a>
									</div>
								</div>
								<input type="hidden" name="task" value="ftp">
								<input type="hidden" name="format" value="json">
								<?php echo JHtml::_('form.token'); ?>
							</form>
						</tr>
						<?php endif; ?>
					<?php endif; ?>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2"></td>
					</tr>
				</tfoot>
			</table>
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
