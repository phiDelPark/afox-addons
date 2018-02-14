/*!
 * aFox (http://afox.kr)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */

+function ($) {
  'use strict';

	$(window).on('load', function() {
		$('pre[code-lang]').each(
			function(i, block) {
				var $this = $(this);
				if($this.is('[collapse]')) {
					$this.offOn('click', function(e){ $this.removeAttr('collapse'); });
				}
				var lang = $this.attr('code-lang') || 'auto';
				if(lang && lang != 'auto') $this.addClass('language-' + lang);
				hljs.highlightBlock(block);
			}
		);
	});

}(jQuery);
