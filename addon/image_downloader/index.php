<?php
if (!defined('__AFOX__')) exit();

if ($called_position == 'after_proc' && $called_trigger == 'updatedocument' && !empty($_DATA['wr_srl'])) {

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
			'svgz' => 'image/svg+xml'
		);

		$content = preg_replace_callback(
			'/(<img[^>]*?\s?src\s*=\s*["\']?)(https?:[^>"\']*)/i',
			function ($m) use ($md_id, $wr_srl, $mb_srl, $mb_ipaddress, $except, $mimes, &$file_count, &$_check) {
				$url = $m[2];

				if(preg_match('/^https?:[\/]+('. $except .')/i', $url)) {
					return $m[1].$url;
				}

				if(empty($_check[$url])) {

					$parts = pathinfo(parse_url($url, PHP_URL_PATH));

					$iname = $parts['filename'];
					$iext = explode('?', empty($parts['extension']) ? '' : $parts['extension']);
					$iext = strtolower(empty($iext[0]) ? 'none' : $iext[0]);

					// Immediately remove the direct file if it has any kind of extensions for hacking
					$iext = preg_replace('/(php|phtm|phar|html?|cgi|pl|exe|jsp|asp|inc)/i', '$0-x', $iext);

					$upload_name = md5($iname . time() . count($_check)) . '.' . $iext;
					$uploaded_filename = _AF_ATTACH_DATA_ . 'image/' . $md_id . '/' . $wr_srl . '/' . $upload_name;

					$_check[$url] = $url . '" target="download-failure';

					// 폴더 없으면 만듬
					$dir = dirname($uploaded_filename);
					if(!is_dir($dir) && !mkdir($dir, _AF_DIR_PERMIT_, true)) {
						return $m[1].$_check[$url];
					}

					// @copy($url, $uploaded_filename);
					if(function_exists("curl_init") === true) {
						$ch = curl_init($url);
						$fp = fopen($uploaded_filename, 'wb');
						curl_setopt($ch, CURLOPT_FILE, $fp);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_exec($ch);
						curl_close($ch);
						fclose($fp);
					}
					else if (function_exists("file_put_contents") === true) {
						file_put_contents($uploaded_filename, file_get_contents($url));
					}

					if(file_exists($uploaded_filename)) {
						@chmod($uploaded_filename, _AF_FILE_PERMIT_);

						// 공개 하게되면  크기 체크기능 넣자
						// size-limit-single
						// size-limit-total

						if(DB::insert(_AF_FILE_TABLE_, [
							'md_id'=>$md_id,
							'mf_target'=>$wr_srl,
							'mf_name'=>$iname . '.' . $iext,
							'mf_upload_name'=>$upload_name,
							'mf_size'=>filesize($uploaded_filename),
							'mf_type'=>empty($mimes[$iext])?'image/none':$mimes[$iext],
							'mb_srl'=>$mb_srl,
							'mb_ipaddress'=>$mb_ipaddress,
							'^mf_regdate'=>'NOW()'
						]) === true) {
							$mf_srl = DB::insertId();
							$file_count++;
							$_check[$url] = './?file=' . $mf_srl;
						} else {
							unlinkFile($uploaded_filename);
							$_check[$url] = $url . '" data-error="insert-error';
						}
					}

				}

				return $m[1].$_check[$url];
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
