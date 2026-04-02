<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);

$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("SELECT wqt.title_id,wqt.question_title,concat(wu.user_name,' [',date_format(wqt.entry_date,'%d/%m/%Y'),' ]')as cName  from web_question_title wqt 
INNER JOIN web_users wu on wu.user_id=wqt.entry_by 
WHERE wqt.`status`='Active'",1);
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,                    
                    $row['question_title'],				
					$row['cName'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' data-title_id='$row[title_id]' title='Modify Question Title'></i>
                        <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-title_id='$row[title_id]' title='Delete Question Title'></i>
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
    break;
}



$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);