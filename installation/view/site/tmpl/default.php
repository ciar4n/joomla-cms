<?php echo JHtml::_('InstallationHtml.helper.stepbar'); ?>
<!--<form action="index.php" method="post" id="languageForm" class="languageForm">-->
<!--	<div class="row">-->
<!--		<div class="col-md-11 col-lg-8 container">-->
<!--			<div class="form-group">-->
<!--				<label for="jform_language">--><?php //echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?><!--</label>-->
<!--				--><?php //echo $this->form->getInput('language'); ?>
<!--			</div>-->
<!--			<input type="hidden" name="task" value="setlanguage" />-->
<!--			--><?php //echo JHtml::_('form.token'); ?>
<!--		</div>-->
<!--	</div>-->
<!--</form>-->
<form action="index.php" method="post" id="adminForm" class="form-validate">
	<div class="row">
		<div class="col-md-11 col-lg-8 container">
			<h3><?php echo JText::_('INSTL_SITE'); ?></h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-11 col-lg-12 container">
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('site_name'); ?></div>
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getInput('site_name'); ?>
				</div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-content="<?php echo JText::_('INSTL_SITE_NAME_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('site_metadesc'); ?></div>
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('site_metadesc'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-trigger="hover" data-content="<?php echo JText::_('INSTL_SITE_METADESC_TITLE_LABEL'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('site_offline'); ?></div>
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('site_offline'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-trigger="hover" data-content="<?php echo JText::_('INSTL_SITE_OFFLINE_TITLE_LABEL'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('admin_email'); ?></div>
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('admin_email'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-content="<?php echo JText::_('INSTL_ADMIN_EMAIL_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('admin_user'); ?></div>
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('admin_user'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-content="<?php echo JText::_('INSTL_ADMIN_USER_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('admin_password'); ?></div>
				<?php // Disables autocomplete ?> <input type="password" style="display:none">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('admin_password'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-content="<?php echo JText::_('INSTL_ADMIN_PASSWORD_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('admin_password2'); ?></div>
				<?php // Disables autocomplete ?> <input type="password" style="display:none">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('admin_password2'); ?></div>
			</div>
		</div>
	</div>

	<h3><?php echo JText::_('INSTL_DATABASE'); ?></h3>
	<hr class="hr-condensed" />
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<?php echo $this->form->getLabel('db_type'); ?>
				<?php echo $this->form->getInput('db_type'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_TYPE_DESC'); ?></p>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('db_host'); ?>
				<?php echo $this->form->getInput('db_host'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_HOST_DESC'); ?></p>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('db_user'); ?>
				<?php echo $this->form->getInput('db_user'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_USER_DESC'); ?></p>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('db_pass'); ?>
				<?php // Disables autocomplete ?> <input type="password" style="display:none">
				<?php echo $this->form->getInput('db_pass'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_PASSWORD_DESC'); ?></p>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('db_name'); ?>
				<?php echo $this->form->getInput('db_name'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_NAME_DESC'); ?></p>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('db_prefix'); ?>
				<?php echo $this->form->getInput('db_prefix'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_PREFIX_DESC'); ?></p>
			</div>
			<div class="form-group">
				<?php echo $this->form->getLabel('db_old'); ?>
				<?php echo $this->form->getInput('db_old'); ?>
				<p class="form-text text-muted small"><?php echo JText::_('INSTL_DATABASE_OLD_PROCESS_DESC'); ?></p>
			</div>
		</div>
	</div>
	<ul class="nav nav-tabs nav-justified install-nav-footer">
		<li class="nav-item">
			<a class="nav-button prev-button disabled" rel="prev" title="<?php echo JText::_('JPREVIOUS'); ?>"><span class="fa fa-arrow-left"></span> <?php echo JText::_('JPREVIOUS'); ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-button next-button" href="#" onclick="Install.submitform();" rel="next" title="<?php echo JText::_('JNEXT'); ?>"><span class="fa fa-arrow-right icon-white"></span> <?php echo JText::_('JNEXT'); ?></a>
		</li>
	</ul>
	<input type="hidden" name="task" value="site" />
	<?php echo JHtml::_('form.token'); ?>
</form>