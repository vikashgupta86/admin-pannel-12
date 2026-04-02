<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
//echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);
$subQry='';
$subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?" and wf.f_rec_on>='".$obj->todate($_REQUEST['f_date'])." 00:00:00'":'';
$subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and wf.f_rec_on<='".$obj->todate($_REQUEST['t_date'])." 23:59:59'":'';    

$department = $_SESSION['department'];
if(!empty($department)){
 $department = "AND wf.department= $department";
}

switch($_REQUEST['tabID']){
    case 1:#General links
    
    
        $rs=$obj->simplefetch("select date_format(wf.f_rec_on,'%M %d, %Y')as f_rec_on,date_format(wf.rep_on,'%M %d, %Y')as rep_on,wf.feed_id,concat(ifnull(t.title_name,''), ' ', ifnull(wf.f_name,''), ' ', ifnull(wf.m_name, ''), ' ', ifnull(wf.l_name, ''))as sName,
        concat(wf.addr,ifnull(concat(', ',d.district_name),''),ifnull(concat('',s.state_name),''),  ifnull(concat(', pin code -',wf.pincode),''))as addr,wf.f_details,wf.rep_details, case when wf.replied is null then 'No' else 'Yes' end as repFlage,wf.email_id,wf.phone from web_feedback wf
        left JOIN web_st_title t on t.title_id=wf.title_id
        left JOIN web_st_states s on s.state_id=wf.state_id 
        left JOIN web_st_districts d on d.district_id=wf.district_id
        where wf.status='Active' $department and wf.feed_type=1 $subQry order by wf.feed_id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $repOn=!empty($row['rep_on'])?'<br>( '.$row['rep_on'].' )':'';
                $data[] = array(++$sNo,                                        
                    $row['sName'],
                     $row['email_id'],
                     //$row['phone'],
                    $row['f_details'].'<br>( '.$row['f_rec_on'].' )',
                    $row['repFlage'].$repOn,
                    $row['rep_details'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-reply\" cdata-frmT='1' data-feed_id='$row[feed_id]' title='Reply'></i>
                        <i class=\"fa fa-map-o\" cdata-frmT='2' data-feed_id='$row[feed_id]' title='View Details'></i>
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
    
    case 2:#content links
        $rs=$obj->simplefetch("select date_format(wf.f_rec_on,'%M %d, %Y')as f_rec_on,date_format(wf.rep_on,'%M %d, %Y')as rep_on,l.link_name,wf.feed_id,concat(ifnull(t.title_name,''), ' ', ifnull(wf.f_name,''), ' ', ifnull(wf.m_name, ''), ' ', ifnull(wf.l_name, ''))as sName,
        concat(wf.addr,ifnull(concat(', ',d.district_name),''),ifnull(concat('',s.state_name),''),  ifnull(concat(', pin code -',wf.pincode),''))as addr,wf.f_details,wf.rep_details, case when wf.replied is null then 'No' else 'Yes' end as repFlage,wf.email_id,wf.mobile from web_feedback wf
        left JOIN web_st_title t on t.title_id=wf.title_id
        left JOIN web_st_states s on s.state_id=wf.state_id 
        left JOIN web_st_districts d on d.district_id=wf.district_id
        left JOIN (select lf.lid,lt.link_name from web_link_temp lt
                    INNER JOIN web_links_final lf on lf.link_temp_id=lt.link_temp_id
                    where lt.status='Active' and lf.`status`='Active') l on l.lid=wf.lid
        where wf.status='Active' $department and wf.feed_type=0 $subQry order by wf.feed_id DESC  $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){       
                $repOn=!empty($row['rep_on'])?'<br>( '.$row['rep_on'].' )':'';
                $data[] = array(++$sNo,
                    html_entity_decode($row['link_name']),                    
                    $row['sName'],
                    $row['email_id'],
                    //$row['mobile'],
                    $row['f_details'].'<br>( '.$row['f_rec_on'].' )',
                    $row['repFlage'].$repOn,
                    $row['rep_details'],
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-reply\" cdata-frmT='1' data-feed_id='$row[feed_id]' title='Reply'></i>
                        <i class=\"fa fa-map-o\" cdata-frmT='2' data-feed_id='$row[feed_id]' title='View Details'></i>                        
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