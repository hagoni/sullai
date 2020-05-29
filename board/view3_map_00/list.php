<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
$view3_tab = $_REQUEST['list_tab'];
if (!$view3_tab) {
	$view3_tab = 1;
}


$_SESSION['store_view_idx'] = 0;
?>

<!-- board wrapper start -->
<div id="boardWrap" class="list">
	<div class="banner bg geo_bg">
		<p class="page_title t_center geo_tlt"><em>매장찾기</em></p>
		<p class="page_text t_center geo_con">한결같은 마음으로 고객님과의 만남을 준비합니다. <br>맛과 멋이 있는 강강술래에서 만나세요 </p>
		<div class="btns_wrap fs_def t_center geo_link">
			<a href="#none" class="view_more arr t_left" style="display:none;margin:0 auto;">자세히 보기</a>
			<!-- <select name="" class="other_store arr t_left">
				<option value="">다른매장</option>
				<?
				$map_sql = "select * from ".TABLE_LEFT."map_01 where view3_use = 1 and view3_check_11 != 1 order by view3_order desc, view3_write_day desc";
				$map_res = mysql_query($map_sql);
				while ($map_lst = mysql_fetch_assoc($map_res)) {
				?>
					<option value="<?=$map_lst['view3_idx']?>"><?=$map_lst['view3_title_01']?></option>
				<?
				}
				?>
			</select> -->
		</div>
	</div>
	<ul class="store_tab fs_def t_center">
		<li class="<?if ($view3_tab == "" || $view3_tab == 1) {echo 'on';}?>"><a href="<?=URL_PATH?>?<?=get("page||type||list_tab||idx","list_tab=1");?>">국내매장</a></li>
		<li class="<?if ($view3_tab == 2) {echo 'on';}?>"><a href="<?=URL_PATH?>?<?=get("page||type||list_tab||idx","list_tab=2");?>">해외매장</a></li>
	</ul>
<?
if($total_data > 0) {
?>
<div class="store_conts">
	<div class="store_cont0<?=$view3_tab?> store_cont">
		<ul class="store_list fs_def">
<?
    $list_page = 8;
    $page_per_list = 10;
    $start = ($view3_page - 1) * $list_page;
	page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);

    // $sql = $main_sql.$view_order." limit ".$start.", ".$list_page;
	$sql = $main_sql.$view_order;
    $out_sql = mysql_query($sql);
	$num = mysql_num_rows($out_sql);

    while($list = mysql_fetch_assoc($out_sql)) {
		$list_img = explode("||",$list['view3_file']);
		if ($list_img[2] == "") {
			$img = $root."/img/page/store/store_img2.jpg";
	    } else {
	        $img = $root."/upload/map_01".$list_img[2];
	    }
        $option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','list_menu&select='.$view3_select.'&search='.$view3_search.'&store='.$list['view3_idx']);
        if($list['view3_addr_road']) {
    		$addr = $list['view3_addr_road']." ".$list['view3_addr_detail'];
    	} else {
    		$addr = $list['view3_addr_number']." ".$list['view3_addr_detail'];
    	}
?>

			<li>
				<p class="store_name">강강술래 <?=$list['view3_title_01']?></p>
				<div class="box">
					<?if ($list['view3_check_11'] == 1) {$path_view = "#none";}?>
					<div class="img_area"><a href="<?=$path_view?>" style="background-image:url(<?=$img?>)"></a></div>
					<div class="text_area">
						<ul class="store_info t_center">
							<?if ($list['view3_check_11'] != 1) {?>
								<li><span>영업시간.</span><?=$list['view3_special_02']?></li>
								<?if ($list['view3_special_04'] != "") {?>
								<li><span>전화번호.</span><?=$list['view3_special_04'];?></li>
								<?}?>
							<?}?>
							<li><span>주소.</span><?=$addr?></li>
						</ul>
						<?if ($list['view3_check_11'] != 1) {?>
							<a href="<?=$path_view?>" class="view_more">자세히 보기</a>
						<?}?>
					</div>
				</div>
			</li>
<?
    }
?>

		</ul>
	</div>
	<!-- store banner start -->
</div>
	<!-- //store banner end -->


    <!-- paging start -->
	<!-- <div class="paging fs_def">
		<?=$out_page?>
	</div> -->
	<!-- //paging end -->

<script type="text/javascript">
(function($) {
	$(document).ready(function() {
		var drawBorder = $('.drawborder_wrap');
		var tl = [];
		for(var i=0, tempEl; i<drawBorder.length; i++) {
			tempEl = drawBorder.eq(i).children('.drawborder');
			drawBorder.eq(i).data('index', i);
			tl[i] = new TimelineLite({paused: true});
			tl[i]
			.to(tempEl.eq(0), 0.2, {width: '100%'})
			.to(tempEl.eq(1), 0.15, {height: '100%'})
			.to(tempEl.eq(2), 0.2, {width: '100%'})
			.to(tempEl.eq(3), 0.15, {height: '100%'});
			drawBorder.eq(i).closest('li').mouseenter(function() {
				tl[$(this).find('.drawborder_wrap').data('index')].play();
				if($(this).find('.paging_thumb').length > 0) {
					TweenLite.to($(this).find('.store_img img'), 1.0, {scale: 1.1});
				}
			}).mouseleave(function() {
				tl[$(this).find('.drawborder_wrap').data('index')].reverse();
				if($(this).find('.paging_thumb').length > 0) {
					TweenLite.to($(this).find('.store_img img'), 1.0, {scale: 1});
				}
			});
		}

		$('.other_store').change(function(){
			location.href = '<?=BOARD?>/index.php?board=map_01&type=list_menu&store='+$(this).val();
		});
	});
}(jQuery));
</script>

<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

</div>
<!-- //board wrapper end -->

<?
@include_once(ROOT_INC.'/inc/geolocation.php');
?>
