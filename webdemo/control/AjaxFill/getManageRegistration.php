<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

// $usr_session='';
// if($_SESSION['user_type'] =='20'){

//      $usr_session= " and (t.nmnh_type='".$_SESSION['musume_type']."')";
// }




switch($_REQUEST['tabID']){
    case 1:#pending links

      

$rs=$obj->simplefetch("select * from register where admin_approved_status='pending' order by id desc $LimitQry");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
            
            $reg_type=array("1"=>"School","2"=>"Student","3"=>"Department");  
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $reg_type[$row['regtype']],
                    $row['Guardian'], 
                    $row['dob'],
                    $row['cname'],
                    $row['school'],
                    $row['student'],
                    $row['phone'],
                    $row['email'],
                    $row['address'],
                    $row['dep_name'],
                    $row['entry_date'],
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
        $rs=$obj->simplefetch("select r.*,u.user_name from register as r  left join web_users as u on u.user_id=r.entry_by where admin_approved_status='approved' order by id desc $LimitQry");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
             $reg_type=array("1"=>"School","2"=>"Student","3"=>"Department");    
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $reg_type[$row['regtype']],
                    $row['Guardian'], 
                    $row['dob'],
                    $row['cname'],
                    $row['school'],
                    $row['student'],
                    $row['phone'],
                    $row['email'],
                    $row['address'],
                    $row['dep_name'],
                    $row['entry_date'],
                    $row['user_name'],
                     "<div class=\"text-center tools\">
                        
                        <i class=\"fa fa-remove\" cdata-frmT='3' data-id='$row[id]' title='Reject'></i> 
                        <i class=\"fa fa-key\" cdata-frmT='5' data-id='$row[id]' title='Reset Password'></i> 
                              <input type='hidden' name='em_hidd' id='em_hidd$row[id]' value='$row[email]'>                 
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
         $rs=$obj->simplefetch("select r.*,u.user_name from register as r  left join web_users as u on u.user_id=r.entry_by where admin_approved_status='notapproved' order by id desc $LimitQry");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
            $reg_type=array("1"=>"School","2"=>"Student","3"=>"Department");    
            foreach($rs[1] as $row){
                $data[] = array(++$sNo,
                    $reg_type[$row['regtype']],
                    $row['Guardian'], 
                    $row['dob'],
                    $row['cname'],
                    $row['school'],
                    $row['student'],
                    $row['phone'],
                    $row['email'],
                    $row['address'],
                    $row['dep_name'],
                    $row['entry_date'],
                    $row['user_name'],
                     "<div class=\"text-center tools\">
                        <i class=\"fa fa-check-circle-o\" cdata-frmT='4' data-id='$row[id]' title='Approve'></i>
                                               
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