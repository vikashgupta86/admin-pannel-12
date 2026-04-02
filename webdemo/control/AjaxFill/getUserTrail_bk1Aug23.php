<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);   

switch($_REQUEST['tabID']){
    case 1:#Login attemps
        $subQry='';
        $subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?" and wl.dateoflogin>='".$obj->todate($_REQUEST['f_date'])." 00:00:00'":'';
        $subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and wl.dateoflogin<='".$obj->todate($_REQUEST['t_date'])." 23:59:59'":'';
        
        $rs=$obj->simplefetch("select case when wu.user_id is null then 'Unknown' else concat(wu.user_name,'<br>( ',wu.uname,' )') end as lUser,date_format(wl.dateoflogin,'%M %d, %Y %T')as dateoflogin,ifnull(date_format(wl.dateoflogoff,'%M %d, %Y %T'),'---')as dateoflogoff,wl.ipaddress from web_loginoroffusertrail wl
LEFT JOIN web_users wu on wu.user_id=wl.userid $subQry order by wl.id DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){
                $repOn=!empty($row['rep_on'])?'<br>( '.$row['rep_on'].' )':'';
                $data[] = array(++$sNo,                                        
                    $row['lUser'],
                    $row['dateoflogin'],
                    $row['dateoflogoff'],
                    $row['ipaddress'],                    
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
    
    case 2:#Unsuccessful attempt
        $subQry='';
        $subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?" and wa.dated>='".$obj->todate($_REQUEST['f_date'])." 00:00:00'":'';
        $subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and wa.dated<='".$obj->todate($_REQUEST['t_date'])." 23:59:59'":'';
        
        $rs=$obj->simplefetch("select case when wu.user_id is null then 'Unknown' else concat(wu.user_name,'<br>( ',wu.uname,' )') end as lUser,date_format(wa.dated,'%M %d, %Y %T')as dated,wa.ipaddress from web_attempts wa
LEFT JOIN web_users wu on wu.user_id=wa.pid $subQry order by wa.sno DESC $LimitQry");
        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){                
                $data[] = array(++$sNo,                                        
                    $row['lUser'],
                    $row['dated'],                    
                    $row['ipaddress'],                    
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
    
    case 3:#user trail
        $subQry='';
        $subQry.=(isset($_REQUEST['f_date']) && !empty($_REQUEST['f_date']))?" where ut.dated >='".$obj->todate($_REQUEST['f_date'])." 00:00:00'":'';
        $subQry.=(isset($_REQUEST['t_date']) && !empty($_REQUEST['t_date']))?" and ut.dated <='".$obj->todate($_REQUEST['t_date'])." 23:59:59'":'';    
        $rs=$obj->simplefetch("select ut.actiontaken,ut.tablename,case when wu.user_id is null then 'Unknown' else concat(wu.user_name,'<br>( ',wu.uname,' )') end as lUser,concat(date_format(ut.dated,'%M %d, %Y'),' ', ut.timed)as dated,ut.ip_addr from web_user_trail ut
LEFT JOIN web_users wu on wu.user_id=ut.user_id $subQry order by ut.id DESC $LimitQry");




        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0';    
            foreach($rs[1] as $row){       
                $repOn=!empty($row['rep_on'])?'<br>( '.$row['rep_on'].' )':'';
                $data[] = array(++$sNo,
                    $row['lUser'],
                    $row['tablename'],
                    $row['actiontaken'],
                    $row['dated'],                    
                    $row['ip_addr'],
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