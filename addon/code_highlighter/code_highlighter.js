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
			if(el.parentNode.hasAttribute('collapse')){
				el.parentNode.addEventListener('click', e => el.removeAttribute('collapse'));
			}
			if(el.classList.contains('language-auto')){
				el.classList.remove('language-auto')
				el.classList.add('language-')
			}
			hljs.highlightElement(el);
			if(wrap) el.classList.add('wrap');
		});
		if(line_number && highlights.length > 0) hljs.initLineNumbersOnLoad();
	}
});