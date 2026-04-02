<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

// $usr_session='';
// if($_SESSION['user_type'] =='20'){

//      $usr_session= " and (t.entry_by='".$_SESSION['userid']."' || t.nmnh_type='".$_SESSION['musume_type']."')";
// }

//$rs=$obj->simplefetch("select * from nmnh_type where status='Active' order by id desc $LimitQry");
$rs=$obj->simplefetch("select dlm.dept_link_id,dlm.entry_date as newdate,lf.lid,ifnull(date_format(lf.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,lf.expiry_time,wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName
,concat(ru.user_name,' [',date_format(wlt.app_rej_action_on,'%M %d, %Y'),' ]')as rName,concat(pu.user_name,' [',date_format(lf.publish_date,'%M %d, %Y'),' ]')as pName from web_link_temp wlt
INNER JOIN web_users wu on wu.user_id=wlt.creator_id
INNER JOIN web_users ru on ru.user_id=wlt.app_rej_user_id
INNER JOIN web_links_final lf on lf.link_temp_id=wlt.link_temp_id
INNER JOIN web_users pu on pu.user_id=lf.publish_by
INNER JOIN dept_link_map dlm on dlm.link_temp_id=lf.lid
where dlm.`status`='Active' and lf.status='Active' and dlm.lang_id=$_REQUEST[lang_id] and wlt.continuous_content=0 and dlm.link_type_id=$_REQUEST[type_id] and dlm.dept_id=$_REQUEST[dep_id] $usr_session order by wlt.link_temp_id DESC $LimitQry",1);

// print_r($rs);
// exit;


        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
             
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                  html_entity_decode($row['link_name']),  
					$row['newdate'],
					/*"<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",*/

                                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-link_temp_id='$row[dept_link_id]' title='Delete User'></i>                      
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
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);