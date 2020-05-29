<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<!-- board wrapper start -->
<div id="boardWrap">
<div class="event">
    <ul class="tabmenu fs_def">
        <li<?if($view3_tab == '' || $view3_tab == '1'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=1");?>">진행 중 이벤트</a></li>
        <li<?if($view3_tab == '2'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=2");?>">완료된 이벤트</a></li>
        <li<?if($view3_tab == '3'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=3");?>">전체 이벤트</a></li>
    </ul>
    <?
    if($total_data > 0) {
    ?>
    <!-- board list start -->
    <div class="event_cont">
        <ul class="board_list fs_def">
        <?
        $list_page = 10;
        $page_per_list = 10;
        $start = ($view3_page - 1) * $list_page;
        page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
        $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
        $out_sql = mysql_query($sql);
        while($list = mysql_fetch_assoc($out_sql)) {
            $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
            $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
            $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
            $now_day =  date("Y-m-d", time());
            $close_day = date("Y-m-d", strtotime($list['view3_close']));
            $list_img = explode("||",$list['view3_file']);
        ?>
            <li>
                <div class="img_area" style="background-image:url('<?=$root?>/upload/event_01<?=$list_img[2]?>')"></div>
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
                        <p class="prgr_date"><?=$option['event']?></p>
                    </div>
                    <p class="event_title ellipsis"><?=$option['notice'].$list['view3_title_01']?></p>
                    <a href="<?=$path_view?>" class="event_link board_list_hit">자세히 보기</a>
                </div>
            </li>
        <?
        }
        ?>
        </ul>
    </div>
    <!-- //board list end -->

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
</div>
