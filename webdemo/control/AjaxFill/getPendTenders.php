<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$rs = simplefetch("select tt.t_id,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,tt.t_temp_id,tt.tender_name,concat(wu.user_name,' [',date_format(tt.creation_date,'%d/%m/%Y'),' ]')as cName from web_tender_temp tt
INNER JOIN web_users wu on wu.user_id=tt.creator_id
LEFT JOIN (select tr.t_temp_id,tr.revive_by,tr.revive_on,tr.revive_details,ru.user_name from web_tender_revive tr
        INNER JOIN web_users ru on ru.user_id=tr.revive_by
         where tr.status='Active' and tr.revive_status=1)tr1 on tr1.t_temp_id=tt.t_temp_id
 where tt.`status`='Active' and tt.t_cat_id = ".$_REQUEST['t_cat_id']." and tt.corrigendum is null and tt.app_reject is null and tr1.t_temp_id is null order by tt.t_temp_id DESC $LimitQry");
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
    foreach($rs[1] as $row){                
        $data[] = array(++$sNo,
            html_entity_decode($row['tender_name']),
            $row['cName'],                    
            "<div class=\"text-center tools\">
                <i class=\"far fa-check-circle\" cdata-frmT='4' data-t_temp_id='$row[t_temp_id]' title='Approve'></i>
                <i class=\"fas fa-times\" cdata-frmT='3' data-t_temp_id='$row[t_temp_id]' title='Reject'></i>
                <i class=\"far fa-quora\" cdata-frmT='1' data-t_temp_id='$row[t_temp_id]' title='Revive'></i>
            </div>",
        );
    }
}

$recordsTotal=getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");
$recordsFiltered=getNameQry("select count(wu.user_id)  from web_users wu
INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
 where wu.status='Active' and wu.user_id!=1");
         
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);