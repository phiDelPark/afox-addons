<?php if (!defined('__AFOX__')) exit();

if($_CALLED['position'] == 'after_proc' && $_CALLED['trigger'] == 'updatedocument')
{
	if(empty($_DATA['wr_srl'])) return false;

	$doc = DB::get(_AF_DOCUMENT_TABLE_, 'md_id,wr_content,wr_file,mb_srl,mb_ipaddress', ['wr_srl'=>$_DATA['wr_srl']]);
	if (!empty($doc)) {
		$wr_srl = $_DATA['wr_srl'];
		$md_id = $doc['md_id'];
		$mb_srl = $doc['mb_srl'];
		$mb_ipaddress = $doc['mb_ipaddress'];

		$file_count = (int)$doc['wr_file'];
		$_check = [];

		if (empty($_ADDON['except'])) $_ADDON['except'] = 'img.youtube.com';
		$except = str_replace("\n", '|', trim($_SERVER['HTTP_HOST'] . "\n" . $_ADDON['except']));

		$mimes = array(
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',
			'webp' => 'image/webp'
		);

		$content = preg_replace_callback(
			'/(\!\[[^\]]+]\()([^\)\"]+)((?:(?(R)\"|\s\"([^\"]+)\"\))|\)))/us',
			function ($m) use ($md_id, $wr_srl, $mb_srl, $mb_ipaddress, $except, $mimes, &$file_count, &$_check) {
				$url = $m[2];

				if(
					!preg_match('/^https?:/i', $url)
					|| preg_match('/^https?:[\/]+('. $except .')/i', $url)
				) {
					return $m[1].$url.$m[3];
				}

				if(empty($_check[$url])) {

					$parts = pathinfo(parse_url($url, PHP_URL_PATH));

					$iname = $parts['filename'];
					$iext = explode('?', empty($parts['extension']) ? '' : $parts['extension']);
					$iext = strtolower(empty($iext[0]) ? 'none' : $iext[0]);

					// Immediately remove the direct file if it has any kind of extensions for hacking
					$iext = preg_replace('/(php|phtm|phar|html?|cgi|pl|exe|jsp|asp|inc)/i', '$0-x', $iext);

					$upload_name = md5(count($_check).$iname.time());
					$upload_path = _AF_ATTACH_DATA_.'image/'.$md_id.'/'.$wr_srl.'/';

					// 폴더 없으면 만듬
					$dir = dirname($upload_path.$upload_name);
					if(!is_dir($dir) && !mkdir($dir, _AF_DIR_PERMIT_, true)) {
						return $m[1].$url.' "download-failure")';
					}

					$down_url = empty($mimes[$iext]) ? $url : strtok($url, '?');

					// @copy($url, $upload_path.$upload_name);
					if(function_exists("curl_init") === true) {
						$ch = curl_init($down_url);
						$fp = fopen($upload_path.$upload_name, 'wb');
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);
					}
					else if (function_exists("file_put_contents") === true) {
						file_put_contents($upload_path.$upload_name, file_get_contents($down_url));
					}

					$uploaded_filename = $upload_path.$upload_name;
					if(file_exists($uploaded_filename)) {
						// size-limit-single
						// size-limit-total

						$size = filesize($uploaded_filename);
						//$iinfo = getimagesize($uploaded_filename);

						if(DB::insert(_AF_FILE_TABLE_, [
							'md_id'=>$md_id,
							'mf_target'=>$wr_srl,
							'mf_name'=>$iname.'.'.$iext,
							'mf_upload_name'=>$upload_name,
							'mf_size'=>$size,
							'mf_type'=>empty($mimes[$iext])?'image/none':$mimes[$iext],
							'mb_srl'=>$mb_srl,
							'mb_ipaddress'=>$mb_ipaddress,
							'mf_regdate(=)'=>'NOW()'
						]) === true) {
							$mf_srl = DB::insertId();
							$file_count++;
							$_check[$url]='./?file='.$mf_srl;
							@chmod($uploaded_filename, _AF_ATTACH_PERMIT_);
						} else {
							unlinkFile($uploaded_filename);
							return $m[1].$url.' "insert-failure")';
						}
					}
				}

				return $m[1].$_check[$url].$m[3];
			},
			$doc['wr_content']
		);

		if(count($_check) > 0 || $file_count > 0) {
			DB::update(_AF_DOCUMENT_TABLE_, ['wr_content'=>$content,'wr_file'=>$file_count], ['wr_srl'=>$wr_srl]);
		}
	}
}

/* End of file index.php */
/* Location: ./addon/image_downloader/index.php */
