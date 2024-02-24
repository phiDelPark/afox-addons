/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */
window.addEventListener('load', e => {
	let js = document.querySelector('script[src^="'+request_uri+'addon/code_highlighter/"]'),
		auto_highlight = true,
		line_number = true,
		pre_wrap = true

	if(js) {
		js = js.getAttribute('src').getQuery()
		auto_highlight = (js['a'] || '0') === '1'
		line_number = (js['n'] || '0') === '1'
		pre_wrap = (js['w'] || '1') === '1'
	}

	const content_id = '.current_content';

	if(hljs){
		const
			highlights = document.querySelectorAll(
				content_id + ' pre>code' + (auto_highlight ? '' : '[class^=language-]')
			)
		highlights.forEach(el => {
			let c = (el.getAttribute('class') || 'language-').split('\\')
			el.parentNode.classList.add('highlight')
			if((c[1] || '') == 'collapse') {
				el.parentNode.classList.add('collapse')
				el.parentNode.addEventListener('click',
					e => el.parentNode.classList.remove('collapse')
				)
			}
			el.setAttribute('class', c[0])
			el.innerHTML = el.innerHTML.replace(/<br[^>]*>/gi, "\n")
			hljs.highlightElement(el)
			if(pre_wrap) el.parentNode.classList.add('wrap')
		})
		if(line_number && highlights.length > 0) hljs.initLineNumbersOnLoad();
	}
});