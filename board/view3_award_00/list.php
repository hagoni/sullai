<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>

<link rel="stylesheet" href="<?=BOARD?>/<?=$view3_skin?>/css/skin.css">
<!-- board wrapper start -->
<div id="boardWrap">
<?
if($total_data > 0) {
?>
    <div class="result">
        <!-- 소식지 start -->
        <div class="newspaper">
            <div class="np_list rel">
                <div class="swiper-container">
                    <ul class="swiper-wrapper">
<?
        $list_page = 12;
        $page_per_list = 10;
        $start = ($view3_page - 1) * $list_page;
        page($total_data, $list_page, $page_per_list, $path_next, "img", $view3_page, $end_page_path);
        $sql = $main_sql.$view_order;
        $out_sql = mysql_query($sql);
        $HTML_SUB = "";
        while($list = mysql_fetch_assoc($out_sql)) {
            $fileSaveList = explode('||',$list['view3_file']);
    		$img_size = getimagesize(ROOT_INC.'/upload/'.$board.$fileSaveList[3]);
    		$layer_x = $img_size[0];
    		$layer_y = $img_size[1];

            $list_img = '/upload/award_01'.$fileSaveList[3];

            $resize_small_key = uniqid();
            $_SESSION['img_code'][$resize_small_key] = $list_img;
            $resize_small_url = $root.'/freebest/img.php?width=100&height=300&code='.$resize_small_key;

            $resize_large_key = uniqid();
            $_SESSION['img_code'][$resize_large_key] = $list_img;
            $resize_large_url = $root.'/freebest/img.php?width=500&height=1000&code='.$resize_large_key;

            $HTML_SUB .= "<li class='swiper-slide'>";
            $HTML_SUB .= "<a href='#none' style='background-image:url({$resize_small_url})'></a>";
            $HTML_SUB .= "</li>";
?>
                        <li class="swiper-slide">
                            <a href="#none" style="background-image:url('<?=$resize_large_url;?>')" data-image="<?=$root?>/upload/award_01<?=$fileSaveList[3]?>" data-width="<?=$layer_x?>" data-height="<?=$layer_y?>"></a>
                            <div class="text_area">
                                <!-- <p class="vol">VOL.43</p> -->
                                <p class="np_ttl ellipsis"><?=nl2br($list['view3_title_01'])?></p>
                            </div>
                        </li>
<?
    }
?>
                    </ul>
                </div>
                <button type="button" class="np_btns np_prev">이전</button>
                <button type="button" class="np_btns np_next">다음</button>
            </div>
            <div class="np_paging rel">
                <div class="swiper-container">
                    <ul class="swiper-wrapper">
                        <?=$HTML_SUB?>
                    </ul>
                </div>
                <button type="button" class="pg_btns pg_prev">이전</button>
                <button type="button" class="pg_btns pg_next">다음</button>
            </div>
        </div>
        <!-- //소식지 end -->
    </div>
<?
} else {
	echo '<p class="nodata">게시물이 없습니다.</p>'.PHP_EOL;
}
?>

<script type="text/javascript">
(function($) {
    doc.ready(function() {
		(function() {
			function modalOpen() {
				if(changing === false) {
					body.append('<div id="blockBg" style="position:fixed;left:0;top:0;z-index:190;width:100%;height:100%;background:#000"></div>');
	                blockBg = $('#blockBg');
	                blockBg.css('opacity', 0.4);
					body.append(modalHtml);
	                container = $(containerId);
					container.css({width: $(this).data('width'), height: $(this).data('height'), marginLeft: -($(this).data('width') / 2)});
					fixModalCss();
					container.css({display: 'block', opacity: 0, position: modalPosition, top: modalTop + 50});
					$('.modalConImg').attr('src', $(this).attr('data-image'));
					container.animate({opacity: 1, top: modalTop}, 500, function() {
	                    blockBg.click(modalX);
	                    win.resize(resize);
	                    changing = false;
						open = true;
	                });
					changing = true;
				}
			}

			function modalX() {
				container.animate({opacity: 0, top: modalTop - 50}, 200, function() {
					blockBg.unbind('click', modalX);
	                win.unbind('resize', resize);
					container.remove();
					blockBg.remove();
					open = false;
				});
			}

			function fixModalCss() {
				if(typeof containerH === 'undefined') containerH = parseFloat(container.css('height'), 10);
				if(win.innerHeight() > containerH) {
	                modalPosition = 'fixed';
					modalTop = (win.innerHeight() / 2) - (containerH / 2);
				} else {
	                modalPosition = 'absolute';
					modalTop = win.scrollTop() + 100;
				}
			}

			function resize() {
				clearTimeout(resizeTimer);
				if(typeof container === 'object') {
					resizeTimer = setTimeout(function() {
						fixModalCss();
						container.css({position: modalPosition, top: modalTop});
					}, 100);
				}
			};

			var body = $('body'),
	            containerId = '#patentModalContainer',
	            containerH,
	            container,
	            anchor = '.np_list a',
	            xBtnId = '#patentModalX',
	            spinId = '#snsSpinner',
	            modalHtml = '',
	            modalPosition,
	            modalTop,
	            blockBg,
	            resizeTimer = null,
	            changing = false,
				open = false;

			modalHtml += '<div id="patentModalContainer" class="patent_pop_con" style="display:none">\n';
            modalHtml += '  <div class="close_div"><a href="#none" id="patentModalX" class="pop_close">닫기</a></div>\n';
			modalHtml += '	<img class="modalConImg" class="w100" />\n';
            modalHtml += '</div>';

			body.on('click', anchor, modalOpen);
			body.on('click', xBtnId, modalX);
		}());
	});

    var npSwiper = new Swiper('.np_list .swiper-container', {
        slidesPerView: 'auto',
        centeredSlides: true,
        // autoplay: {
        //     delay: 3000,
        // },
        navigation: {
            nextEl: '.np_btns.np_next',
            prevEl: '.np_btns.np_prev',
        },
        // breakpoints: {
        //     767: {
        //       spaceBetween: 30
        //     },
        // }
    });
    var pgSwiper = new Swiper('.np_paging .swiper-container', {
        slidesPerView: 'auto',
        speed: 500,
        spaceBetween: 15,
        freeMode: true,
        // autoplay: {
        //     delay: 3000,
        // },
        navigation: {
            nextEl: '.pg_btns.pg_next',
            prevEl: '.pg_btns.pg_prev',
        },
        slideToClickedSlide: true,
        breakpoints: {
            767: {
              spaceBetween: 5
            },
        }
    });

    npSwiper.controller.control = pgSwiper;
    pgSwiper.controller.control = npSwiper;
}(jQuery));
</script>

</div>
<!-- //board wrapper end -->
