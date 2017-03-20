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
	<div id="install-site" class="row">
		<div class="col">
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('site_name'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('site_name'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_SITE_NAME_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('site_metadesc'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('site_metadesc'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_SITE_METADESC_TITLE_LABEL'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('site_offline'); ?></div>
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('site_offline'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-trigger="hover" data-content="<?php echo JText::_('INSTL_SITE_OFFLINE_TITLE_LABEL'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
			</div>
		</div>
	</div>
	<div id="install-user" class="row">
		<div class="col">
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('admin_email'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('admin_email'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_ADMIN_EMAIL_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('admin_user'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('admin_user'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_ADMIN_USER_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('admin_password'); ?>
				</div>
				<?php // Disables autocomplete ?> <input type="password" style="display:none">
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('admin_password'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_ADMIN_PASSWORD_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('admin_password2'); ?></div>
				<?php // Disables autocomplete ?> <input type="password" style="display:none">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('admin_password2'); ?></div>
			</div>
		</div>
	</div>
	<div id="install-database" class="row">
		<div class="col">
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('db_type'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('db_type'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_DATABASE_TYPE_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('db_host'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('db_host'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_DATABASE_HOST_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('db_user'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('db_user'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_DATABASE_USER_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('db_pass'); ?>
				</div>
				<?php // Disables autocomplete ?> <input type="password" style="display:none">
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('db_pass'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_DATABASE_PASSWORD_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('db_name'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('db_name'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_DATABASE_NAME_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2">
					<?php echo $this->form->getLabel('db_prefix'); ?>
				</div>
				<div class="col-md-8 offset-md-2">
					<div class="input-group">
						<?php echo $this->form->getInput('db_prefix'); ?>
						<span class="input-group-btn">
							<a class="btn btn-secondary" data-tooltip-size="large" data-tooltip="<?php echo JText::_('INSTL_DATABASE_PREFIX_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group row align-items-center">
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getLabel('db_old'); ?></div>
				<div class="col-md-8 offset-md-2"><?php echo $this->form->getInput('db_old'); ?></div>
				<div class="col-md-1">
					<a class="hasPopover text-muted" data-toggle="popover" data-content="<?php echo JText::_('INSTL_DATABASE_OLD_PROCESS_DESC'); ?>"><i class="fa fa-question-circle"></i></a>
				</div>
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