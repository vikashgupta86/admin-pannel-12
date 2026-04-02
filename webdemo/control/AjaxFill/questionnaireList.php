<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
        

$rs=$obj->simplefetch("select * from subsector_quest where status ='Active'",1);
if($rs[0]>0){
    
    foreach($rs[1] as $row){                
        
        $rs1=$obj->simplefetch("select * from neca_sectors where sector_id=$row[sector_id] and status ='Active'",1);
        foreach($rs1[1] as $row1);              
        $rs2=$obj->simplefetch("select * from neca_subsectors where subsector_id=$row[subsector_id] and status ='Active'",1);
        foreach($rs2[1] as $row2);              

        $data[] = array(++$sNo,
            $row1['sector_name'], 
            $row2['subsector_name'], 
            '<a href="../WriteReadData/Paint/'.$row["quest_file"].'" target="_blank" class="fa fa-file-text-o" data-toggle="tooltip" id="view" cdata-frmt="9" data-comp_notice_id="" title="" data-original-title="View"></a>', 
            "<div class=\"text-center tools\">
                <i class=\"fa fa-edit\" data-toggle=\"tooltip\" id='edit' cdata-frmT='9' data-subsector_quest_id='$row[subsector_quest_id]' title='Edit'></i>
                <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\" id='delete' cdata-frmT='3' data-subsector_quest_id='$row[subsector_quest_id]' title='Delete'></i>
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