<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$dept_type='';
$status_dept = '';
$department = $_SESSION['department'];
if(!empty($department)){
 $dept_type = "INNER JOIN dept_link_map dm ON wlt.lid=dm.link_temp_id";
 $status_dept = "AND dm.status='Active'";
}

$usr_session='';
/*if($_SESSION['user_type'] =='20'){

     $usr_session= " and (wlt.entry_by='".$_SESSION['userid']."' || wlt.nmnh_type='".$_SESSION['musume_type']."')";
}else{

$usr_session = " and wlt.nmnh_type=".$_REQUEST['nmnh_type'];
}*/


if(isset($_REQUEST['nmnh_type']) && $_SESSION['user_type'] !='20'){

    $nmnh_type = filter_input(INPUT_POST, 'nmnh_type', FILTER_VALIDATE_INT);
    $lang_id = filter_input(INPUT_POST, 'lang_id', FILTER_VALIDATE_INT);
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);

    $cont_type = $nmnh_type=='-1' ? 0 : $nmnh_type;
    
    $usr_session= " and wlt.content_type='$cont_type'";
    }

switch($_REQUEST['l_natur']){#normal links
    case 1:
        $rs=simplefetch("select wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName from web_link_temp wlt
        INNER JOIN web_users wu on wu.user_id=wlt.creator_id
        LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
        INNER JOIN web_users ru on ru.user_id=lr.revive_by
         where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
        INNER JOIN web_users au on au.user_id=wlt.app_rej_user_id
        LEFT JOIN (select * from web_links_final where status='Active') lf on lf.link_temp_id=wlt.link_temp_id
		$dept_type
         where wlt.`status`='Active' $status_dept and wlt.lang_id=$lang_id /*and wlt.type_id=$type_id*/ and wlt.continuous_content=0  and wlt.publish_by is null and wlt.publish_by is null and wlt.app_reject=1 $usr_session $LimitQry");
        if($rs[0]>0){ 
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),
                    $row['cName'],
                    $row['cName'],
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",                    
                    "<div class=\"text-center tools\">
                        <i class=\"fas fa-tv\" cdata-frmT='1' data-link_temp_id='$row[link_temp_id]' title='Publish'></i>
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
    
    case 2:#continious links

    
        $rs=simplefetch("select wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName from web_link_temp wlt
        INNER JOIN web_users wu on wu.user_id=wlt.creator_id
				INNER JOIN (select lf.lid,wlt.link_name,l.lang from web_links_final lf
            INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id
            INNER JOIN web_lang l on l.lang_id=wlt.lang_id
            where lf.status='Active' and wlt.`status`='Active' and wlt.type_id=3) t1 on wlt.lid=wlt.main_link_temp_id
        LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
        INNER JOIN web_users ru on ru.user_id=lr.revive_by
         where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
        INNER JOIN web_users au on au.user_id=wlt.app_rej_user_id
		$dept_type
        LEFT JOIN (select * from web_links_final where status='Active') lf on lf.link_temp_id=wlt.link_temp_id
         where wlt.`status`='Active' $status_dept and wlt.lang_id=$lang_id and wlt.continuous_content=1 and wlt.publish_by is null and wlt.publish_by is null and wlt.app_reject=1 $usr_session $LimitQry");

// $sqql = "select wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName from web_link_temp wlt
//         INNER JOIN web_users wu on wu.user_id=wlt.creator_id
// 				INNER JOIN (select lf.lid,wlt.link_name,l.lang from web_links_final lf
//             INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id
//             INNER JOIN web_lang l on l.lang_id=wlt.lang_id
//             where lf.status='Active' and wlt.`status`='Active' and wlt.type_id=3) on wlt.lid=wlt.main_link_temp_id
//         LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
//         INNER JOIN web_users ru on ru.user_id=lr.revive_by
//          where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
//         INNER JOIN web_users au on au.user_id=wlt.app_rej_user_id
// 		$dept_type
//         LEFT JOIN (select * from web_links_final where status='Active') lf on lf.link_temp_id=wlt.link_temp_id
//          where wlt.`status`='Active' $status_dept and wlt.lang_id=$lang_id and wlt.continuous_content=1 and wlt.publish_by is null and wlt.publish_by is null and wlt.app_reject=1 $usr_session $LimitQry";

//          echo $sqql;
//          die();


        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),
                    $row['cName'],
                    $row['cName'],                    
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-television\" cdata-frmT='1' data-link_temp_id='$row[link_temp_id]' title='Publish'></i>
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
}





$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);