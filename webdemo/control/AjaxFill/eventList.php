<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

// filter for state user
    $st1=$obj->simplefetch("select wup.state_id from web_users as wu INNER JOIN web_users_profile as wup ON wup.user_id = wu.user_id where wu.user_id=$_SESSION[userid] and wu.status ='Active'",1);
    $state_id = $st1[1][0][0];
    $st_q = "and state_id=$state_id";



$rs=$obj->simplefetch("select * from events where status ='Active' $st_q",1);
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';  
    
    foreach($rs[1] as $row){                
        $data[] = array(++$sNo,
            $row['name'], 
            $row['venue'], 
            $row['start_date'], 
            $row['end_date'], 
            $row['details'], 
            "<div class=\"text-center tools\">
                <i class=\"fa fa-upload\" data-toggle=\"tooltip\" id='upload' cdata-frmT='10' data-event_id='$row[event_id]' title='upload'></i>
            </div>",
            "<div class=\"text-center tools\">
                <i class=\"fa fa-edit\" data-toggle=\"tooltip\" id='edit' cdata-frmT='9' data-event_id='$row[event_id]' title='Edit'></i>
                <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-event_id='$row[event_id]' title='Delete'></i>
            </div>",
        );
    }
}

$recordsTotal=$obj->getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");
$recordsFiltered=$obj->getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");


$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);