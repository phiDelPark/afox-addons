/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */
window.addEventListener('load', e => {
	let js = document.querySelector('script[src^="'+request_uri+'addon/code_highlighter/"]'),
		line_number = true,
		wrap = true;

	if(js) {
		js = js.getAttribute('src').getQuery();
		line_number = (js['n'] || '1') === '1';
		wrap		= (js['w'] || '1') === '1';
	}

	const content_id = '.current_content';

	if(hljs){
		const
			highlights = document.querySelectorAll(content_id + ' pre>code[class^=language-]');
		highlights.forEach(el => {
			let c = el.getAttribute('class').split('\\')
			el.parentNode.classList.add('highlight')
			if((c[1] || '') == 'collapse') {
				el.parentNode.classList.add('collapse')
				el.parentNode.addEventListener('click',
					e => el.parentNode.classList.remove('collapse')
				)
			}
			el.setAttribute('class', c[0])
			hljs.highlightElement(el);
			if(wrap) el.parentNode.classList.add('wrap');
		});
		if(line_number && highlights.length > 0) hljs.initLineNumbersOnLoad();
	}
});