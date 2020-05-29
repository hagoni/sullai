<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
if(!defined('_VIEW3BOARD_'))exit;
######################################################################################################################################################
######################################################################################################################################################
$sql = $main_sql.$view_order;
$out_sql = mysql_query($sql);
$list = mysql_fetch_assoc($out_sql);
view3_hit($view3_table, $list['view3_idx']);
######################################################################################################################################################
// 이전글 다음글
######################################################################################################################################################
$sort = view3_prev_next($view3_table,$view3_idx);
$path_prev = view3_link("||idx","view&idx=".$temp_prev,"",$end_path);
$path_next = view3_link("||idx","view&idx=".$temp_next,"",$end_path);
######################################################################################################################################################
$_SESSION['idx'] = $view3_idx;
$option = view3_option(array($list['view3_file'],$list['view3_file_old'],$board),$list['view3_write_day'],$list['view3_notice'],$list['view3_main'],array($list["view3_code"],$list['view3_name']),array($list['view3_open'],$list['view3_close']));
$next_command_01 = view3_html($list['view3_command_01']);
?>

<!-- board wrapper start -->
<div id="boardWrap">

    <!-- <ul class="tabmenu fs_def">
		<li<?if($view3_tab == '' || $view3_tab == '1'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=1");?>">진행 중 이벤트</a></li>
		<li<?if($view3_tab == '2'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=2");?>">완료된 이벤트</a></li>
		<li<?if($view3_tab == '3'){echo ' class="on"';}?>><a href="<?=URL_PATH.'?'.get("page||type||tab||idx","tab=3");?>">전체 이벤트</a></li>
	</ul> -->
    <div class="board_inner">


        <div class="board_view_head">
            <p class="board_view_title b_fs_xl b_ff_h b_c_h ellipsis"><?=$option['notice']?><?=$list['view3_title_01']?></p>
            <ul class="board_view_sns">
                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-fb-share-btn"><img src="../img/board/sns_ico01.png" alt="페이스북 아이콘" /></a></li>
                <li><a href="http://blog.naver.com/openapi/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-bl-share-btn"><img src="../img/board/sns_ico02.png" alt="네이버 블로그 아이콘" /></a></li>
                <li><a href="https://story.kakao.com/share?url=<?=urlencode('http://'.$_SERVER[SERVER_NAME].$_SERVER[REQUEST_URI]);?>" class="social-ks-share-btn"><img src="../img/board/sns_ico03.png" alt="카카오스토리 아이콘" /></a></li>
            </ul>
        </div>

        <div class="board_view_body">
    		<? if($list['view3_link']!=''){ ?>
    		<div class="videoView">
    			<div class="videoRatioFix"></div>
    			<? if($list['view3_video']=='Vimeo'){ ?>
    			<iframe class="videoFrame" src="https://player.vimeo.com/video/<?=$list['view3_link'];?>?autoplay=true" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    			<? } ?>
    			<? if($list['view3_video']=='YouTube'){ ?>
    			<iframe class="videoFrame" src="http://www.youtube.com/embed/<?=$list['view3_link'];?>?autoplay=1&amp;rel=0&amp;vq=hd720" width="100%" height="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    			<? } ?>
    		</div>
    		<? } ?>
    <?
    if($option['user_down'] || $option['user_view']) {
    ?>
            <div class="board_view_file">
    <?
        echo $option['user_down'];
        echo $option['user_view'];
    ?>
            </div>
    <?
    }
    ?>
            <div class="board_view_text b_fs_m b_lh_l b_c_m"><?=$next_command_01?></div>
        </div>

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
    		$comment_option['show_count'] = '10';//한 번에 불러올 개수
    		$comment_option['permission']['admin'] = '90~100';//관리 권한
    		$comment_option['permission']['write'] = '90~100';//쓰기권한
    		$comment_option['permission']['edit'] = '90~100';//수정권한
    		$comment_option['permission']['delete'] = '90~100';//삭제권한
    		$comment_option['permission']['list'] = 'guest||writer||90~100';//목록 보기권한
    		$comment_option['permission']['view'] = 'writer||90~100';//내용 보기권한
    		$comment_option['permission']['upload'] = 'writer||90~100';//업로드권한
    		$comment_option['post']['board'] = $board;//게시글 게시판 table명
    		$comment_option['post']['idx'] = $list['view3_idx'];//게시글 idx
    		$comment_option['post']['name'] = $list['view3_name'];//게시글 작성자 이름
    		$comment_option['post']['code'] = $list['view3_code'];//게시글 view3_code
    		$comment_option['post']['pw'] = $list['view3_pw'];//게시글 pw
    		$comment_option['check']['pw'] = $pw_md5;//인증한 비밀번호(md5?)
    		$comment_option['editor_mode'] = 'plain';//에디터 옵션 == plain(Default) : textarea형식,editor : 에디터 활성화(content_mode 가 strict 일때 php5 미만 에서는 plain모드)
    		$comment_option['content_type'] = 'plain';//Content 옵션 == plain(Default) : PlainText, strict : tag명만 허용 및 script tag사용 불가(php5이상만! PHP5미만에서는 plain 모드),free : 모든 태그 허용
    		$comment_option['special_form'] = Array();
    		$comment_option['set_comment'] = $list['view3_special_01'];

    		if($list['view3_check_01']=='1')$comment_option['permission']['write'] .= '||guest';
    		if($list['view3_check_02']=='1')$comment_option['permission']['edit'] .= '||guest';
    		if($list['view3_check_03']=='1')$comment_option['permission']['delete'] .= '||guest';
    		if($list['view3_check_04']=='1')$comment_option['permission']['upload'] .= '||guest';
    		if($list['view3_check_05']=='1')$comment_option['permission']['view'] .= '||guest';
    		if($list['view3_check_06']=='1')$comment_option['secret_form']['tel'] = '연락처';
    		if($list['view3_check_07']=='1')$comment_option['secret_form']['email'] = '이메일';
    		if($list['view3_check_08']=='1')$comment_option['secret_form']['addr'] = '주소';

    		@include_once ROOT_INC.$comment_root.'/loader.php';

    ?>
    		</div>
    <?
    ######################################################################################################################################################
    include_once(BOARD_INC.'/setup_bottom.php');
    ######################################################################################################################################################
    ?>
    </div>
</div>
<!-- //board wrapper end -->
