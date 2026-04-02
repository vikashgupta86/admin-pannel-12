<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
AjaxFilePrevent();
userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);
	
        $subQry='';
        $subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?" and entry_date>='". $_REQUEST['f_date']." 00:00:00'":'';
        $subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and entry_date<='". $_REQUEST['t_date']." 23:59:59'":'';

		//$rs=$obj->simplefetch("select * from web_url_error where status='Active' $subQry order by id desc $LimitQry");
		$rs = simplefetch("select * from web_url_error where status='Active' $subQry AND userURL NOT LIKE '%jpg%' AND userURL NOT LIKE '%png%' AND userURL NOT LIKE '%css%' AND userURL NOT LIKE '%js%' AND userURL NOT LIKE '%ttf%' AND userURL NOT LIKE '%woff%' AND userURL NOT LIKE '%woff%' order by id desc $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
             
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $row['userIP'],
                    $row['entry_date'], 
                    $row['userURL'], 
                );
            }
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
echo  frm_response($resData,true,false);