<?php
/**
 * @package    Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var InstallationViewRemoveHtml $this */
?>
<div class="row">
	<div id="installer-view" class="col-md-11 col-lg-12 container" data-page-name="remove">
		<div class="alert alert-danger inlineError" id="theDefaultError" style="display:none">
			<h4 class="alert-heading"><?php echo JText::_('JERROR'); ?></h4>
			<p id="theDefaultErrorMessage"></p>
		</div>
		<div class="alert alert-success">
			<h3><?php echo JText::_('INSTL_COMPLETE_TITLE'); ?></h3>
		</div>
		<h2 class="text-centered" style="text-align: center">Post installation tasks</h2>
		<hr>
		<!-- Sample data -->
		<div class="form-group" style="padding: 0 20px;text-align: center">

			<h3 style="text-align: center"><?php echo JText::_('Do you want to install sample data?'); ?></h3>
			<p class="form-text text-muted small"><?php echo JText::_('INSTL_SITE_INSTALL_SAMPLE_DESC'); ?></p>
			<div class="form-text text-muted">
				<button id="skipSampleData" class="btn btn-default"><?php echo JText::_('JSKIP'); ?></button>
				<button id="installSampleData" class="btn btn-primary"><?php echo JText::_('JYES'); ?></button>
			</div>
		</div>


		<form action="index.php" method="post" id="adminForm" class="form-validate">
			<?php /* Extra languages */ ?>
			<h3><?php echo JText::_('INSTL_LANGUAGES'); ?></h3>
			<hr>
			<?php if (!$this->items) : ?>
				<p><?php echo JText::_('INSTL_LANGUAGES_WARNING_NO_INTERNET') ?></p>
				<p>
					<a href="#"
							class="btn btn-primary"
							onclick="return Install.goToPage('remove');">
						<span class="fa fa-arrow-left icon-white"></span>
						<?php echo JText::_('INSTL_LANGUAGES_WARNING_BACK_BUTTON'); ?>
					</a>
				</p>
				<p><?php echo JText::_('INSTL_LANGUAGES_WARNING_NO_INTERNET2') ?></p>
			<?php else : ?>
				<p id="install_languages_desc"><?php echo JText::_('INSTL_LANGUAGES_DESC'); ?></p>
				<p id="wait_installing" style="display: none;">
					<?php echo JText::_('INSTL_LANGUAGES_MESSAGE_PLEASE_WAIT') ?><br>
				<div id="wait_installing_spinner" class="spinner spinner-img" style="display: none;"></div>
				</p>
				<table class="table table-striped table-sm">
					<thead>
					<tr>
						<th width="1%" class="text-center">
							&nbsp;
						</th>
						<th>
							<?php echo JText::_('INSTL_LANGUAGES_COLUMN_HEADER_LANGUAGE'); ?>
						</th>
						<th width="15%">
							<?php echo JText::_('INSTL_LANGUAGES_COLUMN_HEADER_LANGUAGE_TAG'); ?>
						</th>
						<th width="5%" class="text-center">
							<?php echo JText::_('INSTL_LANGUAGES_COLUMN_HEADER_VERSION'); ?>
						</th>
					</tr>
					</thead>
					<tbody>
					<?php $version = new JVersion; ?>
					<?php $currentShortVersion = preg_replace('#^([0-9\.]+)(|.*)$#', '$1', $version->getShortVersion()); ?>
					<?php foreach ($this->items as $i => $language) : ?>
						<?php // Get language code and language image. ?>
						<?php preg_match('#^pkg_([a-z]{2,3}-[A-Z]{2})$#', $language->element, $element); ?>
						<?php $language->code = $element[1]; ?>
						<tr>
							<td>
								<input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $language->update_id; ?>">
							</td>
							<td>
								<label for="cb<?php echo $i; ?>"><?php echo $language->name; ?></label>
							</td>
							<td>
								<?php echo $language->code; ?>
							</td>
							<td class="text-center">
								<?php // Display a Note if language pack version is not equal to Joomla version ?>
								<?php if (substr($language->version, 0, 3) != $version::RELEASE || substr($language->version, 0, 5) != $currentShortVersion) : ?>
									<span class="badge badge-warning hasTooltip" title="<?php echo JText::_('JGLOBAL_LANGUAGE_VERSION_NOT_PLATFORM'); ?>"><?php echo $language->version; ?></span>
								<?php else : ?>
									<span class="badge badge-success"><?php echo $language->version; ?></span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<input type="hidden" name="task" value="InstallLanguages">
				<?php echo JHtml::_('form.token'); ?>
			<?php endif; ?>
			<a
					class="btn btn-primary"
					href="#"
					onclick="installLanguages()"
					rel="next"
					title="<?php echo JText::_('JNEXT'); ?>">
				<span class="fa fa-arrow-right icon-white"></span>
				<?php echo JText::_('JNEXT'); ?>
			</a>

			<?php $displayTable = false; ?>
			<?php foreach ($this->phpsettings as $setting) : ?>
				<?php if ($setting->state !== $setting->recommended) : ?>
					<?php $displayTable = true; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php
			if ($displayTable) : ?>
			<div class="card-block col-md-12">
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
					<?php foreach ($this->phpsettings as $setting) : ?>
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

				<?php endif; ?>
				<?php	if ($this->development) : ?>
					<div class="alert alert-info">
						<p>We detected development mode</p>
						<p><?php echo JText::_('INSTL_COMPLETE_REMOVE_INSTALLATION'); ?></p>
						<input type="button" class="btn btn-warning" name="instDefault" onclick="Install.removeFolder(this);" value="<?php echo JText::_('INSTL_COMPLETE_REMOVE_FOLDER'); ?>">
					</div>
				<?php endif; ?>
				<?php echo JHtml::_('form.token'); ?>
		</form>
	</div>
		<div class="card-block">
			<div>
				<div class="btn-group">
					<a class="btn btn-secondary" href="<?php echo JUri::root(); ?>" title="<?php echo JText::_('JSITE'); ?>"><span class="fa fa-eye"></span> <?php echo JText::_('JSITE'); ?></a>
				</div>
				<div class="btn-group">
					<a class="btn btn-primary" href="<?php echo JUri::root(); ?>administrator/" title="<?php echo JText::_('JADMINISTRATOR'); ?>"><span class="fa fa-lock"></span> <?php echo JText::_('JADMINISTRATOR'); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
