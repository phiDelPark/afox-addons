/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */
window.addEventListener('load', e => {
	let js = document.querySelector('script[src^="'+request_uri+'addon/code_highlighter/code_highlighter."]'),
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
			highlights = document.querySelectorAll(content_id + ' pre[highlight]');

		highlights.forEach(el => {
			if(el.hasAttribute('collapse')){
				el.addEventListener('click', e => el.removeAttribute('collapse'));
			}
			const code = el.querySelector('code');
			if(code) hljs.highlightElement(code);
			if(wrap) el.classList.add('wrap');
		});
		if(line_number && highlights.length > 0) hljs.initLineNumbersOnLoad();
	}
});