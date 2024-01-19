<?php
if(!defined('__AFOX__')) exit();
if(empty($_ADDON['highlight_number'])) $_ADDON['highlight_number'] = 1;
if(empty($_ADDON['highlight_skin'])) $_ADDON['highlight_skin'] = "androidstudio";
?>

<div class="form-check">
	<input class="form-check-input" type="checkbox" name="highlight_number" id="id_no_number" value="1" <?php echo !empty($_ADDON['highlight_number'])?'checked':''?>>
	<label class="form-check-label" for="id_no_number">
	코드 앞에 줄 번호를 표시합니다.
	</label>
</div>

<div class="form-check">
	<input class="form-check-input" type="checkbox" name="auto_highlight" id="id_auto_highlight" value="1" <?php echo !empty($_ADDON['auto_highlight'])?'checked':''?>>
	<label class="form-check-label" for="id_auto_highlight">
	[PRE > CODE] 태그를 만나면 자동 적용합니다.
	</label>
</div>

<div class="mt-3">
	<label class="form-label">테마</label>
	<div class="input-group">
		<select class="form-control" name="highlight_skin">
			<option value="androidstudio" <?php echo $_ADDON['highlight_skin']=="androidstudio"?'selected':''?>>Android studio</option>
			<option value="atom-one-dark" <?php echo $_ADDON['highlight_skin']=="atom-one-dark"?'selected':''?>>Atom one-dark</option>
			<option value="atom-one-light" <?php echo $_ADDON['highlight_skin']=="atom-one-light"?'selected':''?>>Atom one-light</option>
			<option value="intellij-light" <?php echo $_ADDON['highlight_skin']=="intellij-light"?'selected':''?>>Intel lij-light</option>
			<option value="github" <?php echo $_ADDON['highlight_skin']=="github"?'selected':''?>>Github theme</option>
			<option value="github-dark" <?php echo $_ADDON['highlight_skin']=="github-dark"?'selected':''?>>Github dark theme</option>
		</select>
	</div>
</div>

<hr>

<h5>사용예 :</h5>
<pre class="border rounded p-3">
&lt;pre highlight&gt;&lt;code class="language-cpp"&gt; 
/* 이 아래로 코드 입력 */

&lt;/code&gt;&lt;/pre&gt;

&lt;pre highlight&gt;&lt;code class="language-javascript"&gt; 
/* 이 아래로 코드 입력 */

&lt;/code&gt;&lt;/pre&gt;
</pre>

<h5>참고사항 :</h5>
<pre class="border rounded p-3">
입력을 쉽게 하시려면 Code Highlighter 에디터 콤포넌트를 사용하세요.
</pre>