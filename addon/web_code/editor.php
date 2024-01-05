<?php
if(!defined('__AFOX__')) exit();
if(!_AF_EDITOR_NAME_){
	$idx = $_GET['i'];
?>
<div id="web_code_panel" style="margin:20px"></div><script id="web_code_script"></script>
<script>
	var idx = <?php echo $idx ?>,
		$_codes = $(opener.document).find('#bdView').find('blockquote[web-code="area"]'),
		$_panel = $('#web_code_panel'),
		$_script = $('#web_code_script');
	$(this.document.head).append('<style>' + $_codes.eq(idx).find('code[class^="language-css"]').text().unescapeHtml() + '</style>');
	$_panel.html($_codes.eq(idx).find('code[class^="language-html"]').text().unescapeHtml());
	$_script.html($_codes.eq(idx).find('code[class^="language-javascript"]').text().unescapeHtml());
</script>
<?php
}else{
?>
<div id="web_code_selector" style="display:block">
	<div style="margin:10px">
		<label style="display:block"><input name="newCode" type="radio" value="-1" checked="checked"> <span>새로 만들기</span></label>
	</div>
	<hr style="margin:20px 0 10px">
	<div style="margin:10px;text-align:right">
		<button class="btn btn-default" onclick="web_code_select()">확인</button>
		<button class="btn btn-default" onclick="window.close()">취소</button>
	</div>
</div>
<div id="web_code_editor" style="display:none">
	<div style="margin:10px">
		<label style="padding:2px;display:inline-block">
		TITLE
		</label>
		<input type="text" style="width:100%">
	</div>
	<div style="margin:10px">
		<label style="padding:2px;display:inline-block">
		HTML
		</label>
		<textarea data-key="html" style="width:100%;height:100px"></textarea>
	</div>
	<div style="margin:10px">
		<label style="padding:2px;display:inline-block">
		CSS
		</label>
		<textarea data-key="css" style="width:100%;height:100px"></textarea>
	</div>
	<div style="margin:10px">
		<label style="padding:2px;display:inline-block">
		SCRIPT
		</label>
		<textarea data-key="javascript" style="width:100%;height:100px"></textarea>
	</div>
	<hr style="margin:20px 0 10px">
	<div style="margin:10px;text-align:right">
		<button class="btn btn-default" onclick="web_code_run()">확인</button>
		<button class="btn btn-default" onclick="window.close()">취소</button>
	</div>
</div>

<script>
	var $editor = opener.AF_EDITOR_<?php echo _AF_EDITOR_NAME_ ?>,
		$iframe = $editor.$element.find('iframe'),
		$orihtml = $('<div>'+($iframe.length > 0 ? $iframe.contents().find('body').html() : $editor.$textarea.val())+'</div>');
	var $_codes = $orihtml.find('blockquote[web-code="area"]');

	if($iframe.length > 0) {
		var $_selem,
			w = $iframe[0].contentWindow;
		if (w) {
			if (w.document.selection)
				$_selem = w.document.selection.createRange().parentElement();
			else {
				var sel = w.getSelection();
				if (sel.rangeCount > 0)
					$_selem = sel.getRangeAt(0).startContainer.parentNode;
			}
			$_selem = $($_selem).closest('blockquote[web-code="area"]');
			if($_selem.length === 0) $_selem = null;
		}
	}

	function web_code_select() {
		var $txta = $('textarea'),
			idx = $('[name="newCode"]:checked').val();
		if($_selem || idx > -1) {
			var $wc = $_selem ? $_selem : $_codes.eq(idx);
			$('input[type="text"]').val($wc.find('cite').text());
			$txta.eq(0).val($wc.find('code[class="language-html"]').text());
			$txta.eq(1).val($wc.find('code[class="language-css"]').text());
			$txta.eq(2).val($wc.find('code[class="language-javascript"]').text());
		}
		$('#web_code_selector').hide();
		$('#web_code_editor').attr('data-index', idx).show();
	}

	function web_code_run() {
		var $txta = $('textarea'),
			title = $('input[type="text"]').val() || '웹 코드',
			idx = $('#web_code_editor').attr('data-index');
		if($_selem || idx > -1) {
			var $wc = $_selem ? $_selem : $_codes.eq(idx);
			$wc.find('cite').text(title);
			$wc.find('code[class="language-html"]').text($txta.eq(0).val());
			$wc.find('code[class="language-css"]').text($txta.eq(1).val());
			$wc.find('code[class="language-javascript"]').text($txta.eq(2).val());
		} else {
			var html = '',
				tmp = '<pre><code class="language-%s">%s ' + "\n" + '</code></pre>' + "\n";
			$txta.each(function(){
				var t = $(this).attr('data-key');
				html = html + tmp.sprintf(t, $(this).val().escapeHtml())
			});
			$editor.paste(
				'<blockquote web-code="area"><cite>' + title.escapeHtml() + '</cite><hr>' + "\n"
				+ html + '<button web-code="run">코드 실행</button></blockquote>' + "\n", false
			);
		}

		alert('웹 코드 실행 입력 완료');
		window.close();
	}

	if(!$_selem && $_codes && $_codes.length > 0){
		var $lba = $('#web_code_selector').find('>div').eq(0),
			$lb = $lba.find('label').eq(0);
		for (var i = 0; i < $_codes.length; i++) {
			$lb.clone().find('span').text((i + 1) + ': ' + $_codes.eq(i).find('cite').text())
				.end().find('input').val(i).removeAttr('checked').end().appendTo($lba);
		}
	} else {
		web_code_select();
	}

</script>
<?php
}
/* End of file editor.php */
/* Location: ./addon/web_code/editor.php */
