<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$usr_session='';
if($_SESSION['user_type'] =='20'){

     $usr_session= " and (pc.entry_by='".$_SESSION['userid']."' || pc.nmnh_type='".$_SESSION['musume_type']."')";
}
//$usr_session= " and (pc.entry_by='".$_SESSION['userid']."' || pc.nmnh_type='".$_SESSION['musume_type']."')";


switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs = simplefetch("select pc.m_cat_id,pc.cat_name,pc.cat_name_h,pc.img_name,concat(wu.user_name,' [',date_format(pc.creation_date,'%d/%m/%Y'),' ]')as cName, concat(wu.user_name,' [',date_format(pc.app_rej_action_on,'%M %d, %Y'),' ]')as apName, concat(wu.user_name,' [',date_format(pc.app_rej_action_on,'%M %d, %Y'),' ]')as rName from web_media_category pc INNER JOIN web_users wu on wu.user_id=pc.creator_id where pc.status='Active' and pc.app_reject is null $usr_session order by pc.m_cat_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if(empty($row['img_name'])){
                    $cImage="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                }
                else
                {
                    $cImage="<img src=\"../WriteReadData/PCAT8945/$row[img_name]\" class=\"img-circle\" alt=\"Link Icon\" width=\"50\" height=\"50\">";                    
                }
                
                $data[] = array(++$sNo,
                   // htmlspecialchars($row['cat_name'], ENT_QUOTES, 'UTF-8')
                    ($row['cat_name']),
                    ($row['cat_name_h']), 
                    $cImage,                   
                    $row['cName'],
                    $row['apName'],
                    $row['rName'], 
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-m_cat_id='$row[m_cat_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-m_cat_id='$row[m_cat_id]' title='Delete Category'></i>
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
    break;
    
    case 2:#Approved links
        $rs = simplefetch("select pc.m_cat_id,pc.cat_name,pc.cat_name_h,pc.img_name,concat(wu.user_name,' [',date_format(pc.creation_date,'%d/%m/%Y'),' ]')as cName,concat(ru.user_name,' [',date_format(pc.app_rej_action_on,'%M %d, %Y'),' ]')as apName from web_media_category pc 
INNER JOIN web_users wu on wu.user_id=pc.creator_id
INNER JOIN web_users ru on ru.user_id=pc.app_rej_user_id
where pc.status='Active' and pc.app_reject=1 $usr_session order by pc.m_cat_id DESC $LimitQry",1);
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
                    $row['apName'],     
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-m_cat_id='$row[m_cat_id]' title='Modify category'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-m_cat_id='$row[m_cat_id]' title='Delete Category'></i>                        
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
    break;
    
    case 3:#Rejected links
        $rs=simplefetch("select pc.m_cat_id,pc.cat_name,pc.cat_name_h,pc.img_name,concat(wu.user_name,' [',date_format(pc.creation_date,'%d/%m/%Y'),' ]')as cName,concat(ru.user_name,' [',date_format(pc.app_rej_action_on,'%M %d, %Y'),' ]')as rName from web_media_category pc 
INNER JOIN web_users wu on wu.user_id=pc.creator_id
INNER JOIN web_users ru on ru.user_id=pc.app_rej_user_id
where pc.status='Active' and pc.app_reject=2 $usr_session order by pc.m_cat_id DESC $LimitQry");
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
                    $row['rName'],
                    /*"<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
                    </div>",*/
                );
            }
        }
        
        $recordsTotal=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=getNameQry("select count(wu.user_id)  from web_users wu
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
echo frm_response($resData,true,false);