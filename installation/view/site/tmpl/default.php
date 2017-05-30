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

<form action="index.php" method="post" id="adminForm" class="form-validate">
	<div class="row">
		<div class="col-md-11 col-lg-12 container">
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
					<?php // Disables autocomplete ?> <input type="password" style="display:none">
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
					<?php // Disables autocomplete ?> <input type="password" style="display:none">
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
	</div>
	<!--
	<div class="btn-toolbar justify-content-end">
		<div class="btn-group">
			<a class="btn btn-secondary" href="#" onclick="return Install.goToPage('site');" rel="prev" title="<?php echo JText::_('JPREVIOUS'); ?>"><span class="fa fa-arrow-left"></span> <?php echo JText::_('JPREVIOUS'); ?></a>
			<a  class="btn btn-primary" href="#" onclick="Install.submitform();" rel="next" title="<?php echo JText::_('JNEXT'); ?>"><span class="fa fa-arrow-right icon-white"></span> <?php echo JText::_('JNEXT'); ?></a>
		</div>
	</div>
	-->
	<input type="hidden" name="task" value="site">
	<input type="hidden" name="format" value="json">
	<?php echo JHtml::_('form.token'); ?>
</form>