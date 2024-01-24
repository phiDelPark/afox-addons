<?php if(!defined('__AFOX__')) exit();
if(!_AF_EDITOR_NAME_){ $idx = $_GET['i'];
?>
<style id="web_code_style"></style><section id="web_code_panel" style="margin:20px"></section><script id="web_code_script"></script>
<script>
	var idx = <?php echo $idx - 1 ?>,
		blocks = opener.document.querySelectorAll('.current_content blockquote[webcode="group"]'),
		code1 = blocks[idx].querySelector('code[class^="language-html"]'),
		code2 = blocks[idx].querySelector('code[class^="language-css"]'),
		code3 = blocks[idx].querySelector('code[class^="language-javascript"]'),
		style = document.querySelector('#web_code_style'),
		panel = document.querySelector('#web_code_panel'),
		script = document.querySelector('#web_code_script');
	panel.outerHTML = code1.innerText;
	style.innerHTML = code2.innerText;
	script.innerHTML = code3.innerText;
</script>
<?php }else{ ?>
<div class="web_code_editor">
	<div style="margin:10px">
	<label>HTML</label> <input type="checkbox" id="id-html-collapse" style="margin-left:15px"><label for="id-html-collapse">접기/펼치기</label>
	<textarea style="width:100%;height:250px"></textarea>
	</div>
	<div style="margin:10px">
	<label>CSS</label> <input type="checkbox" id="id-css-collapse" style="margin-left:15px"><label for="id-css-collapse">접기/펼치기</label>
	<textarea style="width:100%;height:250px"></textarea>
	</div>
	<div style="margin:10px">
	<label>SCRIPT</label> <input type="checkbox" id="id-script-collapse" style="margin-left:15px"><label for="id-script-collapse">접기/펼치기</label>
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
		form = document.querySelector('.web_code_editor'),
		textareas = form.querySelectorAll('textarea'),
		checkboxs = form.querySelectorAll('[type=checkbox]'),
		selection = editor.getSelection()

	const range = selection.getRangeAt(0)
	let	node = range?.startContainer.parentNode || null

	if (node && node.tagName == 'CODE' && node.parentNode.tagName == 'PRE') {
		node = node.parentNode?.parentNode || null
		if(node && node.tagName == 'BLOCKQUOTE' && node.hasAttribute('webcode')){
			const codes = node.querySelectorAll('code')
			if(codes.length === 3){
				textareas[0].value = codes[0].innerText
				textareas[1].value = codes[1].innerText
				textareas[2].value = codes[2].innerText
				checkboxs[0].checked = codes[0].parentNode.hasAttribute('collapse')
				checkboxs[1].checked = codes[1].parentNode.hasAttribute('collapse')
				checkboxs[2].checked = codes[2].parentNode.hasAttribute('collapse')
			}
		}
	}

	const code_highlighter_run = () => {
		let html = '<blockquote webcode="group">\
<pre%s><code class="language-html">\
%s\
</code></pre>\
<pre%s><code class="language-css">\
%s\
</code></pre>\
<pre%s><code class="language-javascript">\
%s\
</code></pre>\
</blockquote>\
'+"\n";
		html = html.sprintf(
			checkboxs[0].checked === true ? ' collapse="true"' : '',
			textareas[0].value.escapeHtml() || ' ',
			checkboxs[1].checked === true ? ' collapse="true"' : '',
			textareas[1].value.escapeHtml() || ' ',
			checkboxs[2].checked === true ? ' collapse="true"' : '',
			textareas[2].value.escapeHtml() || ' '
		)
		if(node && node.tagName == 'BLOCKQUOTE' && node.hasAttribute('webcode')){
			node.outerHTML = html
		}else{
			editor.pasteHtml(html)
		}
		alert('코드 실행 입력 완료')
		window.close()
	}
</script>
<?php }
/* End of file editor.php */
/* Location: ./addon/web_code/editor.php */
