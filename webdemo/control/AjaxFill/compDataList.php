<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

// $LimitQry=$sspObj->limit($_GET);

$rs=$obj->simplefetch("select * from comp_data where status ='Active'",1);
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';  
    
    foreach($rs[1] as $row){                

        $n_grp='';
        $rs10 = $obj->simplefetch("select years as yn from years where year_id = $row[year] and status='Active'",1);
        foreach($rs10[1] as $row10){
            // echo $row10['group_name'];
            $n_grp .= $row10['yn'].', ';

        } 
        
        $n_grp1='';
        $rs11 = $obj->simplefetch("select sector_name as sec from neca_sectors where sector_id = $row[sector_id] and status='Active'",1);
        foreach($rs11[1] as $row11){
            // echo $row10['group_name'];
            $n_grp1 .= $row11['sec'].', ';

        } 
        
               
        $n_grp2='';
        $rs12 = $obj->simplefetch("select subsector_name as subsec from neca_subsectors where subsector_id = $row[subsector_id] and status='Active'",1);
        foreach($rs12[1] as $row12){
            // echo $row10['group_name'];
            $n_grp2 .= $row12['subsec'].', ';

        } 

        $data[] = array(++$sNo,
            $row10['yn'], 
            $row11['sec'],
            $row12['subsec'], 
            $row['first'],
            $row['second'],
            $row['cert_merit'],
             
            // $n_grp,              
            "<div class=\"text-center tools\">
                <i class=\"fa fa-edit\" data-toggle=\"tooltip\" id='edit' cdata-frmT='9' data-comp_data_id='$row[comp_data_id]' title='Edit'></i>
                <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-comp_data_id='$row[comp_data_id]' title='Delete'></i>
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