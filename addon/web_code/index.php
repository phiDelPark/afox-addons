<?php
if(!defined('__AFOX__')) exit();

if($called_position == 'after_disp' && $called_trigger == 'default' && !empty($_DATA['wr_content'])) {
	if(preg_match('/<blockquote[^>]*web-code="area"/', $_DATA['wr_content'])){
		addCSS(_AF_URL_.'addon/web_code/web_code'. (__DEBUG__ ? '.css?' . _AF_SERVER_TIME_ : '.min.css'));
		addJS(_AF_URL_.'addon/web_code/web_code'. (__DEBUG__ ? '.js?' . _AF_SERVER_TIME_ : '.min.js?w='.(empty($_ADDON['pre-wrap'])?'0':'1')));
	}
}

/* End of file index.php */
/* Location: ./addon/web_code/index.php */
