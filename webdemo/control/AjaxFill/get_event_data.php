<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data=array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry=$sspObj->limit($_GET);

// $usr_session='';
// if($_SESSION['user_type'] =='20'){

//      $usr_session= " and (t.entry_by='".$_SESSION['userid']."' || t.nmnh_type='".$_SESSION['musume_type']."')";
// }

$rs=$obj->simplefetch("select em.*,mu.nmnh_type from event_master as em left join nmnh_type as mu on mu.id=em.center_id where em.status='active' order by em.event_id desc $LimitQry");

        if($rs[0]>0){
            $sNo=(!empty($_REQUEST['start']))?intval($_REQUEST['start']):'0'; 
           


             
            foreach($rs[1] as $row){
            if($row['center_id']!=0) { 
              $mu=$row['nmnh_type'];
            }
            else{
              $mu="National Museum of Natural History";
            }


            if(strpos($row['class_group_id'], ',') !== false ) {

              $st=explode(",",$row['class_group_id']);
              $class_group='';
              foreach($st as $v){
               $class_group1=$obj->getNameQry("select class_group from class_group where id ='".$v."'");
               $class_group.="<br>".$class_group1;
            }


              $class_group=ltrim($class_group,'<br>');

            }
            else{

              $class_group=$obj->getNameQry("select class_group from class_group where id='".trim($row['class_group_id'])."'");
            }

            //start registration date
            $reg=date('d-m-Y', strtotime($row['registration_start_date'])).' / '.date('d-m-Y', strtotime($row['registration_end_date']));

                $data[] = array(++$sNo,
                    $row['cat_id'],
                     $row['event_name_v'],
                    $class_group,
                    $mu,
                       date('d-m-Y', strtotime($row['date_from'])),
                       date('d-m-Y', strtotime($row['publish_date'])), 
                       $reg,
                       $row['status'], 

                                   
                    "<div class=\"text-center tools\">
                        <i class=\"fa fa-edit\" data-toggle=\"tooltip\" cdata-frmT='2' pub-lid='$row[event_id]' data-link_temp_id='$row[event_id]' title='Modify Details'></i>
                        <i class=\"fa fa-trash-o\" data-toggle=\"tooltip\"  cdata-frmT='3' data-link_temp_id='$row[event_id]' title='Delete User'></i>                      
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
$resData=array(
    "draw"=>isset ( $request['draw'] ) ?intval( $request['draw'] ) :0,
    "recordsTotal"  => intval( $recordsTotal ),
	"recordsFiltered"  => intval( $recordsFiltered ),
	"data" =>  $data
);
echo $obj->frm_response($resData,true,false);