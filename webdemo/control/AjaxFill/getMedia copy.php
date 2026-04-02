<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);


 $usr_session='';
 if($_SESSION['user_type'] =='20'){

     $usr_session= " and (mc.entry_by='".$_SESSION['userid']."' || mc.content_type_id='".$_SESSION['musume_type']."')";
 }else{
	 
	 $usr_session = " and mt.content_type=".$_REQUEST['content_type_id'];
 }
     
switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=simplefetch("SELECT mt.m_id, mt.image_name,mt.m_description,mt.m_description_h,mt.m_temp_id,mt.content_type,mt.m_name,mt.m_name_h,mt.type_of_media,case when mt.type_of_media=1 then 'Photo' else 'Video' end as mType,concat(wu.user_name,' [',date_format(mt.creation_date,'%d/%m/%Y'),' ]')as cName,ifnull(concat(ru1.user_name,' [',date_format(mt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName from web_media_temp mt
INNER JOIN web_media_category mc on mc.m_cat_id=mt.m_cat_id
INNER JOIN web_users wu on wu.user_id=mt.creator_id
LEFT JOIN web_users ru1 on ru1.user_id=mt.app_rej_user_id
where mt.status='Active' and mc.m_cat_id=$_REQUEST[m_cat_id] and mt.app_reject is null $usr_session order by mt.m_temp_id DESC $LimitQry",1);
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if(empty($row['image_name'])){
                    $icon="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                }
                else{
                    $icon="<img src=\"../WriteReadData/MD32145/$row[image_name]\" class=\"img-circle\" alt=\"\" width=\"50\" height=\"50\">";                    
                }
                
                $data[] = array(++$sNo,
                    html_entity_decode($row['m_description']),
                    html_entity_decode($row['m_description_h']), 
                    $row['mType'],    
                    "<div class=\"text-center\">$icon</div>",               
                    $row['cName'],
                    $row['apName'],
                    /*$row['rName'], 
                    html_entity_decode($row['revive_details']),*/                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-m_id='$row[m_id]' data-m_temp_id='$row[m_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-m_temp_id='$row[m_temp_id]' title='Delete Media'></i>
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
    
    case 2:#Published links
	 	/*$dynQry='  and mf.publish_date<=CURDATE()';*/
        $dynQry='';
        $rs=simplefetch("SELECT mt.image_name,mf.m_id,mt.m_description,mt.m_description_h,mt.m_temp_id,mt.m_name,mt.content_type,mt.m_name_h,mt.type_of_media,case when mt.type_of_media=1 then 'Photo' else 'Video' end as mType,concat(wu.user_name,' [',date_format(mt.creation_date,'%d/%m/%Y'),' ]')as cName,ifnull(concat(ru1.user_name,' [',date_format(mt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName,concat(pu.user_name,' [',date_format(mf.publish_date,'%M %d, %Y'),' ]')as pName from web_media_temp mt
INNER JOIN web_media_category mc on mc.m_cat_id=mt.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
INNER JOIN web_users wu on wu.user_id=mt.creator_id
INNER JOIN web_users ru1 on ru1.user_id=mt.app_rej_user_id
INNER JOIN web_users pu on pu.user_id=mf.publish_by
where mt.status='Active' and mc.m_cat_id=$_REQUEST[m_cat_id] and mf.status='Active' and mt.app_reject=1 $usr_session $dynQry order by mt.m_temp_id DESC $LimitQry");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if(empty($row['image_name'])){
                    $icon="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                }
                else{
                    $icon="<img src=\"../WriteReadData/MD32145/$row[image_name]\" class=\"img-circle\" alt=\"\" width=\"50\" height=\"50\">";                    
                }
                $data[] = array(++$sNo,
                    html_entity_decode($row['m_description'] ?? ''),
                    html_entity_decode($row['m_description_h'] ?? ''), 
                    $row['mType'],
                    "<div class=\"text-center\">$icon</div>",                   
                    $row['cName'],
                    $row['apName'],
                    #$row['rName'],
                    $row['pName'],
                    #$row['expiry_date'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-m_id='$row[m_id]' data-m_temp_id='$row[m_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-m_temp_id='$row[m_temp_id]' title='Delete Media'></i>
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
        $rs= simplefetch("SELECT mt.m_description,mt.m_description_h,mt.m_temp_id,mt.content_type,mt.m_name,mt.m_name_h,mt.content_type,mt.type_of_media,case when mt.type_of_media=1 then 'Photo' else 'Video' end as mType,concat(wu.user_name,' [',date_format(mt.creation_date,'%d/%m/%Y'),' ]')as cName,ifnull(concat(ru1.user_name,' [',date_format(mt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName from web_media_temp mt
INNER JOIN web_media_category mc on mc.m_cat_id=mt.m_cat_id
INNER JOIN web_users wu on wu.user_id=mt.creator_id
LEFT JOIN web_users ru1 on ru1.user_id=mt.app_rej_user_id
where mt.status='Active' and mc.m_cat_id=$_REQUEST[m_cat_id] and mt.app_reject=2 $usr_session order by mt.m_temp_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['m_description']),
                    html_entity_decode($row['m_description_h']), 
                    $row['mType'],                   
                    $row['cName'],
                    $row['apName'],                    
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