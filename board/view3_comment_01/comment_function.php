<?
if(!isset($_SESSION)){
	session_start();
}
if(isset($_SESSION["code"]) && ($_SESSION["code"]!='') && !isset($view3_session)){
	$view3_code_sql = "select * from ".TABLE_LEFT."member where view3_code='".$_SESSION["code"]."'";
	$out_view3_code_sql =                                           @mysql_query($view3_code_sql);
	$view3_session                                                = @mysql_fetch_assoc($out_view3_code_sql);
}
if(!function_exists('comment_permission_checker')){
	function comment_permission_checker($mode,$post_code){
		GLOBAL $view3_session, $comment_option;
		/*
		$accept_mode = Array('admin','write','edit','delete','upload');
		if(!in_array($mode, $accept_mode)){
			return false;
		}
		*/
		if(!isset($comment_option['permission'][$mode])){
			return false;
		}
		$opt = $comment_option['permission'][$mode];
		$opt_split = array_filter(explode('||',$opt));
		if( count($opt_split) < 1 ){
			return false;
		}
		foreach($opt_split as $per_opt){
			if($per_opt=='guest'){
				//if( (!isset($view3_session['view3_code']) || (trim($view3_session['view3_code'])=="")) && in_array($post_code,Array('@guest','@guest_writer')) ){
				if( !isset($view3_session['view3_code']) || (trim($view3_session['view3_code'])=="")  ){
					return true;
				}
			}
			if($per_opt=='member'){
				if($mode=='edit'){
					if( isset($view3_session['view3_code']) && (trim($view3_session['view3_code'])!="") ){
						if( trim($view3_session['view3_code'])==trim($comment_option['post']['code'])){
							return true;
						}
					}
					return false;
				}
				if( isset($view3_session['view3_code']) && (trim($view3_session['view3_code'])!="") ){
					return true;
				}
			}
			if($per_opt=='writer'){
				if(($mode=='edit') || ($mode=='delete') ){
					if( ($post_code=='@guest_writer') && comment_writer_checker()){
						return true;
					}else if( $post_code=='@guest' ){
						return true;
					}else if( isset($view3_session['view3_code']) && ($view3_session['view3_code']==$post_code) ){
						return true;
					}else{
						return false;
					}
				}
				if( isset($view3_session['view3_code']) && (trim($view3_session['view3_code'])!="") ){
					if( trim($view3_session['view3_code'])==trim($comment_option['post']['code'])){
						return true;
					}
				}
				if( isset($comment_option['post']['pw']) && (trim($comment_option['post']['pw'])!="") ){
					if( trim($comment_option['post']['pw'])==trim($comment_option['check']['pw'])){
						return true;
					}
				}
			}
			if(is_int($per_opt)){
				if( isset($view3_session['view3_level']) && (trim($view3_session['view3_level'])!="") ){
					if( $per_opt == (int)$view3_session['view3_level']){
						return true;
					}
				}
			}
			if(strpos($per_opt, '~') !== false){
				if( isset($view3_session['view3_level']) && (trim($view3_session['view3_level'])!="") ){
					$level_split = explode('~', $per_opt);
					if(  (int)$level_split[0] < (int)$level_split[1] ){
						$s_level = (int)$level_split[0];
						$e_level = (int)$level_split[1];
					}else{
						$s_level = (int)$level_split[1];
						$e_level = (int)$level_split[0];
					}
					if( ($s_level <  (int)$view3_session['view3_level']) && ($e_level >= (int)$view3_session['view3_level']) ){
						return true;
					}
				}
			}
		}
		return false;
	}
}
if(!function_exists('comment_writer_checker')){
	function comment_writer_checker(){
		GLOBAL $view3_session, $comment_option;
		if(isset($view3_session['view3_code']) && ($view3_session['view3_code']!='') && ($view3_session['view3_code']==$comment_option['post']['code'])){
			return true;
		}
		if(isset($comment_option['post']['pw']) && isset($comment_option['check']['pw']) && ($comment_option['post']['pw']!='') && ($comment_option['post']['pw']==$comment_option['check']['pw'])){
			return true;
		}
		return false;
	}
}
if(!function_exists('comment_create_token')){
	function comment_create_token($token_val){
		if(isset($_SESSION)){
			$token = uniqid(mt_rand());
			$_SESSION['comment_token'][$token] = $token_val;
			return $token;
		}
		/*세션 못쓸 때 사용됨*/
		$token_seed = md5(date('Y_m_d',time()-(60*60*23)).$_SERVER['REMOTE_ADDR'].'VNU#895trsyheo#(t');
		$token_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
		$token_hash_bin = mcrypt_encrypt(MCRYPT_3DES,$token_seed,serialize($token_val),MCRYPT_MODE_ECB,$token_vector_iv);
		$token_hash = base64_encode($token_hash_bin);
		return $token_hash;
	}
}
if(!function_exists('comment_decrypt_token')){
	function comment_decrypt_token($token_date, $token_val){
		/*세션 못쓸 때 사용됨*/
		$token_seed = md5(date('Y_m_d',$token_date).$_SERVER['REMOTE_ADDR'].'VNU#895trsyheo#(t');
		$token_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
		$token = base64_decode($token_val);
		$token_parse = unserialize(mcrypt_decrypt(MCRYPT_3DES, $token_seed, $token, MCRYPT_MODE_ECB, $token_vector_iv));
		return $token_parse;
	}
}
if(!function_exists('comment_parse_token')){
	function comment_parse_token($token){
		if(isset($_SESSION['comment_token'][$token])){
			$return_session = $_SESSION['comment_token'][$token];
			//unset($_SESSION['comment_token'][$token]);
			return $return_session;
		}
		$token_parse = comment_decrypt_token(time(),$token);
		if($token_parse!==false){
			return $token_parse;
		}
		unset($token_parse);
		$token_parse = comment_decrypt_token(time()-(60*60*23),$token);
		if($token_parse!==false){
			return $token_parse;
		}
		return false;
	}
}
if(!function_exists('safe_query_val')){
	function safe_query_val($val){
		if(get_magic_quotes_gpc())$val = stripslashes($val);
		if(!is_numeric($val))$val = "'".mysql_real_escape_string($val)."'";
		return $val;
	}
}

