<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs = simplefetch("select tc.t_cat_id,tc.cat_name,tc.cat_name_h,concat(wu.user_name,' [',date_format(tc.creation_date,'%d/%m/%Y'),' ]') as cName from web_tender_category tc 
INNER JOIN web_users wu on wu.user_id=tc.creator_id where tc.status='Active' and tc.app_reject is null order by tc.t_cat_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $row['cat_name'],
                    $row['cat_name_h'],
                    $row['cName'],
//                    $row['apName'],
                    #$row['rName'], 
                    #html_entity_decode($row['revive_details']),                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-t_cat_id='$row[t_cat_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-t_cat_id='$row[t_cat_id]' title='Delete User'></i>
                    </div>",
                );
            }
        }
        
        $recordsTotal= getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered= getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
    break;
    
    case 2:#Approved links
        $rs= simplefetch("select tc.t_cat_id,tc.cat_name,concat(wu.user_name,' [',date_format(tc.creation_date,'%d/%m/%Y'),' ]')as cName,concat(ru.user_name,' [',date_format(tc.app_rej_action_on,'%M %d, %Y'),' ]')as apName from web_tender_category tc 
INNER JOIN web_users wu on wu.user_id=tc.creator_id
INNER JOIN web_users ru on ru.user_id=tc.app_rej_user_id
where tc.status='Active' and tc.app_reject=1 order by tc.t_cat_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    $row['cat_name'],
                    #html_entity_decode($row['cat_name_h']),
                    $row['cName'],
                    $row['apName'],     
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-t_cat_id='$row[t_cat_id]' title='Modify category'></i>
                        <!--<i class=\"fa fa-trash-o\" cdata-frmT='3 data-t_cat_id='$row[t_cat_id]' title='Delete category'></i>-->
                    </div>",
                );
            }
        }
        
        $recordsTotal= getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered= getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
    break;
    
    case 3:#Rejected links
        $rs= simplefetch("select tc.t_cat_id,tc.cat_name,concat(wu.user_name,' [',date_format(tc.creation_date,'%d/%m/%Y'),' ]')as cName,concat(ru.user_name,' [',date_format(tc.app_rej_action_on,'%M %d, %Y'),' ]')as rName from web_tender_category tc 
INNER JOIN web_users wu on wu.user_id=tc.creator_id
INNER JOIN web_users ru on ru.user_id=tc.app_rej_user_id
where tc.status='Active' and tc.app_reject=2 order by tc.t_cat_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    $row['cat_name'],
                    #html_entity_decode($row['cat_name_h']),
                    $row['cName'],                    
                    $row['rName'],
                    /*"<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-link_temp_id='$row[link_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-link_temp_id='$row[link_temp_id]' title='Delete User'></i>
                    </div>",*/
                );
            }
        }
        
        $recordsTotal= getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered= getNameQry("select count(wu.user_id)  from web_users wu
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