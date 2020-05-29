<? include_once "list_high.php"?>
		<div class="view_conts">
			<p class="view_title">고객의 소리</p>
			<?
			if(false) {
				$email_required = ' required';
			} else {
				$email_required = '';
			}
			$view_email = '
				<input type="text" id="email_01"'.$email_required.' data-input="email" onkeyup="view3_email_value(this);" >
				<span class="bridge">@</span>
				<input type="text" id="email_02"'.$email_required.' data-input="email" onkeyup="view3_email_value(this);">
				<span class="nbsp"></span>
				<select id="email_03" data-input="email" onchange="javascript:view3_email(this,this.options[this.selectedIndex].value);">
					<option value="">직접입력</option>
					<option value="naver.com">naver.com</option>
					<option value="gmail.com">gmail.com</option>
					<option value="nate.com">nate.com</option>
					<option value="yahoo.co.kr">yahoo.co.kr</option>
					<option value="hanmail.net">hanmail.net</option>
					<option value="daum.net">daum.net</option>
					<option value="dreamwiz.com">dreamwiz.com</option>
					<option value="lycos.co.kr">lycos.co.kr</option>
					<option value="empas.com">empas.com</option>
					<option value="korea.com">korea.com</option>
					<option value="paran.com">paran.com</option>
					<option value="freechal.com">freechal.com</option>
					<option value="hanmir.com">hanmir.com</option>
					<option value="hotmail.com">hotmail.com</option>
				</select>
			';
			?>

			<!-- board wrapper start -->
			<div id="boardWrap">
				<div class="inquiry_wrap">
					<form class="inquiry_form pc_inquiry" method="post" action="<?=BOARD?>/index.php?board=inquiry_01&store=11&view_tab=5&type=action&skin=root" enctype="multipart/form-data" accept-charset="<?=SET?>">
						<input type="hidden" name="drop" value="drop||privacy_agree||board||pw||skin||url||inquiry_action||x||y">
						<input type="hidden" name="board" value="inquiry_01">
						<input type="hidden" name="sca" value="customer_01">
						<input type="hidden" name="inquiry_action" value="ok">
						<input type="hidden" name="url" value="<?=URL?>">
						<input type="hidden" name="title_01" value="<?=$h2_title_sub?>">
						<input type="hidden" name="email" value="">
						<fieldset class="iqr_policy_wrap" style="margin-top:20px;">
							<legend class="iqr_tit b_ff_h b_c_m" style="display:none">개인정보 수집 및 활용동의</legend>
							<div class="iqr_check rel pc_inquiry">
								<input type="checkbox" name="privacy_agree" id="inquiryPolicyCheck" />
								<label for="inquiryPolicyCheck" class="b_ff_m b_c_l">개인정보취급방침을 읽었으며 이에 동의합니다.</label>
								<a href="#none" class="bindPolicyModalOpen open_policy" data-type="0">전문보기</a>
							</div>
						</fieldset>
						<fieldset class="iqr_info">
							<legend class="iqr_tit rel b_ff_h b_c_m">고객 정보<small class="iqr_dot b_ff_m b_c_l"><span>동그라미 표시</span>는 필수입력항목입니다.</small></legend>
							<table summary="상담자 정보 입력사항" class="inquiry_table pc_inquiry">
								<caption class="indent">상담자 정보 입력사항</caption>
								<!-- <colgroup>
									<col width="20%">
									<col width="80%">
								</colgroup> -->
								<tbody>
									<tr>
										<th scope="row"><label for="iqr_title_01" class="required">제목</label></th>
										<td class="col2">
											<input type="text" name="title_01" id="iqr_title_01" required autocomplete="off">
										</td>
									</tr>
									<tr>
										<th scope="row" class="col1"><label for="iqr_name" class="required">이름</label></th>
										<td class="col2">
											<input type="text" name="name" id="iqr_name" required autocomplete="off">
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="iqr_hp" class="required">연락처</label></th>
										<td>
											<input type="text" name="hp" id="iqr_hp" required autocomplete="off" onkeyup="hero_key(this,1);">
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="iqr_email_01">이메일</label></th>
										<td class="col2">
											<?=$view_email?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="iqr_special_01" class="required">지점선택</label></th>
										<td class="col2">
											<select class="" name="special_01" id="iqr_special_01">
												<option value="">선택</option>
												<option value="999999">본사</option>
												<?
												$map_sql = "select * from ".TABLE_LEFT."map_01 where view3_use = 1 order by view3_order desc, view3_write_day desc";
												$map_res = mysql_query($map_sql);
												while ($map_lst = mysql_fetch_assoc($map_res)) {
												?>
												<option value="<?=$map_lst['view3_idx']?>" <?if ($map_lst['view3_idx'] == $store_idx) {echo 'selected';}?>><?=$map_lst['view3_title_01']?></option>
												<?
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="iqr_special_03_01">상담유형</label></th>
										<td class="col2">
											<input type="radio" name="special_03" id="special_03_01" value="메뉴" checked>
											<label for="special_03_01">메뉴</label>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<input type="radio" name="special_03" id="special_03_02" value="서비스">
											<label for="special_03_02">서비스</label>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<input type="radio" name="special_03" id="special_03_03" value="멤버십">
											<label for="special_03_03">멤버십</label>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<input type="radio" name="special_03" id="special_03_04" value="마케팅">
											<label for="special_03_04">마케팅</label>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<span class="nbsp"></span>
											<input type="radio" name="special_03" id="special_03_05" value="기타문의 & 제안">
											<label for="special_03_05">기타문의 & 제안</label>
										</td>
									</tr>
									<tr>
										<th scope="row" class="v_top"><label for="iqr_command_01" class="required">문의내용</label></th>
										<td class="col2">
											<textarea name="command_01" id="iqr_command_01" required></textarea>
										</td>
									</tr>
								</tbody>
							</table>
						</fieldset>
						<button type="submit" class="b_btn01 bindInquirySubmit" onclick="inquiry(this.form);">문의하기</button>
					</form>
					<form class="inquiry_form mobile_inquiry" method="post" action="<?=BOARD?>/index.php?board=inquiry_01&store=11&view_tab=5&type=action&skin=root" enctype="multipart/form-data" accept-charset="<?=SET?>">
						<input type="hidden" name="drop" value="drop||privacy_agree||board||pw||skin||url||inquiry_action||x||y">
						<input type="hidden" name="board" value="inquiry_01">
						<input type="hidden" name="sca" value="customer_01">
						<input type="hidden" name="inquiry_action" value="ok">
						<input type="hidden" name="url" value="<?=URL?>">
						<input type="hidden" name="title_01" value="<?=$h2_title_sub?>">
						<input type="hidden" name="email" value="">
						<fieldset class="iqr_policy_wrap" style="margin-top:20px;">
							<legend class="iqr_tit b_ff_h b_c_m" style="display:none">개인정보 수집 및 활용동의</legend>
							<!-- <div class="iqr_policy mobile_inquiry">
			                    <ol>
			                        <li class="b_fs_l b_ff_m b_lh_m b_c_l">
			                        1. 개인정보의 수집 및 이용 목적<br>
			                        가맹 관련 문의 확인 및 답변을 위한 연락통지, 처리결과 통보 등을 목적으로 개인정보를 처리합니다.
			                        </li>
			                        <li class="b_fs_l b_ff_m b_lh_m b_c_l">
			                        2. 처리하는 개인정보 항목<br>
			                        - 필수항목 : 이름, 연락처 (접속 IP 정보, 쿠키, 서비스 이용 기록, 접속 로그)<br>
			                        - 선택항목 : 이메일
			                        </li>
			                        <li class="b_fs_l b_ff_m b_lh_m b_c_l">
			                        3. 개인정보의 처리 및 보유 기간<br>
			                        ① 법령에 따른 개인정보 보유.이용기간 또는 정보주체로부터 개인정보를 수집 시에 동의 받은 개인정보 보유, 이용기간 내에서 개인정보를 처리, 보유합니다.<br>
			                        ② 개인정보의 보유 기간은 5년입니다.
			                        </li>
			                    </ol>
							</div>
							<div class="iqr_check mobile_inquiry">
								<input type="checkbox" name="privacy_agree" id="inquiryPolicyCheck_m">
								<label for="inquiryPolicyCheck_m" class="b_ff_m b_c_l">위 개인정보 수집 및 활용에 동의합니다.</label>
							</div> -->
							<div class="iqr_check rel mobile_inquiry">
								<input type="checkbox" name="privacy_agree" id="inquiryPolicyCheck_m" />
								<label for="inquiryPolicyCheck_m" class="b_ff_m b_c_l">개인정보취급방침을 읽었으며 이에 동의합니다.</label>
								<a href="#none" class="bindPolicyModalOpen open_policy" data-type="0">전문보기</a>
							</div>
						</fieldset>
						<fieldset class="iqr_info">
							<legend class="iqr_tit rel b_ff_h b_c_m">고객 정보<small class="iqr_dot b_ff_m b_c_l"><span>동그라미 표시</span>는 필수입력항목입니다.</small></legend>
							<div class="inquiry_fields mobile_inquiry">
								<ul>
									<li>
										<p class="field_title required"><label for="title_01">제목</label></p>
										<input type="text" name="title_01" id="title_01" required autocomplete="off">
									</li>
									<li>
										<p class="field_title required"><label for="name">이름</label></p>
										<input type="text" name="name" id="name" required autocomplete="off">
									</li>
									<li>
										<p class="field_title required"><label for="hp">연락처</label></p>
										<input type="text" name="hp" id="hp" required autocomplete="off" onkeyup="hero_key(this,1);">
									</li>
									<li>
										<p class="field_title<?if($email_required){echo ' required';}?>"><label for="iqr_email_01">이메일</label></p>
										<?=$view_email?>
									</li>
									<li>
										<p class="field_title required"><label for="special_01" class="required">지점선택</label></p>
										<select class="" name="special_01" id="special_01">
											<option value="">선택</option>
											<option value="999999">본사</option>
											<?
											$map_sql = "select * from ".TABLE_LEFT."map_01 where view3_use = 1 order by view3_order desc, view3_write_day desc";
											$map_res = mysql_query($map_sql);
											while ($map_lst = mysql_fetch_assoc($map_res)) {
											?>
											<option value="<?=$map_lst['view3_idx']?>" <?if ($map_lst['view3_idx'] == $store_idx) {echo 'selected';}?>><?=$map_lst['view3_title_01']?></option>
											<?
											}
											?>
										</select>
									</li>
									<li>
										<p class="field_title">상담유형</p>
										<div class="input_radio">
											<input type="radio" name="special_03" id="special_03_01_01" value="메뉴" checked>
											<label for="special_03_01_01">메뉴</label>
										</div>
										<div class="input_radio">
											<input type="radio" name="special_03" id="special_03_02_02" value="서비스">
											<label for="special_03_02_02">서비스</label>
										</div>
										<div class="input_radio">
											<input type="radio" name="special_03" id="special_03_03_03" value="멤버십">
											<label for="special_03_03_03">멤버십</label>
										</div>
										<div class="input_radio">
											<input type="radio" name="special_03" id="special_03_04_04" value="마케팅">
											<label for="special_03_04_04">마케팅</label>
										</div>
										<div class="input_radio">
											<input type="radio" name="special_03" id="special_03_04_05" value="기타문의 & 제안">
											<label for="special_03_04_05">기타문의 & 제안</label>
										</div>
									</li>
									<li>
										<p class="field_title required"><label for="command_01">문의내용</label></p>
										<textarea name="command_01" id="command_01" required></textarea>
									</li>
								</ul>
							</div>

						</fieldset>
						<button type="submit" class="b_btn01 bindInquirySubmit" onclick="inquiry(this.form);">문의하기</button>
					</form>
			    </div>
			</div>
			<!-- //board wrapper end -->
		</div>
<? include_once "list_bottom.php"?>
