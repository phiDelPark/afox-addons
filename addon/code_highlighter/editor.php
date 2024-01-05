<?php
if(!defined('__AFOX__')) exit();
?>
<div class="code_highlighter_selector" style="display:block">
	<div style="margin:10px">
		<label style="display:block"><input name="newCode" type="radio" value="-1" checked="checked"> <span>새로 만들기</span></label>
	</div>
	<hr style="margin:20px 0 10px">
	<div style="margin:10px;text-align:right">
		<button class="btn btn-default" onclick="code_highlighter_select()">확인</button>
		<button class="btn btn-default" onclick="window.close()">취소</button>
	</div>
</div>
<div class="code_highlighter_editor" style="display:none">
	<div style="margin:10px">
		<p><span style="width:80px;display:inline-block">코드 타입 : </span> <select name="lang" required style="width:200px">
			<option value="language-">Auto</option>
			<option value="language-apache">Apache</option>
			<option value="language-bash">Bash</option>
			<option value="language-coffeescript">Coffee Script</option>
			<option value="language-cpp">C++</option>
			<option value="language-cs">C#</option>
			<option value="language-css">CSS</option>
			<option value="language-diff">Diff</option>
			<option value="language-http">HTTP</option>
			<option value="language-ini">Ini</option>
			<option value="language-java">Java</option>
			<option value="language-javascript">Java Script</option>
			<option value="language-json">JSON</option>
			<option value="language-makefile">Makefile</option>
			<option value="language-markdown">Markdown</option>
			<option value="language-nginx">Nginx</option>
			<option value="language-objectivec">Objective-C</option>
			<option value="language-perl">Perl</option>
			<option value="language-php">PHP</option>
			<option value="language-python">Python</option>
			<option value="language-ruby">Ruby</option>
			<option value="language-shell">Shell Session</option>
			<option value="language-sql">SQL</option>
			<option value="language-html">HTML / XML</option>
		</select>
		<input type="checkbox" name="code_collapse" id="id-code-collapse" style="margin-left:15px">
		<label for="id-code-collapse">접기/펼치기</label>
		</p>
		<textarea style="width:100%;height:250px"></textarea>
	</div>
	<hr style="margin:20px 0 10px">
	<div style="margin:10px;text-align:right">
		<button class="btn btn-default" onclick="code_highlighter_run()">확인</button>
		<button class="btn btn-default" onclick="window.close()">취소</button>
	</div>
</div>

<script>
	var $editor = opener.AF_EDITOR_<?php echo _AF_EDITOR_NAME_ ?>,
		$iframe = $editor.$element.find('iframe'),
		$orihtml = $('<div>'+($iframe.length > 0 ? $iframe.contents().find('body').html() : $editor.$textarea.val())+'</div>');
	var $_codes = $orihtml.find('pre[highlight] code');

	if($iframe.length > 0) {
		var $_selem = null,
			w = $iframe[0].contentWindow;
		if (w) {
			if (w.document.selection)
				$_selem = w.document.selection.createRange().parentElement();
			else {
				var sel = w.getSelection();
				if (sel.rangeCount > 0)
					$_selem = sel.getRangeAt(0).startContainer.parentNode;
			}
			$_selem = $_selem.tagName == 'CODE' ? $($_selem) : null;
			if($_selem != null && !$_selem.is('[class*=language-]')) $_selem = null;
		}
	}

	function code_highlighter_select() {
		var idx = $('[name="newCode"]:checked').val();
		if($_selem || idx > -1) {
			var $wc = $_selem ? $_selem : $_codes.eq(idx),
				$txta = $('textarea'),
				cc = $wc.parent().attr('collapse') || 'false',
				lang = $wc.attr('class') || 'language-';
			$('[name="lang"]').val(lang);
			$('[name="code_collapse"]').prop("checked", cc == 'true');
			$txta.eq(0).val($wc.text().trim());
		}
		$('.code_highlighter_selector').hide();
		$('.code_highlighter_editor').attr('data-index', idx).show();
	}

	function code_highlighter_run() {
		var $txta = $('textarea').eq(0),
			lang = $('[name="lang"]').val() || 'language-',
			idx = $('.code_highlighter_editor').attr('data-index'),
			cc = $('[name="code_collapse"]').is(":checked") ? 1 : 0,
			html;
		if($_selem || idx > -1) {
			var $wc = $_selem ? $_selem : $_codes.eq(idx);
			$wc.text($txta.val());
			$wc.attr('class', lang);
			cc === 0 ? $wc.parent().attr('collapse', true) : $wc.parent().removeAttr('collapse');
			$prev = $wc.prev();
			if($iframe.length > 0) {
				if(!$_selem) $iframe.contents().find('body').html($orihtml.html());
			}else {
				$txta.val($orihtml.text());
			}
		} else {
			html = '<pre highlight%s><code class="%s">%s ' + "\n" + '</code></pre>' + "\n";
			$editor.paste(html.sprintf(
				cc === 1 ? ' collapse="true"' : '', lang, $txta.val().escapeHtml() || ('/* 이 아래로 코드 입력 */' + "\n" + "\n")
				), false
			);
		}

		alert('코드 문법강조 입력 완료');
		window.close();
	}

	if($_selem == null && $_codes && $_codes.length > 0){
		var $lba = $('.code_highlighter_selector').find('>div').eq(0),
			$lb = $lba.find('label').eq(0);
		for (var i = 0; i < $_codes.length; i++) {
			$lb.clone().find('span').text((i + 1) + ': ' + $_codes.eq(i).attr('class'))
					.end().find('input').val(i).removeAttr('checked').end().appendTo($lba);
		}
	} else {
		code_highlighter_select();
	}

</script>
<?php
/* End of file editor.php */
/* Location: ./addon/code_highlighter/editor.php */
