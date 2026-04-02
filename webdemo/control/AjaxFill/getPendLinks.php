<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);


$usr_session='';
/*if($_SESSION['user_type'] =='20'){

     $usr_session= " and (wlt.entry_by='".$_SESSION['userid']."' || wlt.dept_type='".$_SESSION['department_type']."')";
}else{

	$usr_session = " and wlt.dept_type=".$_REQUEST['dept_type'];
}*/

if(isset($_REQUEST['dept_type']) && $_SESSION['user_type'] !='20'){


    $cont_type = $_REQUEST['dept_type']=='-1' ? 0 : $_REQUEST['dept_type'];
    
    $usr_session= " and wlt.content_type='$cont_type'";
    }


switch($_REQUEST['l_natur']){#normal links
    case 1:
        $rs=simplefetch("select wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt.link_name, ifnull(concat(' (', wlt.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName from web_link_temp wlt
        INNER JOIN web_users wu on wu.user_id=wlt.creator_id
        LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
        INNER JOIN web_users ru on ru.user_id=lr.revive_by
         where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
         where wlt.`status`='Active' and wlt.lang_id=$_REQUEST[lang_id] /*and wlt.type_id=$_REQUEST[type_id]*/ and wlt.continuous_content=0 and lr1.link_temp_id is null and wlt.app_reject is null $usr_session $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),
                    $row['cName'],
                    "<div class=\"text-center tools\">                        
                        <i class=\"fa fa-eye Lpreview\" data-toggle=\"tooltip\" aria-hidden=\"true\" cdata-frmT='7' data-link_temp_id='$row[link_temp_id]' title='Preview'></i>
                    </div>",                    
                    "<div class=\"text-center tools\">
                        <i class=\"far fa-check-circle\" cdata-frmT='4' data-link_temp_id='$row[link_temp_id]' title='Approve'></i>
                        <i class=\"fas fa-times\" cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Reject'></i>
                        <i class=\"fab fa-quora\" cdata-frmT='1' data-link_temp_id='$row[link_temp_id]' title='Revive'></i>
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
        $SubQry=(isset($_REQUEST['lid'])&& $_REQUEST['lid']!='-1')?" and wlt.main_link_temp_id=$_REQUEST[lid]":"";
        $rs=simplefetch("select wlt.link_temp_id,wlt.lang_id,wlt.type_id,concat(wlt1.link_name, ifnull(concat(' (', wlt1.link_alias, ')'),'')) as link_name,concat(wu.user_name,' [',date_format(wlt.creation_date,'%d/%m/%Y'),' ]')as cName from web_link_temp wlt
        INNER JOIN web_users wu on wu.user_id=wlt.creator_id
        INNER JOIN (select lf.lid,wlt.link_name,l.lang from web_links_final lf
            INNER JOIN web_link_temp wlt on lf.link_temp_id=wlt.link_temp_id
            INNER JOIN web_lang l on l.lang_id=wlt.lang_id
            where lf.status='Active' and wlt.`status`='Active' and wlt.type_id=3)wlt1 on wlt1.lid=wlt.main_link_temp_id
        LEFT JOIN (select lr.link_temp_id,lr.revive_by,lr.revive_on,lr.revive_details,ru.user_name from web_link_revive lr
        INNER JOIN web_users ru on ru.user_id=lr.revive_by
         where lr.status='Active' and lr.revive_status=1)lr1 on lr1.link_temp_id=wlt.link_temp_id
         where wlt.`status`='Active' and wlt.lang_id=$_REQUEST[lang_id] and lr1.link_temp_id is null and wlt.type_id=3 and wlt.continuous_content=1 and wlt.app_reject is null $usr_session $SubQry $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),
                    $row['cName'],                    
                    "<div class=\"text-center tools\">
                        <i class=\"far fa-check-circle\" cdata-frmT='4' data-link_temp_id='$row[link_temp_id]' title='Approve'></i>
                        <i class=\"fas fa-times\" cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Reject'></i>
                        <i class=\"fab fa-quora\" cdata-frmT='1' data-link_temp_id='$row[link_temp_id]' title='Revive'></i>
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
?>