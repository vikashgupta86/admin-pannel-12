<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

// $LimitQry=$sspObj->limit($_GET);

$rs=$obj->simplefetch("select * from notifications where status ='Active'",1);
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';  
    
    foreach($rs[1] as $row){                

        $rs1=$obj->simplefetch("select years from years where year_id=$row[year_id] and status='Active'");
        foreach($rs1[1] as $row1); 
			$years=$row1['years'];
		//$sect='';
        //$sub_sect='';
		//$rs5 = $obj->simplefetch("select years from years where year_id=$row[year_id] status='Active'",1);
        //foreach($rs5[1] as $row5){
        //    $year .= $row5['years'].', ';
        //}
        //$rs10 = $obj->simplefetch("select sector_name as sn from neca_sectors where sector_id in ($row[sectors]) and status='Active'",1);
        //foreach($rs10[1] as $row10){
        //    $sect .= $row10['sn'].', ';
        //} 
       
        //$rs11 = $obj->simplefetch("select subsector_name as ssn from neca_subsectors where subsector_id in ($row[sub_sectors]) and status='Active'",1);
        //foreach($rs11[1] as $row11){
        //    $sub_sect .= $row11['ssn'].', ';
        //} 

        $data[] = array(++$sNo,
            $years,
			$row['title'],
            //$sect, 
            //$sub_sect, 
            $row['start_date'], 
            $row['end_date'], 
            "<div class=\"text-center tools\">
                <i class=\"fa fa-edit\" data-toggle=\"tooltip\" id='edit' cdata-frmT='9' data-comp_notice_id='$row[notice_id]' title='Edit'></i>
                <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-comp_notice_id='$row[notice_id]' title='Delete'></i>
            </div>",
        );
    }
}

$recordsTotal=$obj->getNameQry("select count(wu.user_id) from web_users wu
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