<?php
/**
 * @package     Joomla.Installation
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var InstallationViewDefault $this */
?>
<form action="index.php" method="post" id="languageForm" class="lang-select">
	<div class="col-md-11 col-lg-12 container">
		<div class="form-group row">
			<div class="col-md-8 offset-md-2">
				<label for="jform_language"><?php echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?></label>
				<?php echo $this->form->getInput('language'); ?>
			</div>
		</div>
		<input type="hidden" name="task" value="setlanguage">
		<input type="hidden" name="format" value="json">
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<form action="index.php" method="post" id="adminForm" class="form-validate">
	<div class="row">
		<div class="col-md-11 col-lg-12 container">
			<div id="installStep1" class="install-step active">
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">			
						<?php echo $this->form->getLabel('site_name'); ?>
						<?php echo $this->form->getInput('site_name'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_SITE_NAME_DESC'); ?></p>
					</div>
				</div>
				<div class="col-md-8 offset-md-2 justify-content-end d-flex">
					<a class="btn btn-success" id="step1" href="#installStep2"><?php echo JText::_('JNEXT'); ?> <span class="fa fa-chevron-right" aria-hidden="true"></span></a>
				</div>
			</div>
			<div id="installStep2" class="install-step" data-scroll>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('admin_user'); ?>
						<?php echo $this->form->getInput('admin_user'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_ADMIN_USER_DESC'); ?></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('admin_email'); ?>
						<?php echo $this->form->getInput('admin_email'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_ADMIN_EMAIL_DESC'); ?></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('admin_password'); ?>
						<div class="input-group">
							<?php echo $this->form->getInput('admin_password'); ?>
							<span class="input-group-addon fa fa-eye"></span>
						</div>
						
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_ADMIN_PASSWORD_DESC'); ?></p>
					</div>
				</div>
				<div class="col-md-8 offset-md-2 justify-content-end d-flex">
					<a class="btn btn-success" href="#installStep3" id="step2"><?php echo JText::_('JNEXT'); ?> <span class="fa fa-chevron-right" aria-hidden="true"></span></a>
				</div>
			</div>
			<div id="installStep3" class="install-step" data-scroll>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('db_type'); ?>
						<?php echo $this->form->getInput('db_type'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_TYPE_DESC'); ?></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('db_host'); ?>
						<?php echo $this->form->getInput('db_host'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_HOST_DESC'); ?></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('db_user'); ?>
						<?php echo $this->form->getInput('db_user'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_USER_DESC'); ?></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('db_pass'); ?>
						<?php echo $this->form->getInput('db_pass'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_PASSWORD_DESC'); ?></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-8 offset-md-2">
						<?php echo $this->form->getLabel('db_name'); ?>
						<?php echo $this->form->getInput('db_name'); ?>
						<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_NAME_DESC'); ?></p>
					</div>
				</div>
				<div class="col-md-8 offset-md-2 justify-content-end d-flex">
					<button class="btn btn-success" onclick="Joomla.checkInputs()" ?><?php echo JText::_('Install'); ?> <span class="fa fa-chevron-right" aria-hidden="true"></span></button>
				</div>
			</div>
		</div>
		<div class="form-group">
<!--			--><?php //echo $this->form->getLabel('db_prefix'); ?>
			<?php echo $this->form->getInput('db_prefix'); ?>

		</div>
		<div class="form-group">
<!--			--><?php //echo $this->form->getLabel('db_old'); ?>
			<?php echo $this->form->getInput('db_old'); ?>
		</div>
	</div>
	</div>

	<input type="hidden" name="admin_password2" id="jform_admin_password2">
	<input type="hidden" name="task" value="site">
	<input type="hidden" name="format" value="json">
	<?php echo JHtml::_('form.token'); ?>
</form>