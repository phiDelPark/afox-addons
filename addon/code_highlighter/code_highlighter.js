/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */

+function ($) {
  'use strict';

	$(window).on('load', function() {
		var js = $('script[src^="'+request_uri+'addon/code_highlighter/code_highlighter.js?"]:eq(0)'),
			pre_wrap = false;

		if(js.length>0) {
			js = js.attr('src').getQuery();
			if((js['w'] || '0') == '1') pre_wrap = true;
		}

		$('pre[code-lang]').each(
			function(i, block) {
				var $this = $(this);
				if($this.is('[collapse]')) {
					$this.offOn('click', function(e){ $this.removeAttr('collapse'); });
				}
				var lang = $this.attr('code-lang') || 'auto';
				var title = $this.attr('title') || '';
				if(lang && lang != 'auto') $this.addClass('language-' + lang);
				pre_wrap ? $this.addClass('wrap') : $this.removeAttr('wrap');
				if(title) $this.removeAttr('title');
				hljs.highlightBlock(block);
			}
		);

		$('pre[code-lang][number]').each(
			function(i, block) {
				hljs.lineNumbersBlock(block);
			}
		);
	});

}(jQuery);
