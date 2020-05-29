<?
function checkMobile() {
    if(preg_match('/Android|BlackBerry|Blazer|Bolt|Doris|Dorothy|Fennec|GoBrowser|IEMobile|iPhone|iPod|Iris|Maemo|MIB|Minimo|NetFront|Opera Mini|Opera Mobi|SEMC-Browser|Skyfire|SymbianOS|TeaShark|Teleca|uZardWeb/', $_SERVER['HTTP_USER_AGENT']) > 0)  {
        return true;
    }
}
@session_start();
$_SESSION['mobile'] = strpos($_SERVER['QUERY_STRING'], 'mobile') > -1 ? true : false;
$mobile_device = 'false';
if(checkMobile() == true && $_SESSION['mobile'] != true) {
	$mobile_device = 'true';
}
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
######################################################################################################################################################
$store_idx = $_REQUEST['store'];
$sql = "select * from ".TABLE_LEFT."map_01 where view3_use = 1 and view3_idx = {$store_idx}";
$out_sql = mysql_query($sql);
$list = mysql_fetch_assoc($out_sql);
view3_hit($view3_table, $list['view3_idx']);
######################################################################################################################################################
// 이전글 다음글
######################################################################################################################################################
$sort = view3_prev_next($view3_table,$view3_idx);
$path_prev = view3_link("||idx","view&idx=".$temp_prev,"",$end_path);
$path_next = view3_link("||idx","view&idx=".$temp_next,"",$end_path);
######################################################################################################################################################
$_SESSION['idx'] = $view3_idx;
$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
$next_command_01 = view3_html($list['view3_command_01']);
if($list['view3_addr_road']) {
	$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
} else {
	$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
}
$view_img_array = explode('||', $list['view3_file']);
$view_img = array();
for($i=0; $i<count($view_img_array); $i++) {
	if($i < 3 || $view_img_array[$i] == '') continue;
	$view_img[] = $pc.'/upload/'.$board.$view_img_array[$i];
}
$list_img = explode("||",$list['view3_file']);
$view_tab = (int)$_REQUEST['view_tab'];
if ($view_tab < 1) {
	$view_tab = 1;
}