if(!function_exists('pgGen')){
	function pgGen($option){
		ob_start();
		$html = '';
		$prevPage = false;//이전 페이지 주소
		$nextPage = false;//다음 페이지 주소
		$virtualPage = 1;//가상 페이지 번호
		$startPage = 1;//시작 페이지
		$endPage = 1;//마지막 페이지
		$total = 0;//전체 페이지 개수
		$page = 1;//현재 페이지
		$print = 10;//노출될 개수

		if(isset($option['total']) && ((int)$option['total'] > 0)) $total = (int)$option['total'];
		if(isset($option['page']) && ((int)$option['page'] > 0)) $page = (int)$option['page'];
		if(isset($option['print']) && ((int)$option['print'] > 0)) $print = (int)$option['print'];
		if(isset($option['url']))$url=$option['url'];
		if($page > $total) $page = 1;//없는 번호면 1번으로


		if($total > 0){
			$virtualPage = ceil($page/$print);//가상 페이지 번호
			if( $virtualPage > 1 ) $prevPage = true;//이전 페이지
			if( $virtualPage < ceil($total/$print) ) $nextPage = true;//다음 페이지
			$startPage = (($virtualPage-1)*$print)+1;//시작 페이지
			$endpage = ($startPage+$print-1 <= $total) ? $startPage+$print-1 : $total;//마지막 페이지
			if($option['type'] == 'A'){
?>
				<div class="paging">

				<? if( $prevPage == true ){ ?>
				<?
					$option['token']['show_page'] = $startPage-1;
					$list_token = comment_create_token($option['token']);
				?>
					<a href="#none" class="paging_prev more_comment" data-token="<?=$list_token?>" data-page="<?=$option['token']['show_page'];?>"></a>
				<? } ?>

					<ul class="paging_ul fs_def">
					<? for($i=$startPage;$i<=$endpage;$i++){ ?>
						<li class="on">
						<? if($i==$page){ ?>
						<span><?=$i;?></span>
						<? }else{ ?>
						<?
							$option['token']['show_page'] = $i;
							$list_token = comment_create_token($option['token']);
						?>
						<a href="#none" class="more_comment" data-token="<?=$list_token?>" data-page="<?=$option['token']['show_page'];?>"><?=$i;?></a>
						<? } ?>
						</li>
					<? } ?>

					</ul>

				<? if( $nextPage == true ){ ?>
				<?
					$option['token']['show_page'] = $endpage+1;
					$list_token = comment_create_token($option['token']);
				?>
					<a href="#none" class="paging_next more_comment" data-token="<?=$list_token;?>" data-page="<?=$option['token']['show_page'];?>"></a>
				<? } ?>

				</div>
<?
			}
		}
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
}
