<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_privacy
 *
 * @copyright   (C) 2021 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<form action="<?php echo Route::_('index.php?option=com_privacy&view=requests'); ?>" method="post" name="adminForm" id="adminForm">

	<div class="px-4 py-5 my-5 text-center">
		<span class="fa-8x icon-lock mb-4" aria-hidden="true"></span>
		<h1 class="display-5 fw-bold"><?php echo Text::_('COM_PRIVACY_REQUESTS_BLANKSTATE_TITLE'); ?></h1>
		<div class="col-lg-6 mx-auto">
			<p class="lead mb-4">
				<?php echo Text::_('COM_PRIVACY_REQUESTS_BLANKSTATE_REQUESTS'); ?>
			</p>
			<div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
				<a href="<?php echo Route::_('index.php?option=com_privacy&view=request&layout=edit'); ?>" class="btn btn-primary btn-lg px-4 me-sm-3"><?php echo Text::_('COM_PRIVACY_REQUESTS_BLANKSTATE_BUTTON_ADD'); ?></a>
				<a href="https://docs.joomla.org/Special:MyLanguage/Help40:Privacy:_Information_Requests" class="btn btn-outline-secondary btn-lg px-4"><?php echo Text::_('COM_PRIVACY_BLANKSTATE_BUTTON_LEARNMORE'); ?></a>
			</div>
		</div>
	</div>

	<input type="hidden" name="task" value="">
	<input type="hidden" name="boxchecked" value="0">
</form>