if($_SESSION['store_view_idx'] === $store_idx){
?>
<script>
SKIP_SUB_INTRO = true;//<?=$view_tab;?>
</script>
<?
}
$_SESSION['store_view_idx'] = $store_idx;
?>
<!-- board wrapper start -->
<div id="boardWrap">
	<!-- 뷰페이지 start -->
	<div class="store_view">
		<div class="view_banner rel t_center">
			<div class="bg_slide">
				<div class="swiper-container h100">
					<ul class="swiper-wrapper h100">
						<?
							if ($list_img[3] == "") {
							?>
								<li class="swiper-slide" style="background-image:url('../img/page/store/view_banner.jpg')"></li>
							<?
							} else {
								for ($i=3; $i < count($list_img); $i++) {
								?>
								<li class="swiper-slide" style="background-image:url('<?=$root?>/upload/map_01<?=$list_img[$i]?>')"></li>
								<?
							}
						}?>
					</ul>
				</div>
			</div>
			<div class="v_mid">
				<p class="store_name_en"><?=$list['view3_title_02']?></p>
				<p class="store_name"><span><?=$list['view3_title_01']?></span></p>
				<!-- <p class="store_stext">연 <?=number_format($list['view3_check_04'])?>명의 고객님이 방문해주셨습니다.</p> -->
				<div class="store_text">
					<?=htmlspecialchars_decode($list['view3_command_01'])?>
				</div>
				<ul class="store_info fs_def">

					<li>
                        <?
                        // if ($list['view3_check_01'] == 0) {
                        //     echo "좌석 : {$list['view3_special_11']}";
                        // } else {
                        //     echo "좌석 : {$list['view3_check_01']}석";
                        // }
                        echo "좌석 : {$list['view3_special_11']}";
                        ?>

                    </li>
					<li>영업시간 : <?=$list['view3_special_02']?></li>
					<li>
						<?=$list['view3_special_05'] == 'on' ? '주차 가능' : '주차 불가능'?>
					</li>
				</ul>
                <a href="<?=BOARD?>/index.php?board=map_01" class="other_store arr t_left">다른 매장</a>
			</div>
			<button type="button" class="view_btns view_prev">이전</button>
			<button type="button" class="view_btns view_next">다음</button>
			<ul class="bg_paging fs_def">
				<!-- <li class="swiper-pagination-bullet-active"><a href="#none"></a></li>
				<li><a href="#none"></a></li>
				<li><a href="#none"></a></li> -->
			</ul>
			<!-- <a href="<?=BOARD?>/index.php?board=map_01" class="list_link">다른 지점 보기</a> -->
			<!-- <div class="pop_wrap" id="popWrap">
				<a href="#none" class="pop_cont">강강술래 새해복권</a>
				<a href="#none" class="pop_close">팝업 닫기</a>
			</div> -->
			<div class="scroll_wrap">
				<span class="scroll_line"></span>
			</div>
		</div>
        <div class="ctgr_wrap_pc ctgr_wrap t_center">
			<ul class="ctgr ctgr_tab fs_def">
				<li>
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=1&store=".$store_idx."&type=list_menu")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">메뉴소개</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li>
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=2&store=".$store_idx."&type=list_mem")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">강강술래의 자부심</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li>
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=3&store=".$store_idx."&type=list_path")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">오시는 길</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li>
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=4&store=".$store_idx."&type=list_event")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">매장이벤트</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li>
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=5&store=".$store_idx."&type=list_cus")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">고객의 소리</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<?if ($list['view3_link'] != "") {?>
					<li>
						<a href="<?=$list['view3_link']?>" target="_blank">
							<div class="circ_area"></div>
							<p class="circ_text"><span class="span_text">카카오톡 채널</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
						</a>
					</li>
				<?}?>

			</ul>
		</div>
        <div class="ctgr_wrap ctgr_wrap_m t_center swiper-container">
            <ul class="ctgr ctgr_tab no_swipe fs_def">
                <li>
                    <a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=1&store=".$store_idx."&type=list_menu")?>">
                        <div class="circ_area"></div>
                        <p class="circ_text"><span class="span_text">메뉴소개</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
                    </a>
                </li>
                <li>
                    <a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=2&store=".$store_idx."&type=list_mem")?>">
                        <div class="circ_area"></div>
                        <p class="circ_text"><span class="span_text">강강술래의 자부심</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
                    </a>
                </li>
                <li>
                    <a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=3&store=".$store_idx."&type=list_path")?>">
                        <div class="circ_area"></div>
                        <p class="circ_text"><span class="span_text">오시는 길</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
                    </a>
                </li>
                <li>
                    <a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=4&store=".$store_idx."&type=list_event")?>">
                        <div class="circ_area"></div>
                        <p class="circ_text"><span class="span_text">매장이벤트</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
                    </a>
                </li>
                <li>
                    <a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=5&store=".$store_idx."&type=list_cus")?>">
                        <div class="circ_area"></div>
                        <p class="circ_text"><span class="span_text">고객의 소리</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
                    </a>
                </li>
                <?if ($list['view3_link'] != "") {?>
                    <li>
                        <a href="<?=$list['view3_link']?>" target="_blank">
                            <div class="circ_area"></div>
                            <p class="circ_text"><span class="span_text">카카오톡 채널</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
                        </a>
                    </li>
                <?}?>

            </ul>
			<ul class="ctgr ctgr_tab swipe fs_def swiper-wrapper">
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=1&store=".$store_idx."&type=list_menu")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">메뉴소개</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=2&store=".$store_idx."&type=list_mem")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">강강술래의 자부심</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=3&store=".$store_idx."&type=list_path")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">오시는 길</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=4&store=".$store_idx."&type=list_event")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">매장이벤트</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=5&store=".$store_idx."&type=list_cus")?>">
						<div class="circ_area"></div>
						<p class="circ_text"><span class="span_text">고객의 소리</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
					</a>
				</li>
				<?if ($list['view3_link'] != "") {?>
					<li class="swiper-slide">
						<a href="<?=$list['view3_link']?>" target="_blank">
							<div class="circ_area"></div>
							<p class="circ_text"><span class="span_text">카카오톡 채널</span><span class="circ_arr"><img src="<?=$root?>/img/page/store/view_arr.png" alt="" class="w100"></span></p>
						</a>
					</li>
				<?}?>

			</ul>
		</div>
        <!-- <div class="ctgr_wrap_m ctgr_wrap swiper-container">
			<ul class="swiper-wrapper">
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=1&store=".$store_idx."&type=list_menu")?>">
						메뉴소개
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=2&store=".$store_idx."&type=list_mem")?>">
						강강술래의 자부심
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=3&store=".$store_idx."&type=list_path")?>">
						오시는 길
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=4&store=".$store_idx."&type=list_event")?>">
						매장이벤트
					</a>
				</li>
				<li class="swiper-slide">
					<a href="<?=URL_PATH?>?<?=get("page||type||view_tab||idx","view_tab=5&store=".$store_idx."&type=list_cus")?>">
						고객의 소리
					</a>
				</li>
				<?if ($list['view3_link'] != "") {?>
					<li class="swiper-slide">
						<a href="<?=$list['view3_link']?>" target="_blank">
							카카오톡 채널
						</a>
					</li>
				<?}?>

			</ul>
		</div> -->
