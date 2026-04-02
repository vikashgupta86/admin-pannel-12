<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$usr_session='';
if($_SESSION['user_type'] =='20'){

     $usr_session= " AND (pc.entry_by='".$_SESSION['userid']."')";
}
//$usr_session= " and (pc.entry_by='".$_SESSION['userid']."' || pc.nmnh_type='".$_SESSION['musume_type']."')";


    $rs=simplefetch("SELECT pc.*,concat(wu.user_name,' [',date_format(pc.entry_date,'%d/%m/%Y'),' ]') as cName FROM web_events pc INNER JOIN web_users wu ON wu.user_id = pc.entry_by WHERE pc.status='Active' $usr_session ORDER BY pc.event_id DESC $LimitQry");
    if($rs[0]>0){
        $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
        foreach($rs[1] as $row){
            
            $data[] = array(++$sNo,
                html_entity_decode($row['event_name']),
                $row['event_start_date'],
                $row['event_end_date'],
                html_entity_decode($row['event_desc']), 
                $row['cName'],
                "<div class=\"text-center tools\">
                    <i class=\"fa fa-edit\" cdata-frmT='2' data-event_id='$row[event_id]' title='Modify Details'></i>
                    <i class=\"fa fa-trash-o\" cdata-frmT='3' data-event_id='$row[event_id]' title='Delete Category'></i>
                </div>",
            );
        }
    }
    
    $recordsTotal = getNameQry("SELECT count(wu.user_id)  FROM web_users wu
    INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
        where wu.status='Active' and wu.user_id!=1");
    $recordsFiltered = getNameQry("SELECT count(wu.user_id) FROM web_users wu
    INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
        where wu.status='Active' and wu.user_id!=1");



$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);