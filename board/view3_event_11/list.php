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


        <!-- <ul class="tabmenu fs_def">
    		<li<?if($view3_tab == '' || $view3_tab == '1'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=1");?>">진행 중 이벤트</a></li>
    		<li<?if($view3_tab == '2'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=2");?>">완료된 이벤트</a></li>
    		<li<?if($view3_tab == '3'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=3");?>">전체 이벤트</a></li>
    	</ul> -->

    <?
    if($total_data > 0) {
    ?>
        <div class="event_cont">
            <!-- board list start -->
            <ul class="board_list fs_def">
        <?
            $list_page = 12;
            $page_per_list = 5;
            $start = ($view3_page - 1) * $list_page;
            page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
            $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
            $out_sql = mysql_query($sql);
            while($list = mysql_fetch_assoc($out_sql)) {
                $open_day = date("Y-m-d", strtotime($list['view3_open']));
                $now_day =  date("Y-m-d", time());
                if ($open_day <= $now_day) {
                    $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
                    $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
                    $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
                    $close_day = date("Y-m-d", strtotime($list['view3_close']));
                    $list_img = explode("||",$list['view3_file']);
                    ?>
                            <li>
                                <a href="<?=$path_view?>">
                                    <div class="img_area">
                                        <img src="<?=$root?>/upload/event_01<?=$list_img[2]?>" alt="">
                                    </div>
                                    <div class="text_area">
                                        <p class="event_title"><?=$option['notice'].$list['view3_title_01']?></p>
                                        <div class="prgr_wrap fs_def">
                                            <?
                                            if ($close_day < $now_day) {
                                            ?>
                                            <p class="prgr_box end">진행 마감</p>
                                            <?
                                            } else {
                                            ?>
                                            <p class="prgr_box">진행중</p>
                                            <?
                                            }
                                            ?>
                                            <p class="prgr_date"><?=$option['event']?></p>
                                        </div>
                                    </div>
                                    <!-- <p class="board_list_right board_list_hit b_fs_s b_ff_l b_c_l">HIT : <?=$list['view3_hit']?></p> -->
                                </a>
                            </li>
                    <?
                }
            }
        ?>
            </ul>
            <!-- //board list end -->
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
</div>
<!-- //board wrapper end -->