<script>
(function($) {
    doc.ready(function() {
        var ctgrSwiper = new Swiper('.ctgr_wrap_m.swiper-container', {
            init: true,
            slidesPerView: 'auto',
            // autoplay: false,
            observer: true,
            observeParents: true,
            breakpoints: {
                2560: {
                    allowTouchMove: false,
                },
                650: {
                    allowTouchMove: true,
                },
            }
        });
    });
}(jQuery));
	TweenMax.to($('.scroll_line'), 1.5, {y: 120, repeat: -1});
    function scrollHandler() {
        var scrollTop = win.scrollTop();
        if(fixed === false && scrollTop >= offset) {
            $topElement.removeClass('scroll');
			var calc_a = parseInt($topElement.height(), 10);
            $topElement.addClass('scroll');
			var calc_b = parseInt($topElement.height(), 10);
			$('.view_cont').css('padding-top', calc_a+calc_b-76);
            fixed = true;
        } else if(fixed === true && scrollTop < offset) {
            $topElement.removeClass('scroll');
			$('.view_cont').css('padding-top',0);
            fixed = false;
        }
    }
    function scrollHandler() {
        var scrollTop = win.scrollTop();
        if(fixed === false && scrollTop >= offset) {
            $topElement2.removeClass('scroll');
			var calc_a = parseInt($topElement2.height(), 10);
            $topElement2.addClass('scroll');
			var calc_b = parseInt($topElement2.height(), 10);
			$('.view_cont').css('padding-top', calc_a+calc_b-76);
            fixed = true;
        } else if(fixed === true && scrollTop < offset) {
            $topElement2.removeClass('scroll');
			$('.view_cont').css('padding-top',0);
            fixed = false;
        }
    }

    var $topElement = $('.ctgr_wrap_pc'),
        offset = $('.ctgr_wrap_pc').offset().top,
        fixed = false;
    var $topElement2 = $('.ctgr_wrap_m'),
        offset = $('.ctgr_wrap_m').offset().top,
        fixed = false;
	win.off('scroll.scrollHandler_a');
	win.off('scroll.scrollHandler_b');
	win.off('scroll.scrollHandler_c');
    win.scroll(scrollHandler);
	scrollHandler();
	$(window).load(function(){
		if(typeof SKIP_SUB_INTRO !== 'undefined' && SKIP_SUB_INTRO){
			// $('html, body').scrollTop($('.view_cont').offset().top+1);
			// $('html, body').scrollTop(0);
			$('html, body').scrollTop($('.ctgr_wrap').offset().top);
		}
	});


</script>
