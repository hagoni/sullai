<?
define('_VIEW3BOARD_',true);
if($_GET['SN']!=''){
	@session_name($_GET['SN']);
}
include('../../view3.php');
if(!isset($_SESSION)){
	session_start();
}
include ('comment_function.php');
$parse_contents = comment_parse_token($_GET['token']);
if($parse_contents == false){
	echo '<script type="text/javascript">alert("'.$_GET['token'].'Token 시간이 만료 되었습니다. 페이지를 새로고침 해주세요.");</script>';
	exit;
}

if(!isset($parse_contents['option']['show_count']) || ($parse_contents['option']['show_count']<1)){
	$parse_contents['option']['show_count'] = 10;
}
if(isset($parse_contents['loaded_idx']) && is_array($parse_contents['loaded_idx'])){
	$loaded_idx = $parse_contents['loaded_idx'];
}else{
	$loaded_idx = Array();
}
$clean_loaded_idx = Array();
$loaded_idx = array_filter($loaded_idx);

$loaed_idx_sql = '';
if(count($loaded_idx) > 0){
	foreach($loaded_idx as $attach_idx){
		$loaed_idx_sql .= ", '".$attach_idx."'";
	}
}

$clean_loaed_idx_sql = '';
$clean_loaded_idx_sql = "SELECT * FROM `".TABLE_LEFT."comment` WHERE `view3_idx` IN (''".$loaed_idx_sql.");";
$clean_loaded_idx_query = mysql_query($clean_loaded_idx_sql);
if($clean_loaded_idx_query && ( mysql_num_rows($clean_loaded_idx_query) > 0) ){
	while($clean_loaded_idx_data = mysql_fetch_assoc($clean_loaded_idx_query)){
		$clean_loaed_idx_sql .= ", '".$clean_loaded_idx_data['view3_idx']."'";
		$clean_loaded_idx[] = $clean_loaded_idx_data['view3_idx'];
	}
}


$parse_contents['show_page'] = (int)$parse_contents['show_page'];

