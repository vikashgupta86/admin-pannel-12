<?php require_once("conf/config.inc");
$SetPath.=$SuperPath;/*it is required to set the file and directory path as per requird*/
include_once($SetPath.'include/include.inc');

$obj->userAuthenticationPageLevel();
$obj->userAuthenticationMainLevel();
$timeStamp="%Y/%m/%d %H:%M:%S";
$Ip=$_SERVER['REMOTE_ADDR'];

    $rs=$obj->simplefetch("select max(id) from loginoroffusertrail where userid=$_SESSION[userid]");
 	if(($rs[0])>0){
		foreach ($rs[1] as $row){
		  $dated=strftime($timeStamp);
          $obj->simplefetch("update loginoroffusertrail set dateoflogoff='$dated' where id=$row[0]");
		}
	}
    
    session_destroy();
    $obj->headers("login",null);
?>