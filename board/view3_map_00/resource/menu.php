<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
define('MAIN_TYPE',													'MAIN',TRUE);
@include_once														"../../../view3.php";
######################################################################################################################################################
?>

<div id="menuModalPopup" class="menu_pop">
    <div class="slider-container">
        <ul class="slider-wrapper">
<?
$menu_board = 'menu_01';
$menu_sql_query = "SELECT * FROM `".TABLE_LEFT.$menu_board."` WHERE view3_use = '1' AND view3_idx in (".$_POST['mn_idx'].")  ORDER BY view3_order DESC, view3_idx DESC";
$menu_result = mysql_query($menu_sql_query);
$menu_count = mysql_num_rows($menu_result);
if($menu_count > 0) {
	while($menu_list = mysql_fetch_assoc($menu_result)) {
		$menu_temp_file = explode('||', $menu_list['view3_file']);
		$menu_img = $menu_temp_file[2] ? $pc.'/upload/'.$menu_board.'/'.$menu_temp_file[2] : $root.'/img/s05_simg01.png';
?>
            <li class="slider-items">
                <div class="menu_pop_img"><img src="<?=$menu_img?>" alt="" class="w100" /></div>
                <div class="menu_pop_txt_area rel">
                    <div class="text_area">
                        <p class="menu_pop_tit"><?=html_entity_decode($menu_list['view3_title_01'])?></p>
                        <p class="menu_pop_txt"><?=nl2br(html_entity_decode($menu_list['view3_command_01']))?></p>
                    </div>
                </div>
            </li>
<?
    }
}
?>
        </ul>
    </div>
    <a href="#none" class="menu_pop_close"><span class="indent">팝업창닫기</span></a>
    <button type="button" class="slider-btns slider-prev">이전</button>
    <button type="button" class="slider-btns slider-next">다음</button>
</div>