$parse_contents['option']['show_count'] = (int)$parse_contents['option']['show_count'];
$comment_option = $parse_contents['option'];
$cnt_sql = sprintf("
	SELECT * FROM `".TABLE_LEFT."comment` WHERE
	`view3_board_name`=%s AND
	`view3_board_idx`=%s AND
	`view3_use`=1",
	safe_query_val($comment_option['post']['board']),//`view3_board_name`
	safe_query_val($comment_option['post']['idx'])//`view3_board_idx`
);
$cnt_query = mysql_query($cnt_sql);
if(!$cnt_query){
	echo '<script type="text/javascript">alert("오류가 발생하였습니다.. 페이지를 새로고침 해주세요.");</script>';
	exit;
}
if($comment_option['list_type']=='replace'){
	if($parse_contents['show_page']<1){
		$start = 0;
		$page = 1;
	}else{
		$start = ($parse_contents['show_page']-1)*$parse_contents['option']['show_count'];
		$page = $parse_contents['show_page'];
	}
}else{
	$start = 0;
	$page = 1;
}
$total_cnt = mysql_num_rows($cnt_query);
$list_sql = sprintf("
	SELECT * FROM `".TABLE_LEFT."comment` WHERE
	`view3_board_name`=%s AND
	`view3_board_idx`=%s AND
	`view3_idx` NOT IN (''".$clean_loaed_idx_sql.") AND
	`view3_use`=1
	ORDER BY `view3_idx` ASC
	LIMIT ".$start.",".$parse_contents['option']['show_count']."
	",
	safe_query_val($comment_option['post']['board']),//`view3_board_name`
	safe_query_val($comment_option['post']['idx'])//`view3_board_idx`
);
$list_query = mysql_query($list_sql);
if($list_query&&(mysql_num_rows($list_query)<1)){
	exit;
}
while($comment_list = mysql_fetch_assoc($list_query)){
$clean_loaded_idx[] = $comment_list['view3_idx'];
$member_name = '';
if( $comment_list['view3_code'] == '@guest'){
	$member_name = $comment_list['view3_name'];
}else if( $comment_list['view3_code'] == '@guest_writer'){
	$member_name = $comment_option['post']['name'];
}else{
	$member_sql = 'SELECT * FROM `'.TABLE_LEFT.'member` WHERE `view3_code` = "'.str_replace('"','\\"',$comment_list['view3_code']).'" LIMIT 0,1;';
	$member_query = mysql_query($member_sql);
	if($member_query && (mysql_num_rows($member_query)>0)){
		$member_data = mysql_fetch_assoc($member_query);
		$member_name = $member_data['view3_name'];
	}
}
if(strlen(trim($member_name))<1){
	$member_name = '(알수없는 회원)';
}
?>
<li style="display:none;" class="comment_content_li">
	<div class="comment_list_content_wrap">
		<p class="comment_user_name"><?=$member_name;?><span><?=date('Y-m-d H:i:s',strtotime($comment_list['view3_write_day']));?></span></p>
		<div class="comment_option">
			<div class="comment_option_menu">
				<ul>
					<?
						$active_btn = false;
						if(!comment_permission_checker('view',$comment_list['view3_code'])){
							$active_btn = true;
							unset($comment_edit_token);
							$comment_edit_token = Array();
							$comment_edit_token['mode'] = 'view';
							$comment_edit_token['option'] = $comment_option;
							$comment_edit_token['idx'] = $comment_list['view3_idx'];
							$comment_edit_token['accept'] = false;
							$comment_edit_token['accept_field'] = 'content';
							if( (($comment_list['view3_code']=='@guest_writer') && comment_writer_checker()) || (isset($view3_session['view3_code']) && ($view3_session['view3_code']==$comment_list['view3_code'])) || comment_permission_checker('admin') ){
								$comment_edit_token['accept'] = true;
							}
							$edit_token = comment_create_token($comment_edit_token);
					?>
					<li class="comment_action" data-token="<?=$edit_token;?>">내용 보기</li>
					<? } ?>
					<?
						if(comment_permission_checker('edit',$comment_list['view3_code']) || comment_permission_checker('admin')){
							$active_btn = true;
							unset($comment_edit_token);
							$comment_edit_token = Array();
							$comment_edit_token['mode'] = 'edit';
							$comment_edit_token['option'] = $comment_option;
							$comment_edit_token['idx'] = $comment_list['view3_idx'];
							$comment_edit_token['accept'] = false;
							$comment_edit_token['accept_field'] = 'content';
							if( (($comment_list['view3_code']=='@guest_writer') && comment_writer_checker()) || (isset($view3_session['view3_code']) && ($view3_session['view3_code']==$comment_list['view3_code'])) || comment_permission_checker('admin') ){
								$comment_edit_token['accept'] = true;
							}
							$edit_token = comment_create_token($comment_edit_token);
					?>
					<li class="comment_action" data-token="<?=$edit_token;?>">수정</li>
					<? } ?>
					<?
						if(comment_permission_checker('delete',$comment_list['view3_code']) || comment_permission_checker('admin')){
							$active_btn = true;
							unset($comment_delete_token);
							$comment_delete_token = Array();
							$comment_delete_token['mode'] = 'delete';
							$comment_delete_token['option'] = $comment_option;
							$comment_delete_token['idx'] = $comment_list['view3_idx'];
							$comment_delete_token['accept'] = false;
							if( (($comment_list['view3_code']=='@guest_writer') && comment_writer_checker()) || (isset($view3_session['view3_code']) && ($view3_session['view3_code']==$comment_list['view3_code'])) || comment_permission_checker('admin') ){
								$comment_delete_token['accept'] = true;
							}
							$delete_token = comment_create_token($comment_delete_token);
					?>
					<li class="comment_action" data-confirm="삭제하시겠습니까?" data-token="<?=$delete_token;?>">삭제</li>
					<? } ?>
				</ul>
			</div>
			<? if(isset($active_btn) && ($active_btn==true)){ ?>
			<div class="comment_option_btn">+</div>
			<? } ?>
		</div>
		<div class="comment_content content_type_text">
			<?
			if(comment_permission_checker('view',$comment_list['view3_code']) || comment_permission_checker('admin')){
				if($comment_list['view3_content_type']=='plain'){
					echo nl2br(htmlspecialchars($comment_list['view3_title_01']));
				}else if($comment_list['view3_content_type']=='strict'){
					// attr 및 script 제거
					echo nl2br($comment_list['view3_title_01']);
				}else if($comment_list['view3_content_type']=='free'){
					echo $comment_list['view3_title_01'];
				}else{
					echo nl2br(htmlspecialchars($comment_list['view3_title_01']));
				}
			}else{
?>

			<div class="hidden_content">비공개</div>
<?
			}
			?>
		</div>
	</div>
</li>
<?
}

$list_token = false;
if( ($total_cnt - count($clean_loaded_idx)) > 0 ){
	unset($comment_list_token);
	$comment_list_token = Array();
	$comment_list_token['loaded_idx'] = $clean_loaded_idx;
	$comment_list_token['option'] = $comment_option;
	$comment_list_token['show_count'] = $parse_contents['option']['show_count'];//불러올 개수
	$list_token = comment_create_token($comment_list_token);
}
if($comment_option['list_type']=='replace'){//page방식
	$comment_list_token = Array();
	$comment_list_token['option'] = $comment_option;
	$comment_list_token['show_count'] = $parse_contents['option']['show_count'];//불러올 개수
	$pgOption = Array();
	$pgOption['token']=$comment_list_token;
	$pgOption['type'] = 'A';//출력타입
	$pgOption['total'] = ceil($total_cnt/$parse_contents['option']['show_count']);//전체 페이지
	$pgOption['page'] = $page;//현재 페이지
	$pgOption['print'] = 5;//페이지 나눌 갯수
	$pgHTML = pgGen($pgOption);
?>
	<li>
		<div>
			<?=$pgHTML;?>
		</div>
	</li>
<?
}else{//more방식
	if($list_token != false){
		$comment_list_token = Array();
		$comment_list_token['loaded_idx'] = $clean_loaded_idx;
		$comment_list_token['option'] = $comment_option;
		$comment_list_token['show_count'] = $parse_contents['option']['show_count'];//불러올 개수
		$list_token = comment_create_token($comment_list_token);
?>
			<li class="comment_more_list" data-token="<?=$list_token;?>">
				<div class="comment_more_page"><?=(floor(count($clean_loaded_idx)/$parse_contents['option']['show_count']));?> / <?=ceil($total_cnt/$parse_contents['option']['show_count']);?></div>
				<a href="#" class="comment_more_list">더보기</span></a>
				<br />
				<span class="comment_more_cursor">∨</span>
			</li>
<?
	}
}
?>