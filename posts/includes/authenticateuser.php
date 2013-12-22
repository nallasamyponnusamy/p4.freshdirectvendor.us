<?php
// Check referer
$referer = $_SERVER['HTTP_REFERER'];
$domain = parse_url($referer);

// Makes sure user is coming in from the Intranet
//if ($domain['host'] == "localhost")
//{
//	if (empty($usr))
//	{
//		die ("<center><h3>You do not have access to this page. Please contact the Plant Operations Department.</h3></center>");
//	} else
//	{
// specify DB name
$dbName = "freshdir_p4_freshdirectvendor_us";

// include DB connection settings
require_once "config.php";
require_once "class.mysql.php";
$db = new mysql();

$sqlAuthentication = 'SELECT AuthUserID AS AuthUserID
							, isAdmin AS isAdmin
							FROM AuthUsers
							WHERE MD5(Username) = "' . $usr . '"
							AND isActive = 1';

$sqlAuthenticationResults = $db->query($sqlAuthentication);

// check if row is returned, if yes error, if no get values
if ($db->numRows($sqlAuthenticationResults) == 0) {
    //die ('<center><h3>You do not have access to this page. Please contact the Food Safety Department</h3></center>');
    $AuthUserID = md5(999999);
    $isAdmin = 0;
} else {
    $rowAuthenticationResults = $db->fetch($sqlAuthenticationResults);

    $AuthUserID = md5($rowAuthenticationResults['AuthUserID']);
    $isAdmin = 1;
}
//	}
//} else
//{
//	die('<center><h2>*** THIS PAGE CAN ONLY BE ACCESSED USING THE FRESHDIRECT INTRANET PORTAL ***</h2><center>');
//}
?>