<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

switch($_REQUEST['tabID']){
    case 1:#pending links
        $rs=$obj->simplefetch("select tt.t_id,ifnull(tr1.revive_details,'N/A')as revive_details,tt.t_temp_id,tt.tender_name,concat(wu.user_name,' [',date_format(tt.creation_date,'%d/%m/%Y'),' ]')as cName
        ,ifnull(concat(tr1.user_name,' [',date_format(tr1.revive_on,'%d/%m/%Y'),' ]'),'N/A')as rName,
        ifnull(concat(ru1.user_name,' [',date_format(tt.app_rej_action_on,'%M %d, %Y'),' ]'),'N/A')as apName from web_tender_temp tt
INNER JOIN web_users wu on wu.user_id=tt.creator_id
LEFT JOIN (select tr.t_temp_id,tr.revive_by,tr.revive_on,tr.revive_details,ru.user_name from web_tender_revive tr
INNER JOIN web_users ru on ru.user_id=tr.revive_by
 where tr.status='Active' and tr.revive_status=1)tr1 on tr1.t_temp_id=tt.t_temp_id
 LEFT JOIN web_users ru1 on ru1.user_id=tt.app_rej_user_id
 where tt.`status`='Active' and tt.t_cat_id=$_REQUEST[t_cat_id] and tt.dept_id=$_REQUEST[department] and tt.corrigendum is null and tt.app_reject is null order by tt.t_temp_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['tender_name']),                    
                    $row['cName'],
                    $row['apName'],
                    $row['rName'], 
                    html_entity_decode($row['revive_details']),                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-t_id='$row[t_id]' data-t_temp_id='$row[t_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-t_temp_id='$row[t_temp_id]' title='Delete User'></i>
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
	
        $subQry='';
        $subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?" and tt.creation_date>='".$obj->todate($_REQUEST['f_date'])." 00:00:00'":'';
        $subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and tt.creation_date<='".$obj->todate($_REQUEST['t_date'])." 23:59:59'":'';
		  
	if($_REQUEST['t_cat_id'] != ''){
      $ci=" and tt.t_cat_id=$_REQUEST[t_cat_id]";
    }


	if($_REQUEST['department'] != ''){
      $di=" and tt.dept_id=$_REQUEST[department]";
    }

	
        $rs=$obj->simplefetch("select dep.dept_name,wtc.cat_name,tf.t_id,tt.pub_time,tt.close_time,tt.open_time,ifnull(date_format(tt.pub_date,'%M %d, %Y'),'N/A')as pub_date,ifnull(date_format(tt.close_date,'%M %d, %Y'),'N/A')as close_date,ifnull(date_format(tt.open_date,'%M %d, %Y'),'N/A')as open_date,ifnull(date_format(tt.expiry_date,'%M %d, %Y'),'N/A')as expiry_date,tt.t_temp_id,tt.tender_name,tt.t_num,concat(date_format(tt.creation_date,'%d/%m/%Y'))as cName
        ,concat(ru.user_name,'[',date_format(tt.app_rej_action_on,'%M %d, %Y'),']')as rName,concat(pu.user_name,'[',date_format(tf.publish_date,'%M %d, %Y'),' ]')as pName from web_tender_temp tt
INNER JOIN web_users wu on wu.user_id=tt.creator_id
INNER JOIN web_users ru on ru.user_id=tt.app_rej_user_id
INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
INNER JOIN web_users pu on pu.user_id=tf.publish_by
INNER JOIN department dep on tt.dept_id=dep.id
INNER JOIN web_tender_category wtc on wtc.t_cat_id=tt.t_cat_id

 where tt.`status`='Active' $ci $di and tt.corrigendum is null $subQry order by tt.t_temp_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $rsc=$obj->simplefetch("select count(wt.t_temp_id)as cTot,wt.t_temp_id,wt.corrigendum,wtf.ct_id,wt.t_id,case when wtf.ct_id is null then 1 else 2 end as tot from web_tender_temp wt
	LEFT JOIN web_tender_corrigendum_final wtf on wtf.t_temp_id=wt.t_temp_id
	 where wt.status='Active' and wt.app_reject is not null and wt.corrigendum=1 and wt.t_id=$row[t_id] GROUP BY tot");
                if($rsc[0]>0){
                    foreach($rsc[1] as $rows){
                        $penCor=empty($rows['ct_id'])?$rows['cTot']:'0';
                        $pubCor=!empty($rows['ct_id'])?$rows['cTot']:'0';
                    }
                }
                $data[] = array(++$sNo,
				 	$row['cat_name'],
				 	$row['t_num'],
                    html_entity_decode($row['tender_name']),
                    $row['dept_name'],
                    $row['cName'],
                    //$row['pName'],
                    "<div class=\"text-center tools\">
                            Pending: [ $penCor ]<br>
                            Published: [ $pubCor ]<br>
                        <i class=\"fa fa-fax\" cdata-frmT='2' pub-t_id='$row[t_id]' data-t_temp_id='$row[t_temp_id]' data-department='$row[department]' title='Corrigendum'></i>
                    </div>",
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' pub-t_id='$row[t_id]' data-t_temp_id='$row[t_temp_id]' title='Modify Details'></i>
                        <!--<i class=\"fa fa-trash-o\" cdata-frmT='3 pub-t_id='$row[t_id]'' data-t_temp_id='$row[t_temp_id]' title='Delete User'></i>-->
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
        $rs=$obj->simplefetch("select tt.t_temp_id,tt.tender_name,concat(wu.user_name,' [',date_format(tt.creation_date,'%M %d, %Y'),' ]')as cName
        ,concat(ru.user_name,' [',date_format(tt.app_rej_action_on,'%M %d, %Y'),' ]')as rName from web_tender_temp tt
INNER JOIN web_users wu on wu.user_id=tt.creator_id
INNER JOIN web_users ru on ru.user_id=tt.app_rej_user_id
 where tt.`status`='Active' and tt.t_cat_id=$_REQUEST[t_cat_id] and tt.corrigendum is null and tt.app_reject=2 order by tt.t_temp_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,
                    html_entity_decode($row['tender_name']),                    
                    $row['cName'],
                    $row['rName'],
                    /*"<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" cdata-frmT='2' data-t_temp_id='$row[t_temp_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" cdata-frmT='3' data-t_temp_id='$row[t_temp_id]' title='Delete User'></i>
                    </div>",*/
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