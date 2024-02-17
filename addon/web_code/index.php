<?php if(!defined('__AFOX__')) exit();

if($_CALLED['position'] == 'after_disp' && $_CALLED['trigger'] == 'default')
{
	if(preg_match('/> ```html[\\a-zA-Z_-]*\n>/', $_DATA['wr_content'])){
		addCSS(_AF_URL_.'addon/web_code/web_code'.(__DEBUG__ ? '' : '.min').'.css');
		addJS(_AF_URL_.'addon/web_code/web_code'.(__DEBUG__ ? '' : '.min').'.js?');
	}
}

/* End of file index.php */
/* Location: ./addon/web_code/index.php */
