// Init on dom content loaded event
var url = Joomla.getOptions('system.installation').url ? Joomla.getOptions('system.installation').url.replace(/&amp;/g, '&') : 'index.php';

if (document.getElementById('step1')) {
	document.getElementById('step1').addEventListener('click', function(e) {
		e.preventDefault();
		if (document.getElementById('installStep2')) {
			document.getElementById('installStep2').removeAttribute('hidden');
			document.getElementById('installStep2').classList.add('active');
			document.getElementById('step1').parentNode.removeChild(document.getElementById('step1'));

			document.getElementById('installStep2').scrollIntoView();
		}
	})
}

if (document.getElementById('step2')) {
	document.getElementById('step2').addEventListener('click', function(e) {
		// e.preventDefault();
		if (document.getElementById('installStep3')) {
			document.getElementById('installStep3').removeAttribute('hidden');
			document.getElementById('installStep3').classList.add('active');
			document.getElementById('step2').parentNode.removeChild(document.getElementById('step2'))

			document.getElementById('installStep3').scrollIntoView();
		}
	});
}

