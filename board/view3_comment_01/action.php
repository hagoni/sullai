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
function commentAjaxResult($result){
	echo json_encode($result);
	exit;
}
function go_to_post($msg){
	if(isset($msg)){
		echo '<script type="text/javascript">alert(\''.str_replace("'","\\'",$msg).'\');</script>';
	}
	echo '<script type="text/javascript">window.location.replace("'.$_SERVER["HTTP_REFERER"].'");</script>';
	exit;
}
$parse_contents = comment_parse_token($_GET['token']);
$token = $_GET['token'];
$comment_option = $parse_contents['option'];
if($parse_contents == false){
	go_to_post('token시간이 만료되었습니다. 다시 시도해주세요.');
}
$special_data = NULL;
if(isset($_POST['tel']) && trim($_POST['tel'])!='')$special_data['tel']=$_POST['tel'];
if(isset($_POST['email']) && trim($_POST['email'])!='')$special_data['email']=$_POST['email'];
if(isset($_POST['addr']) && trim($_POST['addr'])!='')$special_data['addr']=$_POST['addr'];

if($parse_contents['mode']=='write'){
	$insert_sql = sprintf("
		INSERT INTO `".TABLE_LEFT."comment` SET 
		`view3_code`=%s,
		`view3_name`=%s,
		`view3_pw`=md5(%s),
		`view3_board_name`=%s,
		`view3_board_idx`=%s,
		`view3_content_type`=%s,
		`view3_title_01`=%s,
		`view3_special_01`=%s,
		`view3_write_day`='".date('Y-m-d H:i:s',time())."',
		`view3_ip`='".$_SERVER['REMOTE_ADDR']."';",
			safe_query_val($parse_contents['writer_code']),//`view3_code`
			safe_query_val($_POST['name']),//`view3_name`
			safe_query_val($_POST['pw']),//`view3_pw`
			safe_query_val($comment_option['post']['board']),//`view3_board_name`
			safe_query_val($comment_option['post']['idx']),//`view3_board_idx`
			safe_query_val($comment_option['content_type']),//`view3_content_type`
			safe_query_val($_POST['content']),//`view3_command_01`
			safe_query_val(serialize($special_data))//`view3_special_01`
	);
	if(!mysql_query($insert_sql)){
		go_to_post('등록 실패');
	}else{
		go_to_post('등록 완료');
	}
}
if($parse_contents['mode']=='view'){
	$comment_idx = $_SESSION['comment_token'][$token]['idx'];
	$comment_sql = 'SELECT * FROM `'.TABLE_LEFT.'comment` WHERE `view3_idx`="'.$comment_idx.'";';
	$comment_query = mysql_query($comment_sql);
	if(!$comment_query || (mysql_num_rows($comment_query)<1)){
		commentAjaxResult(Array('action'=>'msg','result'=>'false','msg'=>'삭제된 게시글 입니다'));//echo '삭제된 게시글 입니다||';exit;
	}
	$comment_data = mysql_fetch_assoc($comment_query);
	if(isset($_POST['content'])){
		if( !isset($parse_contents['accept']) || ($parse_contents['accept']!=true)){
			commentAjaxResult(Array('action'=>'msg','result'=>'false','msg'=>'권한이 없는 요청 입니다'));//echo '권한이 없는 요청 입니다||';exit;
		}
		$update_sql = sprintf("
			UPDATE `".TABLE_LEFT."comment` SET 
			`view3_title_01`=%s,
			`view3_edit_day`='".date('Y-m-d H:i:s',time())."',
			`view3_ip`='".$_SERVER['REMOTE_ADDR']."'
			WHERE `view3_idx`=%s;",
				safe_query_val($_POST['content']),//`view3_title_01`
				safe_query_val(serialize($special_data)),//`view3_special_01`
				safe_query_val($comment_idx)//`view3_board_idx`
		);
		if(mysql_query($update_sql)){
			if($comment_data['view3_content_type']=='plain'){
				$comment_html =  nl2br(htmlspecialchars($_POST['content']));
			}else if($comment_data['view3_content_type']=='strict'){
				// attr 및 script 제거
				$comment_html =  nl2br($_POST['content']);
			}else if($comment_data['view3_content_type']=='free'){
				$comment_html =  $_POST['content'];
			}else{
				$comment_html =  nl2br(htmlspecialchars($_POST['content']));
			}
			commentAjaxResult(Array('action'=>'edit_result','result'=>'true','comment'=>$comment_html,'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'edit_result||true||'.$comment_html;
		}else{
			commentAjaxResult(Array('action'=>'edit_result','result'=>'false'));//echo 'edit_result||false';
		}
		exit;
	}
	if(isset($_POST['pw'])){
		if(($comment_data['view3_code']=='@guest') && ($comment_data['view3_pw']==md5($_POST['pw']))){
			$_SESSION['comment_token'][$token]['accept']=true;
			commentAjaxResult(Array('action'=>'set_view_mode','result'=>'true','comment'=>$comment_data['view3_title_01'],'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'set_view_mode||'.$comment_data['view3_title_01'];exit;
		}
		commentAjaxResult(Array('action'=>'check_pw','result'=>'false','msg'=>'비밀번호가 일치하지 않습니다'));//echo 'check_pw||비밀번호가 일치하지 않습니다';exit;
		
	}
	if($parse_contents['accept']==true){
		commentAjaxResult(Array('action'=>'set_edit_mode','result'=>'true','comment'=>$comment_data['view3_title_01'],'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'set_edit_mode||'.$comment_data['view3_title_01'];exit;
	}else{
		commentAjaxResult(Array('action'=>'check_pw','result'=>'false','msg'=>''));//echo 'check_pw||';exit;
	}
}

if($parse_contents['mode']=='edit'){
	$comment_idx = $_SESSION['comment_token'][$token]['idx'];
	$comment_sql = 'SELECT * FROM `'.TABLE_LEFT.'comment` WHERE `view3_idx`="'.$comment_idx.'";';
	$comment_query = mysql_query($comment_sql);
	if(!$comment_query || (mysql_num_rows($comment_query)<1)){
		commentAjaxResult(Array('action'=>'msg','result'=>'false','msg'=>'삭제된 게시글 입니다'));//echo '삭제된 게시글 입니다||';exit;
	}
	$comment_data = mysql_fetch_assoc($comment_query);
	if(isset($_POST['content'])){
		if( !isset($parse_contents['accept']) || ($parse_contents['accept']!=true)){
			commentAjaxResult(Array('action'=>'msg','result'=>'false','msg'=>'권한이 없는 요청 입니다'));//echo '권한이 없는 요청 입니다||';exit;
		}
		$update_sql = sprintf("
			UPDATE `".TABLE_LEFT."comment` SET 
			`view3_title_01`=%s,
			`view3_edit_day`='".date('Y-m-d H:i:s',time())."',
			`view3_ip`='".$_SERVER['REMOTE_ADDR']."'
			WHERE `view3_idx`=%s;",
				safe_query_val($_POST['content']),//`view3_board_idx`
				safe_query_val($comment_idx)//`view3_command_01`
		);
		if(mysql_query($update_sql)){
			if($comment_data['view3_content_type']=='plain'){
				$comment_html =  nl2br(htmlspecialchars($_POST['content']));
			}else if($comment_data['view3_content_type']=='strict'){
				// attr 및 script 제거
				$comment_html =  nl2br($_POST['content']);
			}else if($comment_data['view3_content_type']=='free'){
				$comment_html =  $_POST['content'];
			}else{
				$comment_html =  nl2br(htmlspecialchars($_POST['content']));
			}
			commentAjaxResult(Array('action'=>'edit_result','result'=>'true','comment'=>$comment_html,'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'edit_result||true||'.$comment_html;exit;
		}else{
			commentAjaxResult(Array('action'=>'edit_result','result'=>'false','comment'=>$comment_html,'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'edit_result||false';exit;
		}
		exit;
	}
	if(isset($_POST['pw'])){
		if(($comment_data['view3_code']=='@guest') && ($comment_data['view3_pw']==md5($_POST['pw']))){
			$_SESSION['comment_token'][$token]['accept']=true;
			commentAjaxResult(Array('action'=>'set_edit_mode','result'=>'true','comment'=>$comment_data['view3_title_01'],'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'set_edit_mode||'.$comment_data['view3_title_01'];exit;
		}
		commentAjaxResult(Array('action'=>'check_pw','result'=>'false','msg'=>'비밀번호가 일치하지 않습니다'));//echo 'check_pw||비밀번호가 일치하지 않습니다';exit;
		
	}
	if($parse_contents['accept']==true){
		commentAjaxResult(Array('action'=>'set_edit_mode','result'=>'true','comment'=>$comment_data['view3_title_01'],'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'set_edit_mode||'.$comment_data['view3_title_01'];exit;
	}else{
		commentAjaxResult(Array('action'=>'check_pw','result'=>'false','msg'=>''));//echo 'check_pw||';exit;
	}
}


if($parse_contents['mode']=='delete'){
	$comment_idx = $parse_contents['idx'];
	$comment_sql = 'SELECT * FROM `'.TABLE_LEFT.'comment` WHERE `view3_idx`="'.$comment_idx.'";';
	$comment_query = mysql_query($comment_sql);
	if(!$comment_query || (mysql_num_rows($comment_query)<1)){
		commentAjaxResult(Array('action'=>'set_edit_mode','result'=>'false','msg'=>'삭제된 게시글 입니다'));//echo '삭제된 게시글 입니다||';exit;
	}
	$comment_data = mysql_fetch_assoc($comment_query);
	if(isset($_POST['pw']) || ($parse_contents['accept']==true)){
		if( (($comment_data['view3_code']=='@guest') && ($comment_data['view3_pw']==md5($_POST['pw']))) || ($parse_contents['accept']==true)){
			$delete_sql = 'DELETE FROM `'.TABLE_LEFT.'comment` WHERE `view3_idx`="'.$comment_idx.'";';
			if(mysql_query($delete_sql)){
				commentAjaxResult(Array('action'=>'delete_result','result'=>'true','msg'=>'삭제되었습니다'));//echo 'delete_result||true';
			}else{
				commentAjaxResult(Array('action'=>'delete_result','result'=>'false','msg'=>'삭제 실패'));//echo 'delete_result||false';
			}
			exit;
		}
		commentAjaxResult(Array('action'=>'check_pw','result'=>'false','msg'=>'비밀번호가 일치하지 않습니다'));//echo 'check_pw||비밀번호가 일치하지 않습니다';
		exit;
		
	}
	if($parse_contents['accept']==true){
		commentAjaxResult(Array('action'=>'set_edit_mode','result'=>'true','comment'=>$comment_data['view3_title_01'],'secret_data'=>unserialize($comment_data['view3_special_01'])));//echo 'set_edit_mode||'.$comment_data['view3_title_01'];exit;
	}else{
		commentAjaxResult(Array('action'=>'check_pw','result'=>'false','msg'=>''));//echo 'check_pw||';exit;
	}
}