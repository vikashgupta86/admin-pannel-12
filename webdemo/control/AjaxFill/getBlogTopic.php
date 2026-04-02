<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("select bt.topic_id,bt.subject,concat(wu.user_name,' [',date_format(bt.creation_date,'%d/%m/%Y'),' ]')as cName from web_blog_topic bt 
INNER JOIN web_users wu on wu.user_id=bt.creator_id
where bt.status='Active' and bt.app_reject is null order by bt.topic_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                if(empty($row['img_name'])){
                    $cImage="<i class=\"fa fa-picture-o\" aria-hidden=\"true\" style=\"font-size: 50px;\"></i>";                    
                }
                else{
                    $cImage="<img src=\"../WriteReadData/PCAT8945/$row[img_name]\" class=\"img-circle\" alt=\"Link Icon\" width=\"50\" height=\"50\">";                    
                }
                
                $data[] = array(++$sNo,
                    html_entity_decode($row['subject']),
                    $row['cName'],                                             
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-television\" cdata-frmT='8' data-topic_id='$row[topic_id]' title='Publish'></i>
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-topic_id='$row[topic_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-topic_id='$row[topic_id]' title='Delete User'></i>
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
    
    case 2:#Approved links
        $rs=$obj->simplefetch("select bt.topic_id,bt.subject,concat(wu.user_name,' [',date_format(bt.creation_date,'%d/%m/%Y'),' ]')as cName,concat(ru.user_name,' [',date_format(bt.app_rej_action_on,'%M %d, %Y'),' ]')as apName,concat(pu.user_name,' [',date_format(bt.publish_date,'%M %d, %Y'),' ]')as puName from web_blog_topic bt 
INNER JOIN web_users wu on wu.user_id=bt.creator_id
INNER JOIN web_users ru on ru.user_id=bt.app_rej_user_id
INNER JOIN web_users pu on pu.user_id=bt.publish_by
where bt.status='Active' and bt.app_reject=1 order by bt.topic_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['subject']),                                       
                    $row['cName'],
                    $row['puName'],     
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-topic_id='$row[topic_id]' title='Modify topic'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-topic_id='$row[topic_id]' title='Delete topic'></i>
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