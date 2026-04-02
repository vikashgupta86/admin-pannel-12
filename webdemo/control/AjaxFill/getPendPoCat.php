<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

/*$usr_session='';
if($_SESSION['user_type'] =='20'){

     $usr_session= " and (pc.entry_by='".$_SESSION['userid']."' || pc.nmnh_type='".$_SESSION['musume_type']."')";
}*/

//$usr_session= " and (pc.entry_by='".$_SESSION['userid']."' || pc.nmnh_type='".$_SESSION['musume_type']."')";

$usr_session= " and pc.entry_by='".$_SESSION['userid']."'";

$rs=simplefetch("select pc.m_cat_id,pc.cat_name,pc.cat_name_h,pc.img_name,concat(wu.user_name,' [',date_format(pc.creation_date,'%d/%m/%Y'),' ]')as cName from web_media_category pc 
INNER JOIN web_users wu on wu.user_id=pc.creator_id
where pc.status='Active' and pc.app_reject is null $usr_session order by pc.m_cat_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if(empty($row['img_name'])){
                    $cImage="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                }
                else{
                    $cImage="<img src=\"../WriteReadData/PCAT8945/$row[img_name]\" class=\"img-circle\" alt=\"Link Icon\" width=\"50\" height=\"50\">";                    
                }
                
                $data[] = array(++$sNo,
                    html_entity_decode($row['cat_name']),
                    html_entity_decode($row['cat_name_h']), 
                    $cImage,                   
                    $row['cName'],                    
                    "<div class=\"text-center tools\">
                        <i class=\"far fa-check-circle\" cdata-frmT='4' data-m_cat_id='$row[m_cat_id]' title='Approve'></i>
                        <i class=\"fas fa-times\" cdata-frmT='3' data-m_cat_id='$row[m_cat_id]' title='Reject'></i>                        
                    </div>",
                );
            }
        }
        
        $recordsTotal=getNameQry("select count(pc.m_cat_id)  from web_media_category pc where pc.status='Active' and pc.app_reject is null $usr_session");
        $recordsFiltered=getNameQry("select count(pc.m_cat_id)  from web_media_category pc where pc.status='Active' and pc.app_reject is null $usr_session");
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);