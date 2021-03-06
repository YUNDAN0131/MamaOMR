<?
/**
 * @Controller single 문제 저장
 *
 * @subpackage   	Core/DBmanager/DBmanager
 * @package      	Mangong/Test
 * @package      	Mangong/MQuestion
 */
require_once("Model/Core/DBmanager/DBmanager.php");
require_once('Model/ManGong/Test.php');
require_once('Model/ManGong/MQuestion.php');

/**
 * Variable 세팅
 * @var 	$intMemberSeq	유저 시컨즈
 * @var 	$intTestSeq		테스트 시컨즈
 * @var 	$intOrderNumber		문제번호
 * @var 	$intQuestionScore		문제 점수
 * @var 	$intQuestionType		문제 타입
 * @var 	$intExampleType		예제 타입
 */  
$intMemberSeq = $_SESSION[$_COOKIE['member_token']]['member_seq'];
$intTestSeq = $_POST['test_seq'];
$intOrderNumber = $_POST['order_number']+1;
$intQuestionScore = $_POST['question_score'];
$intQuestionType = $_POST['question_type'];
$intExampleType = 1;

/**
 * Object 생성
 * @property	resource 		$resMangongDB 	: DB 커넥션 리소스
 * @property	object			$objTest  				: Test 객체
 * @property	object 		$objQuestion 					: MQuestion 객체
 */
$resMangongDB = new DB_manager('MAIN_SERVER');
$objTest = new Test($resMangongDB);
$objQuestion = new MQuestion($resMangongDB);

/**
 * Main Process
 */
include(CONTROLLER_NAME."/Auth/checkAuth.php");
//check auth
if($intAuthFlg!=AUTH_TRUE){
	header("HTTP/1.1 301 Moved Permanently");
	header('location:/');
	exit;
}
$intQuestionSeq = null;
$boolResult = $objQuestion->setQuestion($intMemberSeq, '', $intQuestionType, $intExampleType, null, null, null,$intQuestionSeq);
$boolResult = $objQuestion->setQuestionToTests($intTestSeq, $intQuestionSeq, $intQuestoinNumber ,$intQuestionScore,$intOrderNumber);
$boolResult = $objQuestion->setQuestionExampleAll($intQuestionSeq,'',$intAnswerFlg=0,$intExampleType,null);

/**
 * View OutPut Data 세팅
 * OutPut Type Json
 * @property	boolean 		$boolResult 			: 문제 저장 성공 여부 확인
 * @property	integer 			$intTestSeq 			: 테스트 시컨즈
 * @property	integer 			$intQuestionSeq 	: 문제 시컨즈
 * @property	integer 			$intOrderNumber 	: 문제 번호
 */
$arrResult = array(
		'boolResult'=>$boolResult,
		'test_seq'=>$intTestSeq,
		'question_seq'=>$intQuestionSeq,
		'order_number'=>$intOrderNumber
);
echo json_encode($arrResult);
?>