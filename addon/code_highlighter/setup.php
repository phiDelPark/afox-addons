<?php
if(!defined('__AFOX__')) exit();
?>

<div class="form-group">
	<label class="checkbox" tabindex="0">
		<input type="checkbox" name="pre-wrap" value="1" <?php echo !empty($_ADDON['pre-wrap'])?'checked':''?>>
		<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
		코드를 자동 줄바꿈 합니다.
	</label>
	<label class="checkbox" tabindex="0">
		<input type="checkbox" name="auto-highlight" value="1" <?php echo !empty($_ADDON['auto-highlight'])?'checked':''?>>
		<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
		 [PRE > CODE] 태그를 만나면 자동 적용
	</label>
</div>
<br>
<h3>사용 예제:</h3>
<pre>
&lt;pre code-lang="cpp"&gt; 
/* 이 아래로 코드 입력 */

&lt;/pre&gt;

&lt;pre code-lang="javascript"&gt; 
/* 이 아래로 코드 입력 */

&lt;/pre&gt;
</pre>
<h3>* 참고 :</h3>
<pre>
입력을 쉽게 하시려면 Code Highlighter 에디터 콤포넌트를 사용하세요.
</pre>
