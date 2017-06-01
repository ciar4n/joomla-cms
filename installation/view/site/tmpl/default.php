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
			<div class="form-group row">
				<div class="col-md-8 offset-md-2">			
					<?php echo $this->form->getLabel('site_name'); ?>
					<?php echo $this->form->getInput('site_name'); ?>
					<p class="form-text text-muted small"><?php echo JText::_('INSTL_SITE_NAME_DESC'); ?></p>
				</div>
			</div>
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
	<div class="btn-toolbar justify-content-end">
			<a class="btn btn-success" href="#" onclick="Joomla.checkInputs()"> <?php echo JText::_('Install'); ?></a>
	</div>

	<input type="hidden" name="admin_password2" id="jform_admin_password2">
	<input type="hidden" name="task" value="site">
	<input type="hidden" name="format" value="json">
	<?php echo JHtml::_('form.token'); ?>
</form>