<?php if($result):?>
	document.getElementById('conacyt_report').style.display = 'block';
	document.getElementById('conacyt_report_url').href = '<?=$url?>';
<?php else:?>
	document.getElementById('conacyt_report').style.display = 'none';
<?php endif;?>

