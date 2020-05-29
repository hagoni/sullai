<ul class="tabmenu fs_def t_center">
    <li class="on"><a href="#none">인사제도</a></li>
    <li><a href="#none">공고현황</a></li>
</ul>
<div class="tab_conts">
    <div class="tab_cont01 tab_cont">
        <div class="banner_area bg">
            <div class="pc_inner">
                <p class="stitle">(주)전한에서<br><em>열정가득한 인재를 <br class="br_m1080">기다립니다.</em></p>
                <p class="text">(주)전한은 글로벌 외식문화기업으로<br class="br_m">함께 성장해 나갈 <br class="br_768">창의적이고 <br class="br_m">열정적인 인재를 모집합니다.</p>
            </div>
        </div>
        <div class="process cmn_layer">
            <p class="stitle t_center">채용프로세스</p>
            <ul class="t_center">
                <li>
                    <div class="text_area">
                        <p class="stitle"><em>영업점 채용</em></p>
                        <p class="text">서류심사 - 면접 - 최종합격</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="stitle wt"><em>본사 채용</em></p>
                        <p class="text wt">서류심사 - 1차면접<br>2차면접 - 최종합격</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="stitle"><em>JMP<br>공채프로그램</em></p>
                        <p class="text"><a href="#none" target="_blank">이미지 참고</a></p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="welfare cmn_layer pc_inner">
            <p class="stitle t_center">복리후생 안내</p>
            <ul class="fs_def">
                <li>
                    <div class="text_area">
                        <p class="sm_title">경조사비 지급</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">상조회 운용</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">명절 귀향비 지급</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">중식 제공</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">연차휴가</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">퇴직연금</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">사내동호회</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">기숙사 지원</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">복지 지원금 지급</p>
                        <p class="sm_text">(복지카드 보유자)</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">장기근속 포상</p>
                        <p class="sm_text">(1년차 - 선물세트, 3 / 5년차 - 단체여행<br>10 / 20년차 골드바 증정)</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title">리조트 회원권</p>
                        <p class="sm_text">(예정)</p>
                    </div>
                </li>
                <li>
                    <div class="text_area">
                        <p class="sm_title ssm">직원 무료 법률 상담</p>
                        <p class="sm_text">(예정)</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab_cont02 tab_cont" style="display:none">
        <?
        ######################################################################################################################################################
        //VIEW3 BOARD 1.0
        ######################################################################################################################################################
        if(!defined('_VIEW3BOARD_'))exit;
        ######################################################################################################################################################
        unset($_SESSION['data']);
        $total_data = mysql_num_rows(mysql_query("SELECT view3_idx FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1'"));
        $list_page = 10;
        $start = ($view3_page - 1) * $list_page;
        page($total_data, $list_page, 5, $path_next, "img", $view3_page, $end_page_path);
        ?>

        <!-- <div class="cont_top">
            <div class="inner">
                <h3 class="cont_tit">(주)전한 <em>모집공고</em></h3>
                <p class="cont_txt">주식회사 전한에서 인재를 기다립니다</p>
            </div>
        </div> -->

        <!-- recruit_ad_list start -->
        <div class="recruit_ad_list">
            <div class="inner">
        <?
        $ongoing_select_query = "SELECT view3_idx FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1' AND (view3_open = '0000-00-00 00:00:00' || view3_open <= NOW())";
        $ongoing_total_query = " AND (view3_close = '0000-00-00 00:00:00' OR view3_close >= NOW() - INTERVAL 1 DAY)";
        $ongoing_cond1_query = " AND view3_special_02 LIKE '%신입%'";
        $ongoing_cond2_query = " AND view3_special_02 LIKE '%경력%'";
        $ongoing_total1 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query));
        $ongoing_total2 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query.$ongoing_cond1_query));
        $ongoing_total3 = mysql_num_rows(mysql_query($ongoing_select_query.$ongoing_total_query.$ongoing_cond2_query));
        ?>
                <div class="ad_state t_center">
                    <p class="lyr_tit">진행중인 채용공고</p>
                    <ul class="fs_def">
                        <li>전체<span><?=$ongoing_total1?></span></li>
                        <li>신입<span><?=$ongoing_total2?></span></li>
                        <li>경력<span><?=$ongoing_total3?></span></li>
                    </ul>
                </div>
                <div class="ad_listing over_h">
                    <ul>
        <?
        $list_query = "SELECT * FROM `".TABLE_LEFT.$board."` WHERE view3_use = '1' AND (view3_open = '0000-00-00 00:00:00' OR view3_open <= NOW()) ORDER BY view3_write_day DESC";
        $result = mysql_query($list_query);
        while($list = mysql_fetch_assoc($result)) {
            $path_view = URL_PATH.'?'.view3_link('||idx||select||search','view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
            if($list['view3_check_01'] == 1) {
        		$status_text = '마감';
            } else if($list['view3_open'] == '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
        		$status_text = '상시';
        	} else if($list['view3_open'] != '0000-00-00 00:00:00' && $list['view3_close'] == '0000-00-00 00:00:00') {
        		$status_text = '채용시 마감';
        	} else if(time() >= strtotime($list['view3_close']) + 86400) {
        		$status_text = '마감';
        	} else {
                $write_day = new DateTime($list['view3_write_day']);
                $close_day = new DateTime($list['view3_close']);
                $today = new DateTime('NOW');
                $interval1 = date_diff($today, $close_day);
                $interval2 = date_diff($write_day, $today);
                if($interval1->days > 0) {
                    $status_text = 'D-'.($interval1->days);
                } else if($interval1->days == 0) {
                    $status_text = 'D-DAY';
                }
        	}
        ?>
                        <li>
                            <a href="<?=$path_view?>">
                                <p class="d_day"><?=$status_text?></p>
                                <p class="ad_comp">
                                    <span class="ellipsis">강강술래 <?=$list['view3_special_01']?></span><span class="type"><?=str_replace('||', '·', $list['view3_special_02'])?></span>
                                </p>
                                <p class="ad_title"><?=$list['view3_title_01']?><?if($interval2->days < 3){?><span class="new"><img src="<?=$skin_path?>/img/new_lbl.jpg" alt="NEW"></span><?}?></p>
                            </a>
                        </li>
        <?
        }
        ?>
                    </ul>
                </div>
                <!-- paging start -->
              	<div class="paging">
              		<?=$out_page?>
              	</div>
              	<!-- //paging end -->
            </div>
        </div>
        <!-- //recruit_ad_list end -->

    </div>
</div>
<script>
new Tabbing($('.tabmenu'), $('.tab_conts'));
</script>
