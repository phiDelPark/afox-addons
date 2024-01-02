<?php
if(!defined('__AFOX__')) exit();
@include_once dirname(__FILE__) . '/config.php';
$_MD_CONFIG = getModule('@ledger');
$isLedgerDB = DB::status(_AF_LEDGER_DATA_TABLE_);
?>

<form action="<?php echo _AF_URL_ ?>" method="post" autocomplete="off" enctype="multipart/form-data">
	<input type="hidden" name="success_return_url" value="<?php echo getUrl('', 'admin', 'module', 'mid', $_DATA['mid']) ?>">
	<input type="hidden" name="error_return_url" value="<?php echo getUrl('', 'admin', 'module', 'mid', $_DATA['mid']) ?>">
	<input type="hidden" name="module" value="<?php echo $_DATA['mid'] ?>">
	<input type="hidden" name="act" value="<?php echo $isLedgerDB ? 'setupmodule' : 'createmoduledb' ?>">
	<?php
		if($isLedgerDB){
	?>

		<div class="form-group">
			<label for="id_md_category"><?php echo getLang('category')?></label>
			<input type="text" name="md_category" class="form-control" id="id_md_category" maxlength="255" pattern="^[^\x21-\x2b\x2d\x2f\x3a-\x40\x5b-\x60]+" required placeholder="<?php echo getLang('desc_ledger_category')?>">
		</div>

	<?php
		} else {
	?>

	<p>
	<div class="panel panel-info" role="alert">
		<div class="panel-body">
		<?php echo getLang('desc_create_module_db')?>
		</div>
	</div>
	</p>

	<?php
		}
	?>
	<div class="form-group">
	<?php
		if($isLedgerDB){
	?>
		<button type="submit" class="btn btn-success mw-20"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i> <?php echo getLang('insert')?></button>
	<?php
		} else {
	?>
		<button type="submit" class="btn btn-primary mw-20"><i class="glyphicon glyphicon-ok" aria-hidden="true"></i> <?php echo getLang('btn_create_module_db')?></button>
	<?php
		}
	?>
	</div>
	<div class="modal-footer">
	</div>
</form>
<form action="<?php echo _AF_URL_ ?>" method="post" autocomplete="off" enctype="multipart/form-data">
	<div class="form-group">
		<label><?php echo getLang('category')?></label>
	</div>
	<div class="form-group">
		<ul>
		<?php
		if($isLedgerDB){
			$categorys = getCategorys();
			foreach($categorys as $val){
				echo '<li data-srl="' . $val['ca_srl'] . '">' . $val['ca_name'] . '</li>';
			}
		}
		?>
		</ul>
	</div>
</form>
<?php
/* End of file setup.php */
/* Location: ./module/ledger/setup.php */
