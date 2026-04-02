<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("select orga.organo_id,orga.organo_name,orga.desig,orga.parent_id,orga_par.organo_name as parent_name, concat(wu.user_name,' [',date_format(orga.entry_date,'%d/%m/%Y'),' ]')as cName from organogram orga 
INNER JOIN web_users wu on wu.user_id=orga.entry_by
LEFT JOIN organogram orga_par on orga_par.organo_id=orga.parent_id where orga.status='Active' order by orga.organo_id $LimitQry",1);
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
				
                $data[] = array(++$sNo,
                    html_entity_decode($row['organo_name']),
                    html_entity_decode($row['desig']), 
					html_entity_decode($row['parent_name']),		
                    $row['cName'],                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-organo_id='$row[organo_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-organo_id='$row[organo_id]' title='Delete Organogram'></i>
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
    break;
    
}

$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);