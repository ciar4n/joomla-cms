<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_messages
 *
 * @copyright   (C) 2019 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

$hideLinks = $app->input->getBool('hidemainmenu');
$uri   = Uri::getInstance();
$route = 'index.php?option=com_messages&view=messages&id=' . $app->getIdentity()->id . '&return=' . base64_encode($uri);
?>
<a class="header-item-content<?php echo ($hideLinks ? 'disabled' : ''); ?>" <?php echo ($hideLinks ? '' : 'href="' . Route::_($route) . '"'); ?> title="<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>">
	<div class="header-item-icon">
	<div class="w-auto">
		<span class="icon-envelope" aria-hidden="true"></span>
			<?php if ($countUnread > 0) : ?>
				<small class="header-item-count"><?php echo $countUnread; ?></small>
			<?php endif; ?>
		</div>
	</div>
	<div class="header-item-text">
		<?php echo Text::_('MOD_MESSAGES_PRIVATE_MESSAGES'); ?>
	</div>
</a>
