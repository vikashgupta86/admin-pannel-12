<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$rs=simplefetch("SELECT mt.image_name,case when mf.gallery_flage=1 then 'checked=\"\"' else '' end as bChk,mf.m_id,mt.m_description,mt.m_description_h,mt.m_temp_id,mt.m_name,mt.m_name_h,mt.type_of_media,case when mt.type_of_media=1 then 'Photo' else 'Video' end as mType,concat(wu.user_name,' [',date_format(mt.creation_date,'%d/%m/%Y'),' ]')as cName,ifnull(concat(ru1.user_name,' [',date_format(mt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName,concat(pu.user_name,' [',date_format(mf.publish_date,'%M %d, %Y'),' ]')as pName from web_media_temp mt
INNER JOIN web_media_category mc on mc.m_cat_id=mt.m_cat_id
INNER JOIN web_media_final mf on mf.m_temp_id=mt.m_temp_id
INNER JOIN web_users wu on wu.user_id=mt.creator_id
INNER JOIN web_users ru1 on ru1.user_id=mt.app_rej_user_id
INNER JOIN web_users pu on pu.user_id=mf.publish_by
where mt.status='Active' and mt.type_of_media=1 and mc.m_cat_id=$_REQUEST[m_cat_id] and mf.status='Active' and mt.app_reject=1 order by mt.m_temp_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if(empty($row['image_name'])){
                    $cImage="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                }
                else{
                    $cImage="<img src=\"../WriteReadData/MD32145/$row[image_name]\" class=\"img-circle\" alt=\"Link Icon\" width=\"50\" height=\"50\">";                    
                }
                $data[] = array(++$sNo,
                    $row['m_description'],
                    $row['m_description_h'], 
                    $cImage,
                    $row['apName'],     
                    "<div class=\"text-center\"><input type=\"checkbox\" name=\"mChk[]\" id=\"mChk_$row[m_id]\" value=\"$row[m_id]\" $row[bChk] /></div>",
                );
            }
        }
        
        /*$recordsTotal=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");*/


$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    #"recordsTotal"  => intval( $recordsTotal ),
	#"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);