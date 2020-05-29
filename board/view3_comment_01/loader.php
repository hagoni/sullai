<?
######################################################################################################################################################
//HERO BOARD 시작 (개발자 : 이진영)
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
include('comment_function.php');
$comment_skin = 'skin_02';
?>
<style>
<? include('css/'.$comment_skin.'.css'); ?>
.comment_auto_textarea{
	overflow:hidden !important;
}
</style>
<?
if(comment_permission_checker('list')){
	unset($comment_list_token);
	$comment_list_token = Array();
	$comment_list_token['option'] = $comment_option;
	$list_token = comment_create_token($comment_list_token);
}
?>
	<div class="view3_comment_wrap comment_<?=$comment_skin;?>">
		<? if(comment_permission_checker('write')){ ?>
		<?
			unset($comment_write_token);
			$comment_write_token = Array();
			$comment_write_token['mode'] = 'write';
			//$decrypt_toen = comment_parse_token($token);
			if(!class_exists('DOMDocument') && ($comment_option['content_type']=='strict') ){
				$comment_option['editor_mode'] = 'plain';
				$comment_option['content_type'] = 'plain';
			}
			$comment_write_token['option'] = $comment_option;
			if( (isset($view3_session['view3_code']) && (trim($view3_session['view3_code'])!=''))){
				$comment_write_token['writer_code'] = $view3_session['view3_code'];
				$comment_write_token['accept_field'] = 'content';
			}else if(comment_writer_checker()){
				$comment_write_token['writer_code'] = '@guest_writer';
				$comment_write_token['accept_field'] = 'content';
			}else{
				$comment_write_token['writer_code'] = '@guest';
				$comment_write_token['accept_field'] = 'name||pw||content';
			}
			$token = comment_create_token($comment_write_token);
		?>
		<form onsubmit="return false;">
			<input type="hidden" name="token" value="<?=$token;?>">
			<div class="comment_insert_area">
				<?if(isset($comment_title) && $comment_title!=''){?><p class="comment_title"><?=$comment_title;?></p><? } ?>
				<?
					if( !((isset($view3_session['view3_code']) && ($view3_session['view3_code']!='')) || comment_writer_checker()) ){
				?>
				<div class="comment_fix_line">
					<div class="comment_input_text input_type_short comment_auto_label_wrap">
						<label class="comment_auto_label">이름</label>
						<input type="text" class="comment_auto_label_input" name="name" required="required" data-required_msg="이름을 입력해 주세요.">
					</div>
				</div>
				<div class="comment_fix_line">
					<div class="comment_input_text input_type_short comment_auto_label_wrap">
						<label class="comment_auto_label">비밀번호</label>
						<input type="password"  class="comment_auto_label_input" name="pw" required="required" data-required_msg="비밀번호를 입력해 주세요.">
					</div>
				</div>
				<? } ?>
				<? if(count($comment_option['secret_form'])  > 0){ ?>
				<div class="c_both"></div>
				<div class="comment_fix_line">
				<?
					$uid = uniqid();
				?>
					<p class="agreePrivacyWrap"><input type="checkbox" class="agreePrivacy" id="<?=$uid;?>" /> <label for="<?=$uid;?>">개인정보 수집 및 활용에 동의합니다.</label><button type="button" class="agreePrivacyContents bindPolicyModalOpen" data-type="event">약관보기</button></p>
					<?
					foreach($comment_option['secret_form'] as $id => $subject){
						if(in_array($id, Array('addr'))){
							$input_type = 'input_type_full';
						}else{
							$input_type = 'input_type_short';
						}
					?>
					<div class="comment_input_text <?=$input_type;?> comment_auto_label_wrap">
						<label class="comment_auto_label"><?=$subject;?></label>
						<input type="text" class="comment_auto_label_input" name="<?=$id;?>" required="required" data-required_msg="<?=$subject;?> 항목을 입력해 주세요.">
					</div>
					<? } ?>

				</div>
				<? } ?>
				<? if(comment_permission_checker('upload')){ ?>
				<!-- <div class="c_both"></div>
				<div class="comment_fix_line">
					<ul class="comment_file_list">
						<li><button type="button" class="description">파일첨부</button></li>
					</ul>
				</div> -->
				<? } ?>
				<div class="c_both"></div>
				<div class="comment_fix_line">
					<div class="comment_textarea comment_auto_label_wrap">
						<label class="comment_auto_label">내용을 입력해주세요</label>
						<div class="comment_auto_textarea_wrap">
							<textarea class="comment_auto_textarea  comment_auto_label_input" name="content" required="required" data-required_msg="<?=trim($comment_option['set_comment'])?'내용을 입력해 주세요.':'';?>"><?=trim($comment_option['set_comment'])!=''?$comment_option['set_comment']:'';?></textarea>
						</div>
					</div>
				</div>
				<span class="comment_insert_btn comment_insert_action">댓글 등록</span>
				<div class="c_both"></div>
			</div>
		</form>
		<? } ?>
		<ul class="comment_list_area">
		</ul>

					<div class="comment_box_form" style="display:none;">

						<div class="pw_check_box">
							<form onsubmit="return false;">
								<div class="pw_check_close">×</div>
								<div class="comment_pwcheck_wrap">
									<div class="input_type_pwcheck comment_auto_label_wrap">
										<label class="comment_auto_label">비밀번호를 입력해주세요.</label>
										<input type="password"  class="comment_auto_label_input" name="pw" required="required" data-required_msg="비밀번호를 입력해주세요">
									</div>
									<span class="comment_pwcheck_btn comment_action">확인</span>
									<div class="c_both"></div>
								</div>
								<div class="c_both"></div>
							</form>
						</div>

						<div class="comment_fix_line">
							<form onsubmit="return false;">
								<? if(count($comment_option['secret_form'])  > 0){ ?>
								<div class="c_both"></div>
								<div class="comment_fix_line">
									<?
									foreach($comment_option['secret_form'] as $id => $subject){
										if(in_array($id, Array('addr'))){
											$input_type = 'input_type_full';
										}else{
											$input_type = 'input_type_short';
										}
									?>
									<div class="comment_input_text <?=$input_type;?> comment_auto_label_wrap">
										<label class="comment_auto_label"><?=$subject;?></label>
										<input type="text" class="comment_auto_label_input" name="<?=$id;?>" required="required" data-required_msg="<?=$subject;?> 항목을 입력해 주세요.">
									</div>
									<? } ?>

								</div>
								<? } ?>
								<div class="comment_textarea  comment_auto_label_wrap">
									<label class="comment_auto_label">내용을 입력해주세요</label>
									<div class="comment_auto_textarea_wrap">
										<textarea class="comment_auto_textarea comment_auto_label_input" required="required" data-required_msg="내용을 입력해주세요" name="content"></textarea>
									</div>
									<span class="comment_insert_btn comment_action">수정</span>
									<div class="c_both"></div>
								</div>
							</form>
						</div>

					</div>

	</div>


