<? include_once "list_high.php"?>
<div class="view_conts">
    <!-- proud start -->
    <div class="view_cont02 view_cont proud" style="display:<?if ($view_tab != 2) {echo 'none';}?>">
            <p class="view_title">강강술래의 자부심</p>
            <ul class="proud_cont">
<?
$mem_sql = "select * from ".TABLE_LEFT."member_map_01 where view3_use = 1 and view3_map_idx = {$store_idx} order by view3_order desc, view3_write_day desc";
$mem_res = mysql_query($mem_sql);
$mem_cnt = 1;
while ($mem_lst = mysql_fetch_assoc($mem_res)) {
    $mem_img = explode("||",$mem_lst['view3_file']);
?>
    <li class="li<?=$mem_cnt?> clearfix">
        <div class="img_area" style="background-image:url('<?=$root?>/upload/member_map_01<?=$mem_img[2]?>')"></div>
        <div class="text_area">
            <div class="v_mid_1080">
                <p class="proud_title"><?=view3_html($mem_lst['view3_title_01'])?></p>
                <p class="proud_text"><?=view3_html($mem_lst['view3_command_01'])?></p>
            </div>
        </div>
    </li>
<?
$mem_cnt++;
}
?>


                <!-- <li class="li1 clearfix">
                    <div class="img_area" style="background-image:url('../img/page/store/proud_img1.jpg')"></div>
                    <div class="text_area">
                        <div class="v_mid_1080">
                            <p class="proud_title">고객님들을 위해 끊임없이 노력하는<br><em>늘봄농원점 김술래 점장입니다.</em></p>
                            <p class="proud_text">
                                안녕하십니까 강강술래 늘봄농원점 000점장입니다.<br>
                                늘봄농원점을 방문해 주시는 모든 고객님들께 최상의 맛<br class="br_m">과 <br class="br_768">서비스를 보여 드릴 수 있도록 노력하겠습니다.<br><br>

                                또한 봄, 여름, 가을, 겨울 계절별 제철 요리로 고객님들의 <br>오감만족을 위하여 끊임없이 연구하겠습니다.
                            </p>
                        </div>
                    </div>
                </li>
                <li class="li2 clearfix">
                    <div class="img_area" style="background-image:url('../img/page/store/proud_img2.jpg')"></div>
                    <div class="text_area">
                        <div class="v_mid_1080">
                            <p class="proud_title">고객님들의 오감만족을 책임지는<br><em>늘봄농원점 김강강 쉐프입니다</em></p>
                            <p class="proud_text">
                                안녕하십니까 강강술래 늘봄농원점 000점장입니다.<br>
                                늘봄농원점을 방문해 주시는 모든 고객님들께 최상의 맛<br class="br_m">과 <br class="br_768">서비스를 보여 드릴 수 있도록 노력하겠습니다.<br><br>

                                또한 봄, 여름, 가을, 겨울 계절별 제철 요리로 고객님들의 <br>오감만족을 위하여 끊임없이 연구하겠습니다.
                            </p>
                        </div>
                    </div>
                </li> -->
            </ul>
    </div>
    <!-- //proud end -->
</div>
<? include_once "list_bottom.php"?>
