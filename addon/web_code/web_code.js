/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */
window.addEventListener('load', e => {
	let js = document.querySelector('script[src^="'+request_uri+'addon/webcode/webcode."]'),
		option1 = false

	if(js) {
		js = js.getAttribute('src').getQuery();
		option1 = (js['n'] || '0') === '1'
	}

	const content_id = '.current_content'

	const webcodes = document.querySelectorAll(content_id + ' blockquote[webcode=group]')
	let i = 1
	webcodes.forEach(el => {
		const btn = document.createElement('button')
		btn.setAttribute('target', i++)
		btn.classList.add('btn','btn-secondary','w-100')
		btn.addEventListener('click', e => {
			const idx = e.target.getAttribute('target')
			pop_win(request_uri + 'module/editor/component.php?n=web_code&i=' + idx, null, null, 'afox_addon_webcode')
		});
		btn.innerText = '코드 실행'
		el.lastChild.after(btn)
	});
});