<?
include_once "list_high.php";
?>
<div class="view_conts">
    <!-- menu start -->
    <div class="view_cont01 view_cont menu" style="display:<?if ($view_tab != 1) {echo 'none';}?>">
        <p class="view_title">메뉴소개</p>
        <ul class="menu_tab fs_def t_center">
                <!-- <li class="on"><a href="#none">전체메뉴</a></li> -->
        <?
        $menu_cate_sql = "select * from ".TABLE_LEFT."board where view3_group_admin_idx = 17 and view3_use = 1 order by view3_order_admin";
        $menu_cate_res = mysql_query($menu_cate_sql);
        $menu_cate_num = mysql_num_rows($menu_cate_res);
        $cnt = 0;
        while ($menu_cate_lst = mysql_fetch_assoc($menu_cate_res)) {
            $tab_sql = "select * from ".TABLE_LEFT."menu_map_01 where view3_use = 1 and view3_sca = {$menu_cate_lst['view3_sca']} and view3_map_idx = {$store_idx}";
            $tab_res = mysql_query($tab_sql);
            $tab_num = mysql_num_rows($tab_res);
            if ($tab_num) {
                ${'$menu_cate_'.$cnt} = $menu_cate_lst['view3_sca'];
                if ($cnt == 0) {
                    $class = "class='on'";
                } else {
                    $class = "";
                }
                ?>
                    <li <?=$class?>><a href="#none"><?=$menu_cate_lst['view3_title_01']?></a></li>
                <?
                $cnt++;
            }
        }
        ?>
        </ul>
        <div class="menu_conts">
            <!-- <div class="menu_cont00 menu_cont">
                <ul class="menu_list fs_def">
                <?
                $menu_sql = "select * from ".TABLE_LEFT."menu_01 where view3_use = 1 order by view3_order desc, view3_write_day desc";
                $menu_res = mysql_query($menu_sql);
                $menu_i = 0;
                while ($menu_lst = mysql_fetch_assoc($menu_res)) {
                    $menu_img = explode("||",$menu_lst['view3_file']);
                ?>
                    <li>
                        <a href="#" class="bindMenuModalOpen" data-i="<?=$menu_i?>" data-sca="<?=$menu_lst['view3_sca'];?>" data-idx="<?=$menu_lst['view3_map_idx'];?>" data-is="<?=$menu_lst['view3_idx']?>">
                            <div class="img_area" style="background-image:url('<?=$root?>/upload/menu_01<?=$menu_img[2]?>')"></div>
                            <div class="text_area">
                                <p class="menu_ko"><?=$menu_lst['view3_title_01']?></p>
                                <p class="menu_en"><?=$menu_lst['view3_title_02']?></p>
                            </div>
                        </a>
                    </li>
                <?
                }
                ?>
                </ul>
            </div> -->
        <?
        $menu_tab_sql = "select * from ".TABLE_LEFT."board where view3_group_admin_idx = 17 and view3_use = 1 order by view3_order_admin";
        $menu_tab_res = mysql_query($menu_tab_sql);
        $menu_tab_num = mysql_num_rows($menu_tab_res);
        $tab_cnt = 0;
        while ($menu_tab_lst = mysql_fetch_assoc($menu_tab_res)) {
            if ($tab_cnt != 0) {
                $tab_style = "style='display:none'";
            } else {
                $tab_style = "";
            }
            // $tab_style = "style='display:none'";
            $mn_sql = "select * from ".TABLE_LEFT."menu_map_01 where view3_use = 1 and view3_map_idx = {$store_idx} and view3_sca = {$menu_tab_lst['view3_sca']} order by view3_order desc, view3_write_day desc";
            $mn_res = mysql_query($mn_sql);
            $mn_cnt = mysql_num_rows($mn_res);
            if ($mn_cnt) {
                ?>
                <div class="menu_cont0<?=($tab_cnt+1)?> menu_cont" <?=$tab_style?>>
                    <ul class="menu_list fs_def">
                <?
                while ($mn_lst = mysql_fetch_assoc($mn_res)) {
                    $menu_idx = implode(",",array_values(array_diff(explode("||",$mn_lst['view3_special_01']), array(''))));
                    $menu_sql = "select * from ".TABLE_LEFT."menu_01 where view3_idx in ({$menu_idx}) order by view3_order desc, view3_write_day desc";
                    $menu_res = mysql_query($menu_sql);
                    $menu_i = 0;
                    while ($menu_lst = mysql_fetch_assoc($menu_res)) {
                        $menu_img = explode("||",$menu_lst['view3_file']);
                    ?>
                        <li>
                            <a href="#" class="bindMenuModalOpen" data-i="<?=$menu_i?>" data-sca="<?=$menu_lst['view3_sca'];?>" data-idx="<?=$menu_lst['view3_map_idx'];?>" data-is="<?=$menu_idx?>">
                                <div class="img_area" style="background-image:url('<?=$root?>/upload/menu_01<?=$menu_img[2]?>')"></div>
                                <div class="text_area">
                                    <p class="menu_ko"><?=$menu_lst['view3_title_01']?></p>
                                    <p class="menu_en"><?=$menu_lst['view3_title_02']?></p>
                                </div>
                            </a>
                        </li>
                    <?
                    $menu_i++;
                    }
                $tab_cnt++;
                }
                ?>
                    </ul>
                </div>
                <?
            }
        }
        ?>
        </div>
    </div>
    <!-- //menu end -->
</div>
<script src="<?=BOARD?>/view3_map_00/js/ContentsModal.js?<?=$time?>"></script>
<?
include_once "list_bottom.php";
?>


<script type="text/javascript">
(function($) {

	'use strict';

	window.MenuModal = function() {

		var _this = this,
			body = $('body'),
			container,
			blockBg,
            initTop,
            slider,
			open = false;

		this.initialize = function() {
			body.on('click', '.bindMenuModalOpen', function(e) {
				if(open === false) {
					_this.modalOpen($(this).data('sca'), $(this).data('i')+0, $(this).data('idx'), $(this).data("is"));//closest('li').index(); <-몇번인지 모름
					open = true;
				}
				e.preventDefault();
			});
			body.on('click', '.menu_pop_close', this.modalX);
		};

		this.modalOpen = function(sca, i, idx, is) {
			var requestUrl = '<?=$skin_path?>/resource/menu.php';
			$.post(requestUrl, {sca: sca, idx: idx, mn_idx:is}, function(response) {
                if($('#menuModalPopup').length === 0) {
                    body.append(response);
                    container = $('#menuModalPopup');
                    initTop = parseFloat(container.css('margin-top'), 10);
                    container.css({display: 'block', opacity: 0, marginTop: initTop + 100});
					slider = new CommonSlider(container.children('.slider-container'), {
						startIndex: i,
						prevBtn: container.children('.slider-prev'),
						nextBtn: container.children('.slider-next'),
					});
                    container.animate({opacity: 1, marginTop: initTop}, 800);
                } else {
                    slider.toIdx(i);
                }
			});
		};

		this.modalX = function(e) {
			container.animate({opacity: 0, marginTop: initTop - 100}, 300, function() {
				if(typeof slider.kill === 'function') slider.kill();
				$(this).remove();
				open = false;
			});
			e.preventDefault();
		};

		this.initialize();
	};

}(jQuery));
(function(){
    new MenuModal();
}(jQuery));
</script>
