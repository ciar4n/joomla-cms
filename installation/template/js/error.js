(function() {
	if (errorLocale) {
		var header = document.getElementById('headerText'),
			text1 = document.getElementById('descText1');
			text2 = document.getElementById('descText2');

		// Create links for all the languages
		Object.keys(errorLocale).forEach(function(key) {
			var ul = document.getElementById('translatedLanguages'), li, aLink;
			li = document.createElement('li');
			aLink = document.createElement('a');
			aLink.setAttribute('href', '#');
			aLink.innerHTML = errorLocale[key].language;
			aLink.setAttribute('data-code', key);

			// Override click functionality for the link
			aLink.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var ref = e.target.getAttribute('data-code');
				if (ref) {
					header.innerHTML = errorLocale[ref].header;
					text1.innerHTML = errorLocale[ref].text1;
					text2.innerHTML = errorLocale[ref].text2;
				}
			});
			li.appendChild(aLink);
			ul.appendChild(li);
		});
	}
})();
