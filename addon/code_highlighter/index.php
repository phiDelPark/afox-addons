<?php
if(!defined('__AFOX__')) exit();

if($called_position == 'after_disp' && $called_trigger == 'default' && !empty($_DATA['wr_content'])) {
	if(!empty($_ADDON['auto-highlight'])){
		$_DATA['wr_content'] = preg_replace('/(<pre(?:|\s*(?!(>|code-lang)).*?))(>[\s\t\r\n]*<code(?:|\s+[^>]*)>)/mi', '\1 code-lang="auto"\3', $_DATA['wr_content']);
	}
	/* https://highlightjs.org */
	if(preg_match('/<pre[^>]*code-lang="[a-zA-Z0-9]+"/', $_DATA['wr_content'])){
		addCSS('//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/default.min.css');
		addJS('//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js');
		addJS('//cdnjs.cloudflare.com/ajax/libs/highlightjs-line-numbers.js/2.8.0/highlightjs-line-numbers.min.js');
		addCSS(_AF_URL_.'addon/code_highlighter/code_highlighter.css');
		addJS(_AF_URL_.'addon/code_highlighter/code_highlighter.js?w='.(empty($_ADDON['pre-wrap'])?'0':'1').(__DEBUG__?'&'._AF_SERVER_TIME_:''));
	}
}

/* End of file index.php */
/* Location: ./addon/code_highlighter/index.php */
