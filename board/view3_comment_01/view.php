<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
?>
<style>
/* 게시판 뷰페이지 */
#viewTitle{padding:15px 0;border-top:1px solid #d9d9d9;margin-bottom:15px;border-bottom:1px solid #d9d9d9;font-size:25px;color:#000}
#viewTitleDate{font-size:14px}
div.listBtnWrap{overflow:hidden;position:absolute;width:100%;top:12px;left:0px;}
div.listBtnL{width:150px}
div.listBtnR{width:100px}
#viewListWrap{overflow:hidden;clear:both;position:relative;padding:12px 0 14px;font-size:25px;color:#000}/*border-top:1px solid #d9d9d9;border-bottom:1px solid #d9d9d9;*/
#viewListWrap p{position:relative;z-index:20;width:100px;margin:0 auto}

div.view_top{}
table.board_view{margin-bottom:5px;font-size:16px;text-align:center}
table.board_view th{padding:13px 0;background:#002566;font-family:NanumBarunGothicBold;color:#fff}
div.view_con{clear:both;overflow:hidden;padding:50px 30px;background:#eeeeee;font-size:14px;color:#676767;}
div.view_text{padding-bottom:20px;font-size:14px;line-height:18px;word-break:break-all;}
div.view_btn_wrap{overflow:hidden;width:210px;margin-bottom:30px}
div.edit_btn, div.del_btn{width:100px;background:#002566;font-size:16px;color:#fff;border-radius:5px;text-align:center}
div.view_btn_wrap a{display:block;padding:13px 0;text-decoration:none}

.viewCon {position: relative;width: 100%;}

/* 기본 게시판 - view page */ 
table.board_view{margin-bottom:5px;font-size:16px;text-align:center}
table.board_view th{padding:13px 0;background:#002566;font-family:NanumGothicBold;color:#fff}
table.board_view.advice th{padding:13px 0;background:transparent url('/new/img/board/advice_01/head_bg.jpg') repeat;font-size:20px;font-family:NanumGothicBold;color:#fff}
div.view_page{clear:both;overflow:hidden;padding:30px 30px 20px;border-left:1px solid #c7c7c7;border-right:1px solid #c7c7c7;border-bottom:1px solid #c7c7c7;font-size:14px;color:#676767}
div.view_text{overflow:hidden;padding-bottom:20px;font-size:14px;line-height:18px;word-break:break-all;text-align:left}

</style>
<!-- boardWrap start -->
<div id="boardWrap">
<?
######################################################################################################################################################
$sql = $main_sql.$view_order.PHP_EOL;
$out_sql = @mysql_query($sql);
$list                             = @mysql_fetch_assoc($out_sql);
view3_hit($view3_table, $list['view3_idx']);
######################################################################################################################################################
// 이전글 다음글
######################################################################################################################################################
	$sort = view3_prev_next($view3_table,$view3_idx);
	$path_prev = view3_link("||idx","view&idx=".$temp_prev,"",$end_path);
	$path_next = view3_link("||idx","view&idx=".$temp_next,"",$end_path);
######################################################################################################################################################
	$_SESSION['idx']=$view3_idx;
######################################################################################################################################################
	$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
######################################################################################################################################################
	$next_command_01 = str_ireplace('<img', '<img onclick="hero_img(this);" style="cursor:pointer;"', view3_html($list['view3_command_01']));
	$write_day = date("Y-m-d", strtotime($list['view3_write_day']));
######################################################################################################################################################
?>
	<div id="viewCon" class="viewCon f_clear">
		<!-- 게시판 뷰페이지 상단 시작 -->
		<table summary="게시판 제목" name="" class="board_view" width="100%">
			<caption class="indent">게시판 제목</caption>
			<colgroup>
				<col width="12%" />
				<col width="80%" />
				<col width="8%" />
			</colgroup>
			<thead>
				<tr>
					<th><?=$write_day;?></th>
					<th class="t_left"><?=$list['view3_title_01'];?></th>
					<th><?=$option['name'];?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="3">
						<div class="view_page">
							<?
								$fileListOption = Array();
								$fileListOption['print_image'] = true;
							?>
							<? include(BOARD_INC.'/fileList.php'); ?>
							<p>&nbsp;</p>
							<div class="view_text">
<?
if( (strcmp($option['user_down'],"")) or (strcmp($option['user_view'],"")) ){
?>
								<ul class="viewList">
								<?
									//echo $option['user_down'];
									echo $option['user_view'];
								?>
								</ul>
<?
}
?>
								<p><?=$next_command_01;?></p>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
			
		</table>
		<!-- //게시판 뷰페이지 상단 목록 끝 -->
		<!-- 수정 삭제 시작 -->
		<div class="view_btn_wrap f_right">
			<div class="edit_btn f_left">
				<a  href="#password_action" class="spectrumEvent" data-event="open" data-layercode="post_password" data-method="post" data-action="<?=URL_PATH;?>?<?=$path_edit;?>" >수정</a>
			</div>
			<div class="del_btn f_right">
				<a  href="#password_action" class="spectrumEvent" data-event="open" data-layercode="post_password" data-action="<?=BOARD;?>/index.php?<?=$path_delete;?>" data-method="post" data-hidden_data="idx[==]<?=$view3_idx;?>[||]drop[==]all[||]url[==]<?=URL_PATH;?>?<?=$path_drop;?>[||]">삭제</a>
			</div>
		</div>
		<!-- //수정 삭제 끝 -->
		<div>&nbsp;</div>
		<div id="comment_all">
<?
		$comment_title = '댓글';
		$comment_skin = 'view3_comment_01';
		$comment_root = "/board/".$comment_skin;
		unset($comment_option);
		$comment_option = Array();
		/*
			#권한 옵션
				"guest" : 비회원
				"member" : 회원
				"writer" : 해당글 작성자
				level(int) : level에 권한 부여(로그인된 회원에 한해서)
					- 입력 방법
					level(int) - 일반(여러개 입력 가능)
					level(int)~level(int) - 구간지정
		*/
		$comment_option['list_type'] = 'append';//replace, append
		$comment_option['skin_root'] = ROOT.$comment_root;//comment skin root
		$comment_option['show_count'] = '2';//한 번에 불러올 개수
		$comment_option['permission']['admin'] = '90~100';//관리 권한
		$comment_option['permission']['write'] = 'guest||writer||90~100';//쓰기권한
		$comment_option['permission']['edit'] = 'guest||90~100';//수정권한
		$comment_option['permission']['delete'] = 'guest||90~100';//삭제권한
		$comment_option['permission']['list'] = 'guest||writer||90~100';//목록 보기권한
		$comment_option['permission']['view'] = 'guest||writer||90~100';//내용 보기권한
		//$comment_option['permission']['upload'] = 'writer||90~100';//업로드권한
		$comment_option['post']['board'] = $board;//게시글 게시판 table명
		$comment_option['post']['idx'] = $list['view3_idx'];//게시글 idx
		$comment_option['post']['name'] = $list['view3_name'];//게시글 작성자 이름
		$comment_option['post']['code'] = $list['view3_code'];//게시글 view3_code
		$comment_option['post']['pw'] = $list['view3_pw'];//게시글 pw
		$comment_option['check']['pw'] = $pw_md5;//인증한 비밀번호(md5?)
		$comment_option['editor_mode'] = 'plain';//에디터 옵션 == plain(Default) : textarea형식,editor : 에디터 활성화(content_mode 가 strict 일때 php5 미만 에서는 plain모드)
		$comment_option['content_type'] = 'plain';//Content 옵션 == plain(Default) : PlainText, strict : tag명만 허용 및 script tag사용 불가(php5이상만! PHP5미만에서는 plain 모드),free : 모든 태그 허용
		@include_once ROOT_INC.$comment_root.'/loader.php';

?>
		</div>
	</div>
	<!-- //viewCon end -->
<?
######################################################################################################################################################
	@include_once                                                   BOARD_INC."/setup_bottom.php";
######################################################################################################################################################
?>
<script type="text/javascript">
(function($){
	$(document).ready(function(){
		new SpectrumBox();
	});
}(jQuery))
</script>
</div>
<!-- //boardWrap end -->