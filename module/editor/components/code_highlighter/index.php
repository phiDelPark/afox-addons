<?php
if(!defined('__AFOX__')) exit();
?>
<div class="code_highlighter_selector" style="display:block">
	<div style="margin:10px">
		<h4><?php echo $_COMPONENT_INFO['title'] ?></h4>
		<hr style="margin:10px 0 20px">
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
		<h4><?php echo $_COMPONENT_INFO['title'] ?></h4>
		<hr style="margin:10px 0 20px">
		<p><span style="width:80px;display:inline-block">코드 타입 : </span> <select name="lang" required style="width:200px">
			<option value="auto">Auto</option>
			<option value="apache">Apache</option>
			<option value="bash">Bash</option>
			<option value="coffeescript">Coffee Script</option>
			<option value="cpp">C++</option>
			<option value="cs">C#</option>
			<option value="css">CSS</option>
			<option value="diff">Diff</option>
			<option value="http">HTTP</option>
			<option value="ini">Ini</option>
			<option value="java">Java</option>
			<option value="javascript">Java Script</option>
			<option value="json">JSON</option>
			<option value="makefile">Makefile</option>
			<option value="markdown">Markdown</option>
			<option value="nginx">Nginx</option>
			<option value="objectivec">Objective-C</option>
			<option value="perl">Perl</option>
			<option value="php">PHP</option>
			<option value="python">Python</option>
			<option value="ruby">Ruby</option>
			<option value="shell">Shell Session</option>
			<option value="sql">SQL</option>
			<option value="xml">HTML / XML</option>
		</select></p>
		<p><span style="width:80px;display:inline-block">제목 : </span>
			<input type="text" name="title" style="width:200px">&nbsp;&nbsp;&nbsp;&nbsp;
			<label style="padding:2px;display:inline-block"><input type="checkbox" name="number" value="1"> 줄번호 표시</label>
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
		$txtara = $editor.$textarea,
		$iframe = $editor.$element.find('iframe'),
		$orihtml = $('<div>'+($iframe.length > 0 ? $iframe.contents().find('body').html() : $txtara.val())+'</div>');

	var $_codes = $orihtml.find('pre[code-lang]');

	if($iframe.length > 0) {
		var $_selem,
			w = $iframe[0].contentWindow;
		if (w) {
			if (w.document.selection)
				$_selem = w.document.selection.createRange().parentElement();
			else {
				var selection = w.getSelection();
				if (selection.rangeCount > 0)
					$_selem = selection.getRangeAt(0).startContainer.parentNode;
			}
			$_selem = $($_selem);
			if(($_selem.attr('code-lang')||'') == '') $_selem = null;
		}
	}

	function code_highlighter_select() {
		var index = $('[name="newCode"]:checked').val();
		if($_selem || index > -1) {
			var $wc = $_selem ? $_selem : $_codes.eq(index),
				$tareas = $('textarea'),
				title = $wc.attr('title') || '',
				number = $wc.attr('number') || 0,
				lang = $wc.attr('code-lang') || 'auto';
			$('[name="title"]').val(title);
			$('[name="number"]').prop("checked", number > 0);
			$('[name="lang"]').val(lang);
			$tareas.eq(0).val($wc.text().trim());
		}
		$('.code_highlighter_selector').hide();
		$('.code_highlighter_editor').attr('data-index', index).show();
	}

	function code_highlighter_run() {
		var $tareas = $('textarea').eq(0),
			title = ($('[name="title"]').val() || '').replace('"', '`'),
			number = $('[name="number"]').is(":checked") ? 1 : 0,
			lang = $('[name="lang"]').val() || 'auto',
			index = $('.code_highlighter_editor').attr('data-index'),
			html;
		if($_selem || index > -1) {
			var $wc = $_selem ? $_selem : $_codes.eq(index);
			$wc.text($tareas.val());
			$wc.attr('code-lang', lang);
			title ? $wc.attr('title', title) : $wc.removeAttr('title');
			number > 0 ? $wc.attr('number', number) : $wc.removeAttr('number');
			if($iframe.length > 0) {
				if(!$_selem) $iframe.contents().find('body').html($orihtml.html());
			}else {
				$txtara.val($orihtml.text());
			}
		} else {
			html = '<pre code-lang="%s"%s%s>%s ' + "\n" + '</pre>' + "\n";
			$editor.paste(
				html.sprintf(lang, title ? ' title="'+title+'"' : '', number > 0 ? ' number="'+number+'"' : '',
					($tareas.val().escapeHtml() || ('/* 이 아래로 코드 입력 */' + "\n" + "\n"))
				),
				false
			);
		}

		alert('코드 문법강조 입력 완료');
		window.close();
	}

	if(!$_selem && $_codes && $_codes.length > 0){
		var $lbarea = $('.code_highlighter_selector').find('>div').eq(0),
			$label = $lbarea.find('label').eq(0);
		for (var i = 0; i < $_codes.length; i++) {
			$label.clone().find('span').text($_codes.eq(i).attr('title') || $_codes.eq(i).attr('code-lang')).end().find('input').val(i).removeAttr('checked').end().appendTo($lbarea);
		}
	} else {
		code_highlighter_select();
	}

</script>
<?php
/* End of file index.php */
/* Location: ./module/editor/components/code_highlighter/index.php */
