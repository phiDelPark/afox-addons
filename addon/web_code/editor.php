<?php if(!defined('__AFOX__')) exit();
if(!_AF_EDITOR_NAME_){ $idx = $_GET['i'];
?>
<style id="web_code_style"></style><div id="web_code_panel" style="margin:20px"></div><script id="web_code_script"></script>
<script>
	var idx = <?php echo $idx - 1 ?>,
		blocks = opener.document.querySelectorAll('.current_content blockquote[webcode="group"]'),
		code1 = blocks[idx].querySelector('code[class^="language-html"]'),
		code2 = blocks[idx].querySelector('code[class^="language-css"]'),
		code3 = blocks[idx].querySelector('code[class^="language-javascript"]'),
		style = document.querySelector('#web_code_style'),
		panel = document.querySelector('#web_code_panel'),
		script = document.querySelector('#web_code_script');
	panel.innerHTML = code1.innerText;
	style.innerHTML = code2.innerText;
	script.innerHTML = code3.innerText;
</script>
<?php }else{ ?>
<div class="web_code_editor">
	<div style="margin:10px">
	<label>HTML</label>
	<textarea style="width:100%;height:250px"></textarea>
	</div>
	<div style="margin:10px">
	<label>CSS</label>
	<textarea style="width:100%;height:250px"></textarea>
	</div>
	<div style="margin:10px">
	<label>SCRIPT</label>
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
		selection = editor.getSelection();

	const range = selection.getRangeAt(0);
	let	node = range?.startContainer.parentNode || null;

	if (node && node.tagName == 'CODE' && node.parentNode.tagName == 'PRE') {
		node = node.parentNode?.parentNode || null;
		if(node && node.tagName == 'BLOCKQUOTE' && node.hasAttribute('webcode')){
			const codes = node.querySelectorAll('code');
			if(codes.length === 3){
				textareas[0].value = codes[0].innerText;
				textareas[1].value = codes[1].innerText;
				textareas[2].value = codes[2].innerText;
			}
		}
	}

	const code_highlighter_run = () => {
		let html = '<blockquote webcode="group">\
<pre><code class="language-html">\
%s\
</code></pre>\
<pre><code class="language-css">\
%s\
</code></pre>\
<pre><code class="language-javascript">\
%s\
</code></pre>\
<button webcode="run">코드 실행</button>\
</blockquote>\
';
		html = html.sprintf(
			textareas[0].value.escapeHtml() || ' ',
			textareas[1].value.escapeHtml() || ' ',
			textareas[2].value.escapeHtml() || ' '
		);
		if(node && node.tagName == 'BLOCKQUOTE' && node.hasAttribute('webcode')){
			node.outerHTML = html;
		}else{
			editor.pasteHtml(html);
		}
		alert('코드 실행 입력 완료');
		window.close();
	}
</script>
<?php }
/* End of file editor.php */
/* Location: ./addon/web_code/editor.php */
