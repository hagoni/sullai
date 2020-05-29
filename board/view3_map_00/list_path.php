<? include_once "list_high.php"?>
<div class="view_conts">
    <!-- location start -->
    <div class="view_cont03 view_cont location" style="display:<?if ($view_tab != 3) {echo 'none';}?>">
        <p class="view_title">오시는 길</p>
        <div class="map_area" id="map_area"></div>
        <div class="loc_cont">
            <div class="title_area">
                <p class="loc_title">강강술래 <?=$list['view3_title_01']?></p>
                <p class="loc_text">
                    <?if ($list['view3_special_11'] != "") {echo "좌석 : {$list['view3_special_11']}";}?><?if ($list['view3_check_02'] > 10) {echo "/ 주차 가능 대수 : ".$list['view3_check_02'];}?>
                </p>
            </div>
            <ul class="info_area">
                <?if ($list['view3_addr_road'] != ""){?>
                    <li>
                        <p class="info_title">주소</p>
                        <p class="info_text"><?=$list['view3_addr_road'].' '.$list['view3_addr_detail']?></p>
                    </li>
                <?}?>
                <?if ($list['view3_special_04'] != ""){?>
                <li>
                    <p class="info_title">전화번호</p>
                    <p class="info_text h40"><?=$list['view3_special_04']?>
                        <?if ($list['view3_link_naver'] != "") {?><a href="<?=$list['view3_link_naver']?>" class="res_btn" target="_blank"><img src="<?=$root?>/img/page/store/naver_res_btn.jpg" alt="예약하기" class="w100"></a><?}?>
                    </p>
                </li>
                <?}?>
                <?if ($list['view3_special_02'] != ""){?>
                <li>
                    <p class="info_title">영업시간</p>
                    <p class="info_text"><?=$list['view3_special_02']?></p>
                </li>
                <?}?>
                <!-- <li>
                    <p class="info_title">카카오네비</p>
                    <p class="info_text navi">네비게이션</p>
                </li> -->
            </ul>
        </div>
    </div>
    <!-- //location end -->
</div>

<? include_once "list_path_bottom.php"?>
