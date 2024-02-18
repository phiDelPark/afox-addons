<?php if(!defined('__AFOX__')) exit();
if(!_AF_EDITOR_NAME_){ $idx = $_GET['i'];
?>
<style id="web_code_style"></style><section id="web_code_panel" style="margin:20px"></section>
<script>
	let idx = <?php echo $idx - 1 ?>,
		blocks = opener.document.querySelectorAll('.current_content blockquote[webcode="group"]'),
		code1 = blocks[idx].querySelector('code[class^="language-html"]'),
		code2 = blocks[idx].querySelector('code[class^="language-css"]'),
		code3 = blocks[idx].querySelector('code[class^="language-javascript"]'),
		style = document.querySelector('#web_code_style'),
		panel = document.querySelector('#web_code_panel')
	panel.outerHTML = code1.innerText
	style.innerHTML = code2.innerText
	let script = document.createElement('script'), importJs = [], n = 0;
	script.innerHTML = code3.innerText.replace(/@import url\([\'\"](.+)[\'\"]\);$/gm,function(match,g1){importJs[n++]=g1;return''})
	if(importJs.length > 0){importJs.forEach((url,i)=>{load_script(url).then(()=>{if(i===(n-1)){style.parentNode.appendChild(script)}},()=>{})})
	} else style.parentNode.appendChild(script)
</script>
<?php }else{ ?>
<div class="web_code_editor">
	<div style="margin:10px">
	<label>HTML</label> <input type="checkbox" id="id-html-collapse" style="margin-left:15px"><label for="id-html-collapse">접기/펼치기</label>
	<textarea style="width:100%;height:200px"></textarea>
	</div>
	<div style="margin:10px">
	<label>CSS</label> <input type="checkbox" id="id-css-collapse" style="margin-left:15px"><label for="id-css-collapse">접기/펼치기</label>
	<textarea style="width:100%;height:200px"></textarea>
	</div>
	<div style="margin:10px">
	<label>SCRIPT</label> <input type="checkbox" id="id-script-collapse" style="margin-left:15px"><label for="id-script-collapse">접기/펼치기</label>
	<textarea style="width:100%;height:200px"></textarea>
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

	if (node && node.tagName == 'CODE' || node.tagName == 'PRE') {
		node = node.parentNode || null
		if(node.tagName != 'BLOCKQUOTE') node = node.parentNode || null
		if(node && node.tagName == 'BLOCKQUOTE'){
			const codes = node.querySelectorAll('code[class^=language-]')
			if(codes.length === 3){
				codes.forEach((el, i)=>{
					textareas[i].value = codes[i].innerText
					let c = el.getAttribute('class').split('\\')
					checkboxs[i].checked = (c[1] || '') == 'collapse'
				})
			}
		}
	}

	const code_highlighter_run = () => {
		let html = '<blockquote>\
<pre><code class="language-html%s">\
%s\
</code></pre>\
<pre><code class="language-css%s">\
%s\
</code></pre>\
<pre><code class="language-javascript%s">\
%s\
</code></pre>\
</blockquote>\
'+"\n";
		html = html.sprintf(
			checkboxs[0].checked === true ? '\\collapse' : '',
			textareas[0].value.escapeHTML() || ' ',
			checkboxs[1].checked === true ? '\\collapse' : '',
			textareas[1].value.escapeHTML() || ' ',
			checkboxs[2].checked === true ? '\\collapse' : '',
			textareas[2].value.escapeHTML() || ' '
		)
		if(node && node.tagName == 'BLOCKQUOTE'){
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
