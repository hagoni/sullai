<?
######################################################################################################################################################
//VIEW3 BOARD 1.0
######################################################################################################################################################
define('_VIEW3BOARD_', TRUE);
@include_once														"../../view3.php";
######################################################################################################################################################
$_SESSION['data'] = Array();
foreach($_FILES as $key => $val) {
    $_SESSION['data'][$key] = $val;
}
foreach($_POST as $key => $val) {
    $_SESSION['data'][$key] = $val;
}
print_r($_SESSION);
?>