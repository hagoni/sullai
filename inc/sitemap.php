
<!-- sitemap start -->
<div id="sitemapWrap" class="sitemap_wrap" style="display:none">
	<div class="sitemap">
		<h2 class="stm_bi"><img src="<?=$root?>/img/common/bi_20200213.png" alt="강강술래" class="w100"></h2>
        <div class="stm_btns fs_def">
            <a href="#none" class="login"><span class="ico"><img src="<?=$root?>/img/common/stm_ico1.png" alt=""></span><span class="ico_text">로그인하기</span></a>
            <a href="http://www.sullaimall.com/" target="_blank"><span class="ico2 ico"><img src="<?=$root?>/img/common/stm_ico2_20200213.png" alt=""></span><span class="ico_text">쇼핑몰 바로가기</span></a>
        </div>
		<ul class="stm_depth1_ul">
			<li class="add_li"><a href="<?=BOARD?>/index.php?board=map_01" class="add_a">매장</a></li>
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
			<li class="stm_depth1_li<?=$depth1_list['view3_order_css']?> stm_depth1_li<?if($depth1_list['view3_order_css'] == $gnb_index){echo ' on';}?>">
				<a href="#none" class="stm_depth1_a"><?=html_entity_decode($depth1_list['view3_title_02'])?></a>
				<ul class="stm_depth2_ul"<?if($depth1_list['view3_order_css'] == $gnb_index){echo ' style="display:block"';}?>>
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
					<li class="stm_depth2_li<?if($depth1_list['view3_order_css'] == $gnb_index && $depth2_list['view3_order_css'] == $minor_index){echo ' on';}?>">
						<a href="<?=$depth2_link?>" class="stm_depth2_a"><?=html_entity_decode($depth2_list['view3_title_01'])?></a>
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
        <a href="#none" class="bindSitemapFold stm_close">닫기</a>
	</div>
</div>
<!-- sitemap start -->
