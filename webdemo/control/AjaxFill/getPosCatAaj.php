<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("SELECT pt.product_name,pt.pid,pt.price,pt.discount,pt.bdesc,pt.p_temp_id,pt.product_name,concat(wu.user_name,' [',date_format(pt.creation_date,'%d/%m/%Y'),' ]')as cName/*,        
        ifnull(concat(ru1.user_name,' [',date_format(pt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName*/ from web_product_temp pt
INNER JOIN web_product_category mc on mc.p_cat_id=pt.p_cat_id
INNER JOIN web_users wu on wu.user_id=pt.creator_id
/*LEFT JOIN web_users ru1 on ru1.user_id=pt.app_rej_user_id*/
where pt.status='Active' and mc.p_cat_id=$_REQUEST[p_cat_id] and pt.publish_by is null order by pt.p_temp_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['product_name']),
                    !empty($row['discount'])?"$row[price]( $row[discount] % )":"$row[price]", 
                    html_entity_decode($row['bdesc']),                   
                    $row['cName'],
                    #$row['apName'],
                    /*$row['rName'], 
                    html_entity_decode($row['revive_details']),*/                   
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-television\" cdata-frmT='8' pub-pid='$row[pid]' data-p_temp_id='$row[p_temp_id]' title='Publish'></i>
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-pid='$row[pid]' data-p_temp_id='$row[p_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-p_temp_id='$row[p_temp_id]' title='Delete User'></i>
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
    
    case 2:#Published links
        $rs=$obj->simplefetch("SELECT mt.pos_id,mt.pos_cat_id,mt.pos_code,mt.pos_address,mt.pos_phone,mt.pos_email,mc.pos_cat_name,concat(wu.user_name,' [',date_format(mt.entry_date,'%d/%m/%Y'),' ]')as cName from pos mt
INNER JOIN pos_cat mc on mc.pos_cat_id=mt.pos_cat_id
INNER JOIN web_users wu on wu.user_id=mt.entry_by
where mt.status='Active' and mt.pos_cat_id=$_REQUEST[p_cat_id] and mc.status='Active' order by mt.pos_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    $row['pos_code'],
                    $row['pos_cat_name'], 
                    $row['pos_address'],                   
                    $row['pos_phone'],
					$row['pos_email'],
                    $row['cName'],
                    #$row['expiry_date'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-pos_cat_id='$row[pos_cat_id]' data-pos_id='$row[pos_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' pub-pos_cat_id='$row[pos_cat_id]' data-pos_id='$row[pos_id]' title='Delete Product'></i>
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
    
    case 3:#Rejected links
        /*$rs=$obj->simplefetch("SELECT mt.m_description,mt.m_description_h,mt.p_temp_id,mt.m_name,mt.m_name_h,mt.type_of_media,case when mt.type_of_media=1 then 'Photo' else 'Video' end as mType,concat(wu.user_name,' [',date_format(mt.creation_date,'%d/%m/%Y'),' ]')as cName,ifnull(concat(ru1.user_name,' [',date_format(mt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName from web_product_temp mt
INNER JOIN web_product_category mc on mc.p_cat_id=mt.p_cat_id
INNER JOIN web_users wu on wu.user_id=mt.creator_id
LEFT JOIN web_users ru1 on ru1.user_id=mt.app_rej_user_id
where mt.status='Active' and mc.p_cat_id=$_REQUEST[p_cat_id] and mt.app_reject=2 order by mt.p_temp_id DESC $LimitQry");
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
        
        $recordsTotal=$obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=$obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");*/
    break;
}



$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);