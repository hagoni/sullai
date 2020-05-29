<? include_once "list_high.php"?>
		<div class="view_conts">
			<!-- event start -->
			<div class="view_cont04 view_cont event" style="display:<?if ($view_tab != 4) {echo 'none';}?>">
				<p class="view_title">매장 이벤트</p>

			        <div class="event_cont">
			        <!-- board list start -->
			            <ul class="board_list fs_def">
			<?

				$chk_sql = "select * from ".TABLE_LEFT."event_01 where view3_use = 1 order by view3_close desc, view3_order desc, view3_write_day desc";
				$chk_res = mysql_query($chk_sql);
				$chk_arr = array();
				while ($chk_lst = mysql_fetch_assoc($chk_res)) {
					$chk_idx = explode('||',$chk_lst['view3_special_02']);
					for ($i=0; $i < count($chk_idx); $i++) {
						if ($chk_idx[$i] == $_GET['store']) {
							$chk_arr[] = $chk_lst['view3_idx'];
						}
					}
				}
				$chk_array = implode(",",$chk_arr);


				$tot_sql = "select * from ".TABLE_LEFT."event_01 where view3_use = 1 and view3_idx in ({$chk_array}) order by view3_close desc, view3_order desc, view3_write_day desc";
				$tot_res = mysql_query($tot_sql);
				$tot_num = mysql_num_rows($tot_res);
				$list_page = 12;
				$page_per_list = 5;
				$start = ($view3_page - 1) * $list_page;
				$path_next_event = view3_link("||page||now_date||type||store","list_event&store=".$_GET['store'],"no");
				page($tot_num, $list_page, $page_per_list, $path_next_event, "img", $view3_page, $end_page_path);

				$next_sca .= "";

			    $sql = "select * from ".TABLE_LEFT."event_01 where view3_use = 1 order by view3_notice asc, view3_close desc, view3_order desc, view3_write_day desc LIMIT {$start},{$list_page}";
			    $out_sql = mysql_query($sql);
				$sql_num = mysql_num_rows($out_sql);

			    while($list = mysql_fetch_assoc($out_sql)) {
					$event_lst = explode("||",$list['view3_special_02']);
					$event_idx = implode(",",array_values(array_diff(explode("||",$list['view3_special_02']), array(''))));
					$open_day = date("Y-m-d", strtotime($list['view3_open']));
					$now_day =  date("Y-m-d", time());
					for ($i=0; $i < count($event_lst); $i++) {
						if ($event_lst[$i] == $_GET['store'] && $open_day <= $now_day) {
							$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
					        $path_view = URL_PATH.'?'.view3_link('||idx||select||search','list_event_view&select='.$view3_select.'&search='.$view3_search.'&idx='.$list['view3_idx']);
					        $write_day = date('Y-m-d', strtotime($list['view3_write_day']));
					        $close_day = date("Y-m-d", strtotime($list['view3_close']));
							$list_img = explode("||",$list['view3_file']);
							?>
							        <li>
										<a href="<?=$path_view?>">
							                <div class="img_area" style="background-image:url('<?=$root?>/upload/event_01<?=$list_img[2]?>')"></div>
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
										</a>
							        </li>
							<?
						}
					}

			    }
				?>

			            </ul>
			        </div>



			<?
			if(!$tot_num) {
			    $no_data_text = '진행 중인 이벤트가 없습니다.';
				echo '<p class="nodata">'.$no_data_text.'</p>'.PHP_EOL;
			}
			?>
				<!-- paging start -->
				<div class="paging fs_def">
					<?=$out_page?>
				</div>
				<!-- //paging end -->

				<!-- <p class="view_title">매장 이벤트</p>
				<ul class="event_tab fs_def t_center">
					<li class="on"><a href="#none">진행 중 이벤트</a></li>
					<li><a href="#none">완료된 이벤트</a></li>
					<li><a href="#none">전체 이벤트</a></li>
				</ul>
				<div class="event_conts">
					<div class="event_cont01 event_cont">
						<ul>
							<li>
								<div class="img_area" style="background-image:url('../img/page/store/event_img1.jpg')"></div>
								<div class="text_area">
									<div class="prgr_wrap fs_def">
										<p class="prgr_box">진행중</p>
										<p class="prgr_date">~2020.03.15</p>
									</div>
									<p class="event_title ellipsis">새해福권을 드립니다!</p>
									<p class="event_text">강강술래가 새해를 맞이하여 새해복권을 드립니다. 강강술래가 새해를 맞이하여 새해복권을 드립니다. a매장에서 식사를 하신 후 새해복권을 수령하세요~</p>
									<a href="#none" class="event_link">자세히 보기</a>
								</div>
							</li>
							<li>
								<div class="img_area" style="background-image:url('../img/page/store/event_img1.jpg')"></div>
								<div class="text_area">
									<div class="prgr_wrap fs_def">
										<p class="prgr_box">진행중</p>
										<p class="prgr_date">~2020.03.15</p>
									</div>
									<p class="event_title ellipsis">새해福권을 드립니다!</p>
									<p class="event_text">강강술래가 새해를 맞이하여 새해복권을 드립니다. a매장에서 식사를 하신 후 새해복권을 수령하세요~</p>
									<a href="#none" class="event_link">자세히 보기</a>
								</div>
							</li>
						</ul>
					</div>
				</div> -->
			</div>
			<!-- //event end -->
		</div>
<? include_once "list_bottom.php"?>
