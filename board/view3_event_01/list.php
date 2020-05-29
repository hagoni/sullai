<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">
    <p class="view_title">매장 이벤트</p>
    <ul class="tabmenu event_tab fs_def t_center">
		<li<?if($view3_tab == '' || $view3_tab == '1'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=1&type=view&idx=".$_REQUEST['idx']);?>">진행 중 이벤트</a></li>
		<li<?if($view3_tab == '2'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=2&type=view&idx=".$_REQUEST['idx']);?>">완료된 이벤트</a></li>
		<li<?if($view3_tab == '3'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=3&type=view&idx=".$_REQUEST['idx']);?>">전체 이벤트</a></li>
	</ul>
<?
if($total_data > 0) {
?>
    <div class="event_conts">
        <div class="event_cont01 event_cont">
        <!-- board list start -->
            <ul>
<?
    $list_page = 10;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
    page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
    $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
    $out_sql = mysql_query($sql);
    while($list = mysql_fetch_assoc($out_sql)) {
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','event_view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
        $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
        $now_day =  date("Y-m-d", time());
        $close_day = date("Y-m-d", strtotime($list['view3_close']));
        $list_img = explode("||",$list['view3_file']);
?>
        <li>
            <a href="<?=$path_view?>">
                <div class="img_area" style="background-image:url(<?=$option['user_list']?>)"></div>
                <div class="text_area">
                    <div class="prgr_wrap fs_def">
                        <?
                        if ($close_day < $now_day) {
                        ?>
                        <p class="prgr_box">진행 마감</p>
                        <?
                        } else {
                        ?>
                        <p class="prgr_box">진행중</p>
                        <?
                        }
                        ?>
                        <p class="prgr_date">~<?=$list['view3_close']?></p>
                    </div>
                    <p class="event_title ellipsis"><?=$option['notice'].$list['view3_title_01']?></p>
                    <p class="event_text">
<?
        echo $option['user_event_icon'];
        echo $option['event'];
?>
                    </p>
                </div>
                <a href="#none" class="event_link board_list_hit">자세히 보기</a>
            </a>
        </li>
<?
    }
?>
    <!-- //board list end -->

                <!-- <li>
                    <div class="img_area" style="background-image:url('../img/page/store/event_img1.jpg')"></div>
                    <div class="text_area">
                        <div class="prgr_wrap fs_def">
                            <p class="prgr_box">진행중</p>
                            <p class="prgr_date">~2020.03.15</p>
                        </div>
                        <p class="event_title ellipsis">새해福권을 드립니다!</p>
                        <p class="event_text">강강술래가 새해를 맞이하여 새해복권을 드립니다. 강강술래가 새해를 맞이하여 새해복권을 드립니다. a매장에서 식사를 하신 후 새해복권을 수령하세요~</p>
                        <a href="#none" class="event_link">자세히 보기</a>
                    </div>
                </li>
                <li>
                    <div class="img_area" style="background-image:url('../img/page/store/event_img1.jpg')"></div>
                    <div class="text_area">
                        <div class="prgr_wrap fs_def">
                            <p class="prgr_box">진행중</p>
                            <p class="prgr_date">~2020.03.15</p>
                        </div>
                        <p class="event_title ellipsis">새해福권을 드립니다!</p>
                        <p class="event_text">강강술래가 새해를 맞이하여 새해복권을 드립니다. a매장에서 식사를 하신 후 새해복권을 수령하세요~</p>
                        <a href="#none" class="event_link">자세히 보기</a>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>

    <!-- paging start -->
	<div class="paging fs_def">
		<?=$out_page?>
	</div>
	<!-- //paging end -->

<?
} else {
    switch($view3_tab){
        case '2':$no_data_text = '완료된 이벤트가 없습니다.';break;
        case '3':$no_data_text = '등록된 이벤트가 없습니다.';break;
        default:$no_data_text = '진행 중인 이벤트가 없습니다.';break;
    }
	echo '<p class="nodata">'.$no_data_text.'</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->
