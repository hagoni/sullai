    <div class="footer_wrap rel">

        <div class="ft_stm">
            <ul class="ft_stm_depth1_ul fs_def t_center">
                <?
                $depth1_link_query = "SELECT * FROM `".TABLE_LEFT."group` WHERE view3_use = '1' AND view3_setup = '$html_idx' ORDER BY view3_order";
                $depth1_result = @mysql_query($depth1_link_query);
                while($depth1_list = @mysql_fetch_assoc($depth1_result)) {
                    $depth2_link_query = "SELECT * FROM `".TABLE_LEFT."board` WHERE view3_use = '1' AND view3_setup = '$html_idx' AND view3_group_idx = '".$depth1_list['view3_idx']."' ORDER BY view3_order";
                    $depth2_result = @mysql_query($depth2_link_query);
                    unset($depth1_link);
                    while($depth2_list = mysql_fetch_assoc($depth2_result)) {
                        switch($depth2_list['view3_style']) {
                            case 'html':
                            if(file_exists(ROOT_INC.'/html/'.$depth2_list['view3_link'])) {
                                $depth1_link = $root.'/html/'.$depth2_list['view3_link'];
                            }
                            break;
                            case 'board':
                            $depth1_link = BOARD.'/index.php?board='.$depth2_list['view3_link'];
                            break;
                            case 'http':
                            $depth1_link = $depth2_list['view3_link'].'" target="_blank';
                            break;
                            case 'url':
                            $depth1_link = $depth2_list['view3_link'];
                            break;
                            default:
                            if(file_exists(ROOT_INC.'/html/'.$depth2_list['view3_link'])) {
                                $depth1_link = $root.'/html/'.$depth2_list['view3_link'];
                            }
                        }
                        if($depth1_link) {
                            if($depth2_list['view3_sca']) {
                                if(strpos($depth1_link, '?') > -1) $depth1_link .= '&amp;sca='.$depth2_list['view3_sca'];
                                else $depth1_link .= '?sca='.$depth2_list['view3_sca'];
                            }
                            break;
                        }
                    }
                    ?>
                    <li class="ft_stm_depth1_li<?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
                        <a href="<?=$depth1_link?>" class="ft_stm_depth1_a"><?=html_entity_decode($depth1_list['view3_title_02'])?></a>
                        <ul class="ft_stm_depth2_ul">
                            <?
                            $depth2_result = @mysql_query($depth2_link_query);
                            $depth2_i = 1;
                            while($depth2_list = @mysql_fetch_assoc($depth2_result)) {
                                switch($depth2_list['view3_style']) {
                                    case 'html':
                                    $depth2_link = $root.'/html/'.$depth2_list['view3_link'];
                                    break;
                                    case 'board':
                                    $depth2_link = BOARD.'/index.php?board='.$depth2_list['view3_link'];
                                    break;
                                    case 'http':
                                    $depth2_link = $depth2_list['view3_link'].'" target="_blank';
                                    break;
                                    case 'url':
                                    $depth2_link = $depth2_list['view3_link'];
                                    break;
                                    default:
                                    $depth2_link = $root.'/html/'.$depth2_list['view3_link'];
                                }
                                if($depth2_list['view3_sca']) {
                                    if(strpos($depth2_link, '?') > -1) $depth2_link .= '&amp;sca='.$depth2_list['view3_sca'];
                                    else $depth2_link .= '?sca='.$depth2_list['view3_sca'];
                                }
                                $depth2_link .= '#'.$depth2_i;
                                ?>
                                <li class="ft_stm_depth2_li<?if($depth1_list['view3_order_css'] == $gnb_index && $depth2_list['view3_order_css'] == $minor_index){echo ' on';}?>">
                                    <a href="<?=$depth2_link?>" class="ft_stm_depth2_a"><?=html_entity_decode($depth2_list['view3_title_01'])?></a>
                                </li>
                                <?
                                $depth2_i++;
                            }
                            ?>
                        </ul>
                    </li>
                    <?
                }
                ?>
            </ul>
        </div>
        <a href="#" class="btn_top">맨 위로</a>
        <footer class="footer t_center">
            <ul class="policy fs_def">
                <li><a href="#none" class="bindPolicyModalOpen" data-type="0">개인정보 취급</a></li>
                <li><a href="#none" class="bindPolicyModalOpen" data-type="1">이메일 무단 수집거부</a></li>
            </ul>
            <address>
                (주) 전한&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;사업자등록번호 : 210-81-49502&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br class="br_m768">서울특별시 강남구 논현로  325, 2층 (역삼동)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br class="br_m1080">팩스 : 02-3392-5424&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;문의 : 02-3392-5425<br>COPYRIGHT 2020 JUNHAN CO. LTD. ALL RIGHTS RESERVED.
            </address>
        </footer>

        <div class="quick_btns">
            <ul>
                <li class="btn2">
                    <a href="<?=$root?>/html/member_2.html">
                        <div class="ico_area"></div>
                        <p class="btn_text">멤버십 조회</p>
                    </a>
                </li>
                <li class="btn5">
                    <a href="<?=BOARD?>/index.php?board=inquiry_01&sca=customer_01">
                        <div class="ico_area"></div>
                        <p class="btn_text">고객의 소리</p>
                    </a>
                </li>
                <li class="btn3">
                    <a href="<?=$root?>/board/index.php?board=event_01">
                        <div class="ico_area"></div>
                        <p class="btn_text">이벤트</p>
                    </a>
                </li>
                <li class="btn4">
                    <a href="https://www.facebook.com/sullai" target="_blank">
                        <div class="ico_area"></div>
                        <p class="btn_text">공식 페이스북</p>
                    </a>
                </li>
                <li class="btn1">
                    <a href="http://www.sullaimall.com/" target="_blank">
                        <div class="ico_area"></div>
                        <p class="btn_text">쇼핑몰 바로가기</p>
                    </a>
                </li>
            </ul>
        </div>

    </div>

<?
$log_sql = "select * from ".TABLE_LEFT."login_01 where view3_use = 1 order by view3_order desc, view3_write_day desc limit 1";
$log_res = mysql_query($log_sql);
$log_lst = mysql_fetch_assoc($log_res);
$log_img = explode("||",$log_lst['view3_file']);
?>
<div class="login_popup">
    <div class="login_bg"></div>
    <div class="login_cont">
        <img src="<?=$root?>/img/common/pop_close.png" class="close" alt="">
        <img src="<?=$root?>/upload/login_01<?=$log_img[2]?>" class="cont_img" alt="">
    </div>
</div>
