<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

$SubQry=isset($_GET['topic_id']) && $_GET['topic_id']!='-1'?" and bt.topic_id=$_GET[topic_id]":"";
switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("select bp.b_post_id,bt.topic_id,bt.subject,bp.post_details,concat(wu.user_name,' [',date_format(bt.creation_date,'%d/%m/%Y'),' ]')as cName from web_blogs_post bp 
INNER JOIN web_blog_topic bt on bt.topic_id=bp.topic_id
INNER JOIN web_users wu on wu.user_id=bp.user_id
where bt.status='Active' and bp.post_status=1 $SubQry order by bp.b_post_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['subject']),
                    html_entity_decode($row['post_details']),            
                    $row['cName'],
                    #$row['apName'],
                    /*$row['rName'], 
                    html_entity_decode($row['revive_details']),*/                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-check-circle-o\" cdata-frmT='4' data-b_post_id='$row[b_post_id]' title='Approve'></i>
                        <i class=\"fa fa-remove\" cdata-frmT='3' data-b_post_id='$row[b_post_id]' title='Reject'></i>
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
    
    case 2:#Published links
        $rs=$obj->simplefetch("select bp.b_post_id,bt.topic_id,bt.subject,bp.post_details,concat(wu.user_name,' [',date_format(bt.creation_date,'%d/%m/%Y'),' ]')as cName,concat(pu.user_name,' [',date_format(bt.app_rej_action_on,'%M %d, %Y'),' ]')as apName from web_blogs_post bp 
INNER JOIN web_blog_topic bt on bt.topic_id=bp.topic_id
INNER JOIN web_users wu on wu.user_id=bp.user_id
INNER JOIN web_users pu on pu.user_id=bp.action_by
where bt.status='Active' and bp.post_status=2 $SubQry order by bp.b_post_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['subject']),
                    html_entity_decode($row['post_details']),                                       
                    $row['cName'],
                    #$row['rName'],
                    $row['apName'],
                    #$row['expiry_date'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-remove\" cdata-frmT='3' data-b_post_id='$row[b_post_id]' title='Reject'></i>
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
    
    case 3:#Rejected links
        $rs=$obj->simplefetch("select bp.b_post_id,bt.topic_id,bt.subject,bp.post_details,concat(wu.user_name,' [',date_format(bt.creation_date,'%d/%m/%Y'),' ]')as cName,concat(pu.user_name,' [',date_format(bt.app_rej_action_on,'%M %d, %Y'),' ]')as apName from web_blogs_post bp 
INNER JOIN web_blog_topic bt on bt.topic_id=bp.topic_id
INNER JOIN web_users wu on wu.user_id=bp.user_id
INNER JOIN web_users pu on pu.user_id=bp.action_by
where bt.status='Active' and bp.post_status=3 $SubQry order by bp.b_post_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['subject']),
                    html_entity_decode($row['post_details']),                                       
                    $row['cName'],
                    #$row['rName'],
                    $row['apName'],                    
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