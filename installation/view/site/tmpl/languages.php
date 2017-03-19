<?php
/**
 * @package     Joomla.Installation
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/* @var InstallationViewDefault $this */
?>
<canvas id="myCanvas" class="hidden"></canvas>
<form action="index.php" method="post" id="languageForm">
<div class="row pt-4 pb-5">
	<div class="col-md-4 offset-md-1 pr-4 pt-1 text-right">
		<label for="jform_language"><?php echo JText::_('INSTL_SELECT_LANGUAGE_TITLE'); ?></label>
	</div>	
	<div class="col-md-6">
		<?php echo $this->form->getInput('language'); ?>
		<input type="hidden" name="task" value="setlanguage" />
		<?php echo JHtml::_('form.token'); ?>
	</div>			
</div>
	
</form>

<script>
	var canvas, ctx;
	var drawTimer, clearTimer;
	var width, height;

	document.addEventListener('DOMContentLoaded', function() {
		canvas = document.getElementById('myCanvas');

		// Make canvas a direct child of body
		document.body.appendChild(canvas);
		canvas.style.display = 'block';
		width = document.body.clientWidth;
		canvas.width = document.body.clientWidth;
//			height = document.body.getBoundingClientRect();
		height = Math.max( document.body.scrollHeight, document.body.offsetHeight);
		canvas.height = window.innerHeight;
		canvas.style.top = '210px';
		canvas.style.left = '0';
		canvas.style.right = '0';
		canvas.style.bottom = '0';
		canvas.style.backgroundColor = "transparent";
		canvas.style.color = "#ffffff";
		canvas.style.position = 'fixed'
		ctx = canvas.getContext('2d');

		drawTimer = window.setInterval(draw, 400);
		//clearTimer = window.setInterval(clear, 10000);

		function setCookie(cname, cvalue) {
			var d = new Date();
			d.setTime(d.getTime() + 1800);
			var expires = "expires="+ d.toUTCString();
			document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		}

		document.getElementById('jform_language').addEventListener('change', function(event) {
			cookie_name  = "JoomlaLanguage";
			cookie_value = event.target.value;
			setCookie(cookie_name, cookie_value);
			Install.setlanguage();

		});
	});

	window.addEventListener('resize', function() {
		canvas = document.getElementById('myCanvas');
		canvas.height = window.innerHeight;
		canvas.height = window.innerHeight;

	})

	function draw() {
		var fontSize = Math.random() * 50;
		var x = Math.random() * (canvas.width - (fontSize + 180));
		var y = Math.random() * (canvas.height);
		var r = Math.floor(Math.random() * 255) + 50;
		var g = Math.floor(Math.random() * 255) + 50;
		var b = Math.floor(Math.random() * 255) + 50;

		var messages =['Welcome', 'bienvenue', 'Καλώς ήρθατε', 'добре дошъл', 'willkommen', '歓迎', 'karşılama'];
		var message = messages[Math.floor(Math.random()*messages.length)];

		ctx.font = fontSize < 15 ? '15pt Arial' : fontSize + 'pt Arial';
		ctx.fillStyle = 'rgba(0,0,0,0.1)';
		ctx.fillText(message, x, 100 + y);
	}

	function clear() {
		ctx.fillStyle = 'rgba(256, 256, 256, 1)';
		ctx.fillRect(0, 0, width, height);
	}
</script>
