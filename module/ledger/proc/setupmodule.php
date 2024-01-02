<?php

if(!defined('__AFOX__')) exit();

function proc($data) {

	if(!empty($data['md_category']) && preg_match('/[\x{21}-\x{2b}\x{2d}\x{2f}\x{3a}-\x{40}\x{5b}-\x{60}]+/', $data['md_category'])) {
		return set_error(getLang('invalid_value', ['category']),2001);
	}

	$value = cutstr(trim($data['md_category']),20,'');
	if(empty($value)){
		return set_error(getLang('invalid_value', ['category']),2001);
	}

	$ca_srl = empty($data['md_srl']) ? 0 : $data['md_srl'];

	if($ca_srl > 0) {
	  $ret = DB::get(_AF_LEDGER_CATEGORY_TABLE_, 'ca_srl', ['ca_srl'=>$ca_srl]);
	  $num_rows = DB::numRows();
	  if($num_rows == 0) return set_error(getLang('error_request'),4303);
	}

	DB::transaction();

	try {

		if (empty($ca_srl)) {
			DB::insert(_AF_LEDGER_CATEGORY_TABLE_,
				[
					'ca_name'=>$value
				]
			);
			$insert_id = DB::insertId();
		} else {
			DB::update(_AF_LEDGER_CATEGORY_TABLE_,
				[
					'ca_name'=>$value
				], [
					'ca_srl'=>$ca_srl
				]
			);
			$insert_id = $ca_srl;
		}

	//CONTENT = 0;  //CATEGORY = 1;  //INSERT = 1;  //MODIFY = 2;  //DELETE = 3;
	// CATEGORY * 10000 + (id > 0 ? MODIFY : INSERT)
	DB::insert(_AF_LEDGER_HISTORY_TABLE_, ['hs_target'=>$insert_id, 'hs_work' => (int)($ca_srl > 0 ? 10002 : 10001), '^hs_changed' => 'NOW()']);

	} catch (Exception $ex) {
		DB::rollback();
		return set_error($ex->getMessage(),$ex->getCode());
	}

	DB::commit();

	return ['error'=>0, 'message'=>getLang('success_saved')];
}

/* End of file setupmodule.php */
/* Location: ./module/ledger/proc/setupmodule.php */
