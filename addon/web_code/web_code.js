/*!
 * aFox (https://github.com/phiDelPark/afox-addons)
 * Copyright 2016 afox, Inc.
 * Licensed under the MIT license
 */

+function ($) {
  'use strict';

	$(window).on('load', function() {
		var js = $('script[src^="'+request_uri+'addon/web_code/web_code."]:eq(0)');
		if( js.length > 0 ) {
			//js = js.attr('src').getQuery();
			//if((js['w'] || '0') == '1') wrap = true;
		}

		$('blockquote[web-code="area"]').each(
			function(i, block) {
				var $this = $(this);
				$this.find('button[web-code="run"]')
				.click(function(e){
					pop_win(request_uri + 'module/editor/component.php?n=web_code&i=' + i, null, null, 'af_addon_web_code');
				});
			}
		);
	});

}(jQuery);
