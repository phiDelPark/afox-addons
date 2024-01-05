/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */

+function ($) {
  'use strict';

	$(window).on('load', function() {
		var js = $('script[src^="'+request_uri+'addon/code_highlighter/code_highlighter.js?"]:eq(0)');
		if(js.length>0) js = js.attr('src').getQuery();

		$('pre[highlight][collapse]')
			.offOn('click', function(e){ $(this).removeAttr('collapse'); });

		$('pre[highlight] code').each(
			function(i, block) {
				console.log(block)	;
				hljs.highlightElement(block);
			}
		);

		if((js['n'] || '1') == '1' && $('pre[highlight] code').length > 0) {
			hljs.initLineNumbersOnLoad();
		}
	});

}(jQuery);
