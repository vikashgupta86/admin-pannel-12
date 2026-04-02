<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$rs=$obj->simplefetch("select pm.prod_price_id,wt.product_name,pm.prod_price,date_format(pm.dated,'%M %d, %Y') as dated,pm.size from web_product_price pm
INNER JOIN web_product_temp wt on wt.p_temp_id=pm.p_temp_id
INNER JOIN web_users wu on wu.user_id=pm.creator_id
where pm.`status`='Active' and pm.p_cat_id=$_REQUEST[p_cat_id] and pm.p_temp_id=$_REQUEST[p_temp_id] order by pm.prod_price_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    $row['product_name'],
                    $row['size'],
					$row['prod_price'],
					$row['dated'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-prod_price_id='$row[prod_price_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-prod_price_id='$row[prod_price_id]' title='Delete'></i>
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