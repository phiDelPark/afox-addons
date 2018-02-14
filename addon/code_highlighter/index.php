<?php
if(!defined('__AFOX__')) exit();

if($called_position == 'after_disp' && $called_trigger == 'default' && !empty($_DATA['wr_content'])) {
	if(preg_match('/<pre[^>]*code-lang="[a-zA-Z0-9]+"/', $_DATA['wr_content'])){
		addCSS('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css');
		addJS('//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js');
		addCSS(_AF_URL_.'addon/code_highlighter/code_highlighter.css');
		addJS(_AF_URL_.'addon/code_highlighter/code_highlighter.js?c='.(empty($_ADDON['collapse'])?'0':'1').(__DEBUG__?'&'._AF_SERVER_TIME_:''));
	}
}

/* End of file index.php */
/* Location: ./addon/code_highlighter/index.php */
