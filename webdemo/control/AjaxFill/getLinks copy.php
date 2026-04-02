<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
$dept_type='';
$status_dept = '';
$department = $_SESSION['department'];
if(!empty($department)){
 $dept_type = "INNER JOIN dept_link_map dm ON lf.lid=dm.link_temp_id";
 $status_dept = "AND dm.status='Active' and dm.dept_id='$department' and dm.user_id='$_SESSION[userid]'";
}


#echo '<pre>';print_r($_REQUEST);
$usr_session='';

/*if($_SESSION['user_type'] =='20'){

$usr_session= " and (wlt.entry_by='".$_SESSION['userid']."' || wlt.nmnh_type='".$_SESSION['musume_type']."')";
}*/

if(isset($_REQUEST['nmnh_type']) && $_SESSION['user_type'] !='20'){


$cont_type = $_REQUEST['nmnh_type']=='-1' ? 0 : $_REQUEST['nmnh_type'];

$usr_session= " and wlt.content_type='$cont_type'";
}

        

$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=simplefetch("select wlt.lid,ifnull(lr1.revive_details,'N/A')as revive_details,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
        ,ifnull(concat(lr1.user_name,' [',date_format(lr1.revive_on,'%d/%m/%Y'),' ]'),'N/A')as rName,
        ifnull(concat(ru1.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
INNER JOIN web_users ru on ru.user_id=lr.revive_by
 where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
 LEFT JOIN web_users ru1 on ru1.user_id=wlt.app_rej_user_id
 $dept_type
 where wlt.status='Active' $status_dept and wlt.lang_id=$_REQUEST[lang_id] and wlt.type_id=$_REQUEST[type_id] and wlt.continuous_content=0 and wlt.app_reject is null $usr_session  order by wlt.link_temp_id DESC $LimitQry",1);
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
                        <i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                        <i class=\"fas fa-trash-alt\" data-toggle=\"tooltip\"  cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
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
   
        $rs=simplefetch("select lf.lid,ifnull(date_format(lf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,lf.expiry_time,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wup.f_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
        ,concat(wup.f_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName,concat(wup.f_name,' [',date_format(lf.publish_date,'%M %d, %Y'),' ]')as pName from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
INNER JOIN web_users_profile wup on wup.user_id=wu.user_id

INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
INNER JOIN web_users pu on pu.user_id=lf.publish_by
$dept_type
 where wlt.`status`='Active' $status_dept and lf.status='Active' and wlt.lang_id=$_REQUEST[lang_id] and wlt.continuous_content=0 and wlt.type_id=$_REQUEST[type_id] $usr_session order by wlt.link_temp_id DESC $LimitQry",1);
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
				$buttonShow="";
				if(!empty($department)){
					$buttonShow = "<div class=\"text-center tools\">
                        
                        <i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                    </div>";
					
				}else{
					$buttonShow = "<div class=\"text-center tools\">
                        <i class=\"fa fa-desktop\" data-toggle=\"tooltip\" cdata-frmT='9' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify Publish Details'></i>
                        <i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                        <i class=\"fas fa-trash-alt\" data-toggle=\"tooltip\" cdata-frmT='3' pub-lid='$row[lid]' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
                    </div>";
					
				}
			
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['cName'],
                    $row['rName'],
                    $row['pName'],
                    $row['expiry_date'].' '. $row['expiry_time'],
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",
                    $buttonShow,
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
$dept_type
 where wlt.`status`='Active' $status_dept and wlt.lang_id=$_REQUEST[lang_id] and wlt.type_id=$_REQUEST[type_id] and wlt.continuous_content=0 and wlt.app_reject=2 $usr_session  order by wlt.link_temp_id DESC $LimitQry");
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
                        <i class=\"fas fa-trash-alt\" data-toggle=\"tooltip\" cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
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