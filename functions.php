<?php

function executeSql($sqlFileToExecute)
{
    $sqlErrorCode = "";
    $f = fopen($sqlFileToExecute,"r+");
    $sqlFile = fread($f, filesize($sqlFileToExecute));
    $sqlArray = explode(';',$sqlFile);
    foreach ($sqlArray as $stmt) {
        if (strlen($stmt)>3 && substr(ltrim($stmt),0,2)!='/*') {
            $result = mysql_query($stmt);
            if (!$result) {
                $sqlErrorCode = mysql_errno();
                $sqlErrorText = mysql_error();
                $sqlStmt = $stmt;
                break;
            }
        }
    }
    if ($sqlErrorCode == 0) {
        return "Script is executed succesfully!";
    } else {
        return "An error occured during installation!<br/>"
        . "Error code: $sqlErrorCode<br/>"
        . "Error text: $sqlErrorText<br/>"
        . "Statement:<br/> $sqlStmt<br/>";
    }
}
function filter($data) {
	$data = trim(htmlentities(strip_tags($data)));
	
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	
	$data = mysql_real_escape_string($data);
	
	return $data;
}

function checkPwd($x,$y) 
{
if(empty($x) || empty($y) ) { return false; }
if (strlen($x) < 4 || strlen($y) < 4) { return false; }

if (strcmp($x,$y) != 0) {
 return false;
 } 
return true;
}

function VisitorIP()
    { 
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else $TheIp=$_SERVER['REMOTE_ADDR'];
 
    return trim($TheIp);
    }

function isEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function isUserID($username)
{
	if (preg_match('/^[a-z\d_]{3,20}$/i', $username)) {
		return true;
	} else {
		return false;
	}
 }
function isUserNume($nume)
{
	if (preg_match('/^[a-zA-Z]$/i', $nume)) {
		return true;
	} else {
		return false;
	}
 }
function is_404($url) {
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($handle);

    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    curl_close($handle);

    if ($httpCode >= 200 && $httpCode < 300) {
        return false;
    } else {
        return true;
    }
}
function truncate($str, $length, $trailing='...')
      {
            $length-=mb_strlen($trailing);
            if (mb_strlen($str)> $length)
            {
               return mb_substr($str,0,$length).$trailing;
            }
            else
            {
               $res = $str;
            }

            return $res;
      } 
function get_data($url)
{
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}
 
function percent($num_amount, $num_total) {
    $count1 = $num_amount / $num_total;
    $count2 = $count1 * 100;
    $count = number_format($count2, 0);
    echo $count;
}
?>