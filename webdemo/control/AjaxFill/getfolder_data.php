<?php include '../../appcode/globals.inc.php'; 
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);
$foldername=$_REQUEST['fname'];

	
	$mydir = '../../WriteReadData/'.$foldername.'/' ;
	//$fileList = scandir($mydir);
	$fileList = preg_grep('~\.(jpeg|jpg|png|pdf|PDF)$~', scandir($mydir));
	
	$sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
	foreach($fileList as $filename){
	
		$data[] = array(++$sNo,
		$filename,
		@date('F d, Y, H:i:s', filemtime($mydir . "/" . $filename)),
		 
		/*filemtime($filename),*/ 
	 "<div class=\"text-center tools\"> <a href=\"../__DIR__$mydir$filename\" target=\"_blank\"><i class=\"fa fa-eye Lpreview\"  title='Preview'> </i></a> </div>", 
	"<div class=\"text-center tools\">
	<i class=\"fas fa-trash\" data-toggle=\"tooltip\"  cdata-frmT='3' data-filename='$filename' data-foldername='$foldername' title='Delete File'></i>                      
	</div>",
	);

	
}

$recordsTotal= getNameQry("select count(wu.user_id)  from web_users wu
	INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
		where wu.status='Active' and wu.user_id!=1");
	$recordsFiltered= getNameQry("select count(wu.user_id)  from web_users wu
	INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
		where wu.status='Active' and wu.user_id!=1");
		
        
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo frm_response($resData,true,false);





