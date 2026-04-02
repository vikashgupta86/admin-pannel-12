<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

// $LimitQry=$sspObj->limit($_GET);

$rs=$obj->simplefetch("select * from school_shortlisted_$_REQUEST[s_year] where school_id=$_REQUEST[school_id] and upload_status=2 and status ='Active'",1);

if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
    foreach($rs[1] as $row){  

        $rs5=$obj->simplefetch("select * from school_groups where group_id=$row[group_id] and status ='Active'",1);
        foreach($rs5[1] as $row5){}

        $data[] = array(++$sNo,
        $row['enr_no'], 
        $row['student_name'], 
        $row['parent_name'], 
        $row['mobile'], 
        $row['class'],
        $row5['group_name'],
            "<div class=\"text-center tools\"> 
                <i class=\"fa fa-eye\" data-toggle=\"tooltip\" aria-hidden=\"true\" id='photo_view' data-photo='$row[photo]' title='View'></i>
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