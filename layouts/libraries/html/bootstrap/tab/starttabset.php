<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2013 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$selector = empty($displayData['selector']) ? '' : $displayData['selector'];

$selector = ltrim($selector, '.');
?>

<ul class="joomla-tabs nav nav-tabs" id="<?php echo $selector; ?>Tabs" role="tablist"></ul>
<div class="tab-content" id="<?php echo $selector; ?>Content">
