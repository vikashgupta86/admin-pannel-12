<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);
	
        $subQry='';
        $subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?"  dated>='".$obj->todate($_REQUEST['f_date'])." 00:00:00'":'';
        $subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and dated<='".$obj->todate($_REQUEST['t_date'])." 23:59:59'":'';

		 $subQry.=(isset($_REQUEST['lang_cat']) && $_REQUEST['lang_cat']==2)?" and urlused LIKE '%tender%'":" and lang_id=$_REQUEST[lang_id] and urlused NOT LIKE '%tender%'";
		 
		$rs=$obj->simplefetch("select * from visitor_user WHERE $subQry order by id desc $LimitQry");
		
	
        if($rs[0]>0){
        $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
             
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $row['dated'],
                    $row['ipaddress'],
                    $row['browser'], 
                    $row['reference'], 
                    $row['urlused'], 
                );
            }
        }
        
        $recordsTotal=$obj->getNameQry("select count(id) from visitor_user 
        where lang_id=$_REQUEST[lang_id] $subQry");
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
