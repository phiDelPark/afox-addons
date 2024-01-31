<?php
if(!defined('__AFOX__')) exit();
?>
<div class="code_highlighter_editor">
	<div style="margin:10px">
		<p><span style="width:80px;display:inline-block">코드 타입 : </span>
		<select name="lang" required style="width:200px">
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
		<button class="btn btn-secondary" onclick="window.close()">취소</button>
		<button class="btn btn-success" onclick="code_highlighter_run()">확인</button>
	</div>
</div>

<script>
	const
		editor = opener.AFOX_EDITOR_<?php echo _AF_EDITOR_NAME_ ?>,
		form = document.querySelector('.code_highlighter_editor'),
		lang = form.querySelector('[name="lang"]'),
		collapse = form.querySelector('[name="code_collapse"]'),
		textarea = form.querySelector('textarea'),
		selection = editor.getSelection();

	const
		range = selection.getRangeAt(0),
		node = range?.startContainer.parentNode || null;

	if (node && node.tagName == 'CODE' && node.parentNode.tagName == 'PRE') {
		textarea.value = node.innerText;
		lang.value = node.getAttribute('class') || 'language-';
	}

	const code_highlighter_run = () => {
		let html = '<pre highlight%s><code class="%s">%s ' + "\n" + '</code></pre>' + "\n";
			html = html.sprintf(
				collapse.checked === true ? ' collapse="true"' : '',
				lang.value,
				textarea.value.escapeHTML() || ('/* 이 아래로 코드 입력 */' + "\n" + "\n")
			);
		if (node && node.tagName == 'CODE' && node.parentNode.tagName == 'PRE') {
			node.parentNode.outerHTML = html;
		}else{
			editor.pasteHtml(html);
		}
		alert('코드 문법강조 입력 완료');
		window.close();
	}
</script>
<?php
/* End of file editor.php */
/* Location: ./addon/code_highlighter/editor.php */
