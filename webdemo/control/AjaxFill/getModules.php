<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$rs=simplefetch("select * from web_st_module where status='Active' $LimitQry");
if($rs[0]>0){
    $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
    foreach($rs[1] as $row){
        $data[] = array(++$sNo,
            $row['module_name'],
            "<div class=\"tools\">
                <i class=\"fa fa-edit btn btn-primary btn-sm\" data-modid='$row[module_id]'></i>
                <i class=\"fa fa-trash-o btn btn-primary btn-sm\" data-modid='$row[module_id]'></i>
            </div>",
        );
    }
}

$recordsTotal=getNameQry("select count(module_id) from web_st_module where status='Active'");
$recordsFiltered=getNameQry("select count(module_id) from web_st_module where status='Active'");

$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo json_encode($resData);
?>