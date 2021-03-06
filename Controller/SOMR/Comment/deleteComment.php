<?php
/**
 * @Controller 코멘트 삭제
 *
 * @subpackage   	Core/DBmanager/DBmanager
 * @subpackage   	BBS/Comment
 */
require_once ('Model/Core/DBmanager/DBmanager.php');
require_once ('Model/BBS/Comment.php');

/**
 * Variable 세팅
 * @var 	$intBBSSeq		post 시컨즈
 * @var 	$intPostSeq		BBS 시컨즈
 * @var 	$intCommentSeq	코멘트 시컨즈
 */
$intBBSSeq = $_POST['bbs_seq'];
$intPostSeq = $_POST['post_seq'];
$intCommentSeq = $_POST['comment_seq'];

/**
 * Object 생성
 * @property	resource 		$resMangongDB 	: DB 커넥션 리소스
 * @property	object			$objComment  				: PostComment 객체
 */
$resMangongDB = new DB_manager('MAIN_SERVER');
$objComment = new PostComment();

 /**
 * Main Process
 */
$arr_input = array(
		'cmt_id'=>$intCommentSeq,
		'post_seq'=>$intPostSeq,
		'bbs_seq'=>$intBBSSeq
);
$boolResult = $objComment->deletePostComment($resMangongDB,$arr_input);

/**
 * View OutPut Data 세팅 
 * OutPut Type Json
 * 
 * @property	boolean 		$boolResult 			: 코멘트 삭제 결과 성공 여부
 */
$arr_output['result'] = array('result'=>$boolResult);
echo json_encode($arr_output['result']);
?>