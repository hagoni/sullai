<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$path_event_list = view3_link("||idx||view_page||store","list_event&store=".$_GET['store'],"",$end_path);//목록 클릭시 링크
if(!$_REQUEST['modal']) {
?>
				<div class="view_btns_wrap">
<?
	if($temp_prev) {
?>
					<!-- <a href="<?=URL_PATH.'?'.$path_prev?>" class="list_prevnext list_prev">PREVIOUS</a> -->
<?
	}
?>
					<a href="<?=URL_PATH.'?'.$path_event_list?>" class="list_return">LIST</a>
<?
	if($temp_next) {
?>
					<!-- <a href="<?=URL_PATH.'?'.$path_next?>" class="list_prevnext list_next">NEXT</a> -->
<?
	}
?>
				</div>
<?
}
?>