<script type="text/javascript">
	var mouseover_active = true;
	var replaceType = '<?=$comment_option['list_type'];?>';//append, replace
	function comment_auto_textarea(obj){
		var jquery_obj = $(obj);
		var ta_wrap = jquery_obj.parent();
		var min_height = 90;
		if(!ta_wrap.hasClass('comment_auto_textarea_wrap')){
			return;
		}
		ta_wrap.height(jquery_obj.height());
		//jquery_obj.height(min_height);
		jquery_obj.css('height','');

		if(jquery_obj[0].scrollHeight < jquery_obj.height()){
			jquery_obj.css("height","");
		}else{
			jquery_obj.attr("style",jquery_obj.attr("style")+";height:"+jquery_obj[0].scrollHeight+"px !important;");
		}
		ta_wrap.height(jquery_obj.outerHeight());}function comment_auto_label(input_obj){
		var jquery_input_obj = $(input_obj);
		var label_obj = jquery_input_obj.closest('.comment_auto_label_wrap').find('.comment_auto_label');
		if(label_obj.length<1){
			return;
		}
		if(jquery_input_obj.val().length < 1){
			label_obj.show();
		}else{
			label_obj.hide();
		}
	}
	function comment_content_data_onchange(){
		$('textarea.comment_auto_textarea').trigger('change');
		$('.comment_auto_label_input').trigger('change');
	}
	function get_token_process(token){
		if(typeof window.token_manager == 'undefined'){
			window.token_manager = Array();
		}
		if( typeof window.token_manager[token] == 'undefined' ){
			window.token_manager[token] = false;
		}
		return window.token_manager[token];

	}
	function set_token_process(token,val){
		if(typeof window.token_manager == 'undefined'){
			window.token_manager = Array();
		}
		window.token_manager[token] = val;

	}
	function comment_data_load(token,type){
		if(typeof type !== 'string')type = 'append';//append, replace
		set_token_process(token,true);
		$.ajax({
			'url' : '<?=$comment_option['skin_root'];?>/list.ajax.php?token='+token+'<?=session_name()!=''?'&SN='.session_name():'';?>',
			'error' : function(){
				alert('에러가 발생하였습니다. 다시 시도해주세요');
			},
			'success' : function(response){
				if(type=='append'){
					$('.comment_more_list').remove();
					$('.comment_list_area').append(response);
				}
				if(type=='replace'){
					$(window).animate({scrollTop:$('.comment_list_area').offset().top});
					$('.comment_list_area').html(response);
				}
				var show_delay = 0;
				$('.comment_list_area li:not(:visible)').fadeIn(1250);
			},
			'complete' : function(){
				set_token_process(token,false);
			}
		});
	}
	<? if(isset($list_token) && ($list_token!='')){?>
	comment_data_load('<?=$list_token;?>',replaceType);
	<? }?>
	$('body').on('click','li.comment_more_list, .more_comment',function(){
		var token = $(this).data('token');
		if(get_token_process(token) == true){
			alert('처리중 입니다');
			return;
		}
		comment_data_load(token,replaceType);
	});
	$('body').on('click','a.comment_more_list',function(e){
		e.preventDefault();
	});
	function comment_action(obj){
		if(typeof $(obj).data('confirm') != 'undefined'){
			if ( ! confirm($(obj).data('confirm')) ){
				return;
			}
		}
		var token = $(obj).data('token');
		var required_check = true;
		set_token_process(token,true);
		var form_data = '';
		var detect_form = $(obj).closest('form');
		if(detect_form.length > 0){
			form_data = detect_form.serialize();
			detect_form.find('[required="required"]').each(function(){
				if(!required_check)return;
				if($(this).val()==""){
					if(typeof $(this).data('required_msg') !== 'undefined'){
						alert($(this).data('required_msg'));
					}else{
						alert('필수 항목을 모두 입력해주세요');
					}
					required_check=false;
				}
			});
			if(!required_check){
				set_token_process(token,false);
				return;
			}
		}
		$.ajax({
			'url' : '<?=$comment_option['skin_root'];?>/action.php?token='+token+'<?=session_name()!=''?'&SN='.session_name():'';?>',
			type : 'POST',
			method : 'POST',
			data : form_data,
			'error' : function(){
				alert('에러가 발생하였습니다. 다시 시도해주세요');
			},
			'success' : function(result_data){
				if(typeof result_data !== 'object')result_data = eval('('+ result_data +')');
				set_token_process(token,false);
				if(typeof result_data !== 'object'){
					alert('에러가 발생하였습니다. 다시 시도해주세요');
					return;
				}
				var token_li = $(obj).closest('.comment_content_li');
				if(result_data.action=='check_pw'){
					if(token_li.find('.pw_check_box').length > 0){
						if(result_data.msg.length > 0){
							alert(result_data.msg);
						}
					}else{
						token_li.find('.comment_list_content_wrap').addClass('blur');
						token_li.append('<div class="pw_check_box">'+$('.comment_box_form .pw_check_box').html()+'</div>');
						token_li.find('.comment_pwcheck_btn.comment_action').data('token',token);
						comment_content_data_onchange();
					}
					return;
				}
				if(result_data.action=='check_confirm'){
				}
				if(result_data.action=='edit_result'){
					if(result_data.result=='true'){
						token_li.find('.comment_list_content_wrap').removeClass('blur');
						token_li.find('.pw_check_box').remove();
						token_li.find('.comment_fix_line').remove();
						token_li.find('div.content_type_text').show().html(result_data.comment);
					}else{
						alert('수정실패');
					}
					return;
				}
				if(result_data.action=='delete_result'){
					if(result_data.result=='true'){
						token_li.slideUp(750,function(){$(this).remove();});
					}else{
						alert('삭제실패');
					}
					return;
				}
				if(result_data.action=='set_edit_mode'){
					token_li.find('.comment_list_content_wrap').removeClass('blur');
					token_li.find('.pw_check_box').remove();
					token_li.find('.comment_fix_line').remove();
					if( token_li.find('.comment_fix_line').length < 1 ){
						token_li.find('.comment_list_content_wrap').append('<div class="comment_fix_line">'+$('.comment_box_form .comment_fix_line').html()+'</div>');
						token_li.find('.comment_fix_line .comment_action').data('token',token);
						if(typeof result_data.secret_data == 'object'){
							for(var i in result_data.secret_data){
								token_li.find('.comment_fix_line [name="'+i+'"]').val(result_data.secret_data[i]);
							}
						}
						token_li.find('.comment_fix_line textarea[name="content"]').val(result_data.comment);
						token_li.find('div.content_type_text').hide();
						comment_content_data_onchange();
					}
					return;
				}
				if(result_data.action=='set_view_mode'){
					token_li.find('.comment_list_content_wrap').removeClass('blur');
					token_li.find('.pw_check_box').remove();
					token_li.find('.comment_fix_line').remove();
					token_li.find('.comment_content').html(result_data.comment);
					return;
				}
				if(typeof result_data.msg == 'string' && result_data.msg.length > 0){
					alert(result_data.msg);
				}else{
					alert('ERROR');
				}
			},
			'complete' : function(){
				set_token_process(token,false);
			}
		});
	}
	$('body').on('click','.comment_action',function(){
		var token = $(this).data('token');
		if(get_token_process(token) == true){
			alert('처리중 입니다');
			return;
		}
		$('.comment_option.on').removeClass('on');
		$('body').off('click.comment_option');
		comment_action(this);
	});
	$('body').on('click','.pw_check_close',function(){
		$(this).closest('.comment_content_li').find('.comment_list_content_wrap').removeClass('blur');
		$(this).closest('.pw_check_box').remove();
	});
	$('body').on('keydown keyup','textarea.comment_auto_textarea',function(){comment_auto_textarea(this);});
	$('body').on('change','textarea.comment_auto_textarea',function(){comment_auto_textarea(this);});
	$('body').on('keydown keyup','.comment_auto_label_input',function(){comment_auto_label(this);});
	$('body').on('change','.comment_auto_label_input',function(){comment_auto_label(this);});
	$('body').on('click','.comment_auto_label',function(){$(this).parent().find('.comment_auto_label_input').focus()});
	$('body').on('click','.comment_option:not(".on")',function(e){
		$(this).addClass('on');
		$('body').off('click.comment_option');
		$('body').on('click.comment_option',function(e){
			if($('.comment_option.on').find(e.target).length < 1){
				$('.comment_option.on').removeClass('on');
			}
		});
	});
	comment_content_data_onchange();
	$('.comment_insert_action').click(function(){
		var required_check = true;
		var f_form = $('.comment_insert_action').closest('form');
		if(typeof f_form.find('.agreePrivacy') !== 'undefined' && f_form.find('.agreePrivacy').prop('checked') == false){
			required_check = false;
			alert('개인 정보 수집 및 활용에 동의하셔야 등록할 수 있습니다.');
		}
		f_form.find('[required="required"]').each(function(){
			if(!required_check)return;
			if($(this).val()==""){
				if(typeof $(this).data('required_msg') !== 'undefined'){
					alert($(this).data('required_msg'));
				}else{
					alert('필수 항목을 모두 입력해주세요');
				}
				required_check=false;
			}
		});
		f_form.attr('action', '<?=$comment_option['skin_root'];?>/action.php?token='+f_form.find('[name="token"]').val()+'<?=session_name()!=''?'&SN='.session_name():'';?>');
		f_form.attr('method', 'POST');
		if(required_check)$('.comment_insert_action').closest('form')[0].submit();
	});
</script>
