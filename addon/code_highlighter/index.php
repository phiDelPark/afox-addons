<?php
if(!defined('__AFOX__')) exit();

if($called_position == 'after_disp' && $called_trigger == 'default' && !empty($_DATA['wr_content'])) {
	if(!empty($_ADDON['auto_highlight'])){
		$_DATA['wr_content'] = preg_replace('/(<pre(?:|\s*(?!(>|highlight)).*?))(>[\s\t\r\n]*<code(?:|\s+[^>]*)>)/mi', '\1 highlight\3', $_DATA['wr_content']);
	}
	/* https://highlightjs.org */
	if(preg_match('/<pre[^>]*highlight/', $_DATA['wr_content'])){
		addCSS('//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/'.($_ADDON['highlight_skin']).'.min.css');
		addJS('//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
		addJS('//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js');
		addCSS(_AF_URL_.'addon/code_highlighter/code_highlighter'.(__DEBUG__ ? '' : '.min').'.css');
		addJS(_AF_URL_.'addon/code_highlighter/code_highlighter'.(__DEBUG__ ? '' : '.min').'.js?n='.($_ADDON['highlight_number']));
	}
}

/* End of file index.php */
/* Location: ./addon/code_highlighter/index.php */
