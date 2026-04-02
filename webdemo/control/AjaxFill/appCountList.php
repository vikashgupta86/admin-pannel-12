<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

// $LimitQry=$sspObj->limit($_GET);

$rs=$obj->simplefetch("select * from app_count where status ='Active'",1);
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';  
    
    foreach($rs[1] as $row){                

        $n_grp='';
        $rs10 = $obj->simplefetch("select years as yn from years where year_id = $row[year_id] and status='Active'",1);
        foreach($rs10[1] as $row10){
            // echo $row10['group_name'];
            $n_grp .= $row10['yn'].', ';

        } 
        
        

        $data[] = array(++$sNo,
            $row10['yn'], 
            $row['app_count'],
             
            // $n_grp,              
            "<div class=\"text-center tools\">
                <i class=\"fa fa-edit\" data-toggle=\"tooltip\" id='edit' cdata-frmT='9' data-app_count_id='$row[app_count_id]' title='Edit'></i>
                <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-app_count_id='$row[app_count_id]' title='Delete'></i>
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