<?php
if(!defined('__AFOX__')) exit();
$default_except = 'img.youtube.com';
?>

<div>
	<label class="form-label" for="id_except">제외</label>
	<textarea maxbyte="65000" maxlength="65000" class="form-control" name="except" id="id_except"><?php echo escapeHtml(empty($_ADDON['except'])?$default_except:$_ADDON['except'])?></textarea>
	<p class="form-text">입력된 호스트의 이미지는 다운로드에서 제외합니다. (호스트 사이에 구분은 엔터(Enter)로 합니다)</p>
</div>
