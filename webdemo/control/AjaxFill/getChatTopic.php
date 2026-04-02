<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("select cs.chat_sch_id,cs.chat_topic,date_format(cs.chat_start_on,'%d %M, %Y')as chatOn,cs.remarks from web_chat_schedule cs where cs.status='Active' and cs.chat_start_on>=CURDATE() order by cs.chat_sch_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    html_entity_decode($row['chat_topic']),
                    #html_entity_decode($row['cat_name_h']),
                    $row['chatOn'],
                    #$row['remarks'],
                    #$row['rName'], 
                    html_entity_decode($row['remarks']),                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-chat_sch_id='$row[chat_sch_id]' title='Modify Schedule'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-chat_sch_id='$row[chat_sch_id]' title='Delete Schedule'></i>
                    </div>",
                );
            }
        }
        
        /*$recordsTotal=$obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=$obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");*/
    break;
    
    case 2:#Approved links
        $rs=$obj->simplefetch("select cs.chat_sch_id,cs.chat_topic,date_format(cs.chat_start_on,'%d %M, %Y')as chatOn from web_chat_schedule cs where cs.status='Active' and cs.chat_start_on<CURDATE() order by cs.chat_sch_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['chat_topic']),
                    #html_entity_decode($row['cat_name_h']),
                    $row['chatOn'],
                    html_entity_decode($row['remarks']),     
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-chat_sch_id='$row[chat_sch_id]' title='Modify Schedule'></i>
                        <!--<i class=\"fa fa-trash-o\" cdata-frmT='3 data-chat_sch_id='$row[chat_sch_id]' title='Delete category'></i>-->
                    </div>",
                );
            }
        }
        
        /*$recordsTotal=$obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
        $recordsFiltered=$obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");*/
    break;
}



$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);