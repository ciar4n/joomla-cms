<?php
/**
 * @package    Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var InstallationViewInstallHtml $this */
?>
<form action="index.php" method="post" id="adminForm" class="form-validate">
	<h3><?php echo JText::_('INSTL_INSTALLING'); ?></h3>
	<hr>

	<div id="install_progress" class="progress">
		<div
			role="progressbar"
			class="progress-bar progress-bar-striped progress-bar-animated"
			style="width: 0%;"></div>
	</div>

	<table class="table">
		<tbody>
		<?php foreach ($this->tasks as $task) : ?>
			<tr id="install_<?php echo $task; ?>">
				<td class="item" nowrap="nowrap" width="10%">
				<?php if ($task == 'Email') : ?>
					<?php echo JText::sprintf('INSTL_INSTALLING_EMAIL', '<span class="badge badge-info">' . $this->options['admin_email'] . '</span>'); ?>
				<?php else : ?>
					<?php echo JText::_('INSTL_INSTALLING_' . strtoupper($task)); ?>
				<?php endif; ?>
				</td>
				<td>
					<div class="spinner spinner-img" style="visibility: hidden;"></div>
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
	<input type="hidden" name="format" value="json">
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php
$tasks = implode("','", $this->tasks);
JFactory::getDocument()->addScriptDeclaration(
<<<JS
	document.addEventListener('DOMContentLoaded', function()
	{
		Install.install(['Config']); //
		window.location = window.location.replace(/installation\/index\?view=install/g) + '?view=remove'
	});
	// function doInstall()
	// {
	// 	if (document.getElementById('install_progress'))
	// 	{
	// 		Install.install(['Database', 'Config']);
	// 	}
	// 	else
	// 	{
	// 		(function(){doInstall();}).delay(500);
	// 	}
	// }
JS
);
