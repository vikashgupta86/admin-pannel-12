<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$rs=$obj->simplefetch("select tc.p_cat_id,tc.cat_name,concat(wu.user_name,' [',date_format(tc.creation_date,'%d/%m/%Y'),' ]')as cName from web_product_category tc 
INNER JOIN web_users wu on wu.user_id=tc.creator_id
where tc.status='Active' and tc.app_reject is null order by tc.p_cat_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                                
                $data[] = array(++$sNo,
                    html_entity_decode($row['cat_name']),
                    #html_entity_decode($row['cat_name_h']),
                    $row['cName'],                    
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-check-circle-o\" cdata-frmT='4' data-p_cat_id='$row[p_cat_id]' title='Approve'></i>
                        <i class=\"fa fa-remove\" cdata-frmT='3' data-p_cat_id='$row[p_cat_id]' title='Reject'></i>                        
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