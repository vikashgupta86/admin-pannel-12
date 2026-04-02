<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=simplefetch("select wlt.main_link_temp_id,wlt.lid,ifnull(lr1.revive_details,'N/A') as revive_details,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt1.link_name, ifnull(concat(' (', wlt1.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
        ,ifnull(concat(lr1.user_name,' [',date_format(lr1.revive_on,'%d/%m/%Y'),' ]'),'N/A')as rName,
        ifnull(concat(ru1.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName 
        from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN (select lf.lid,wlt.link_name,wlt.link_alias,l.lang from web_links_final lf
    INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id
    INNER JOIN web_lang l on l.lang_id=wlt.lang_id
    where lf.status='Active' and wlt.`status`='Active' and lf.lid=$_REQUEST[lid]) wlt1 on wlt1.lid=wlt.main_link_temp_id
LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
INNER JOIN web_users ru on ru.user_id=lr.revive_by
 where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
 LEFT JOIN web_users ru1 on ru1.user_id=wlt.app_rej_user_id 
 where wlt.`status`='Active' and wlt.continuous_content=1 and wlt.lang_id=$_REQUEST[lang_id] and wlt.main_link_temp_id=$_REQUEST[lid] and wlt.app_reject is null $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['cName'],
                    $row['apName'],
                    $row['rName'], 
                    html_entity_decode($row['revive_details']),  
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",                 
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[main_link_temp_id]' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' pub-lid='$row[main_link_temp_id]' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
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
        $rs=simplefetch("select wlt.main_link_temp_id,lc.lid,ifnull(date_format(wlt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt1.link_name, ifnull(concat(' (', wlt1.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
        ,concat(ru.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName,concat(pu.user_name,' [',date_format(lc.publish_date,'%M %d, %Y'),' ]')as pName,case when lc.position is null then '999999' else lc.position end as nPos from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
INNER JOIN web_links_continuous lc on lc.link_temp_id=wlt.link_temp_id
INNER JOIN web_users pu on pu.user_id=lc.publish_by
INNER JOIN (select lf.lid,wlt.link_name,wlt.link_alias,l.lang from web_links_final lf
    INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id
    INNER JOIN web_lang l on l.lang_id=wlt.lang_id
    where lf.status='Active' and wlt.`status`='Active' and lf.lid=$_REQUEST[lid])wlt1 on wlt1.lid=wlt.main_link_temp_id
 where wlt.`status`='Active' and wlt.continuous_content=1 and wlt.lang_id=$_REQUEST[lang_id] and wlt.main_link_temp_id=$_REQUEST[lid] order by nPos+0,lc.lc_id $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),
                    "PageNo. - $sNo",                    
                    $row['cName'],
                    $row['rName'],
                    $row['pName'],
                    $row['expiry_date'],
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-lid='$row[main_link_temp_id]' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' pub-lid='$row[main_link_temp_id]' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
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
        $rs=simplefetch("select wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%M %d, %Y'),' ]')as cName
        ,concat(ru.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
 where wlt.`status`='Active' and wlt.continuous_content=1 and wlt.lang_id=$_REQUEST[lang_id] and wlt.main_link_temp_id=$_REQUEST[lid] and wlt.app_reject=2 $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['cName'],
                    $row['rName'],
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",
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