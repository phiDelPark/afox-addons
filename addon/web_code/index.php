<?php
if(!defined('__AFOX__')) exit();

if($called_position == 'after_disp' && $called_trigger == 'default' && !empty($_DATA['wr_content'])) {
	if(preg_match('/<blockquote[^>]*web-code="area"/', $_DATA['wr_content'])){
		addCSS(_AF_URL_.'addon/web_code/web_code.css');
		addJS(_AF_URL_.'addon/web_code/web_code.js?w='.(empty($_ADDON['pre-wrap'])?'0':'1').(__DEBUG__?'&'._AF_SERVER_TIME_:''));
	}
}

/* End of file index.php */
/* Location: ./addon/web_code/index.php */
