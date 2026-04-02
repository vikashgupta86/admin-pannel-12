<?php 


    $serverValidate = BASE_PATH . '/appcode/serverValidate.inc.php';
    if (is_file($serverValidate) && is_readable($serverValidate)) {
        include_once $serverValidate;
        if (function_exists('checks_init')) {
            $chk = checks_init();
        } elseif (function_exists('run_checks')) {
            $chk = run_checks();
        }
    }
    $chk = new checks();


$GLOBALS['csrf']['token'] = "'{$GLOBALS['csrf']['input-name']}':'".csrf_get_tokens()."'";#for ajax request implemented


$title='Content Management System';




if(!in_array(trim(strtolower(curPageName(false))),array('login','login_action','resetpass')))
    $LinkPermission=GetPermission($_REQUEST['per_id'] ?? '');
 /*echo 'PerID:'.$_REQUEST['per_id'].'<br>';
 echo '<pre>';print_r($LinkPermission);*/

 function GetD_cont($Data,$id){
    global $obj;
    
    if(strpos($Data,'#rec_type#')>0){
        $InsTot=$obj->getNameQry("SELECT recruitment_name FROM app_job_recruitment_breakup rb inner join app_ms_recruitment_type rt on rt.recruit_id=rb.recruit_id where rt.status='Active' and rb.status='Active' and rb.notif_id=$id");
        $Data = str_replace('#rec_type#',$InsTot , $Data);//implement dynamic total of institutes    
    }    
    if(strpos($Data,'#pay_band#')>0){
        $InsTot=$obj->getNameQry("SELECT pay_scale FROM app_ms_job_sub_notification js inner JOIN app_ms_pay_scale ps on ps.pay_scale_id=js.pay_scale_id where js.status='Active' and js.notif_id=$id");
        $Data = str_replace('#pay_band#',$InsTot , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#grade_pay#')>0){
        $InsTot=$obj->getNameQry("SELECT g_pay FROM app_ms_job_sub_notification where status='Active' and notif_id=$id");
        $Data = str_replace('#grade_pay#',$InsTot , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#end_date#')>0){
        $InsTot=$obj->getNameQry("SELECT date_format(e_date,'%d.%m.%Y') as end_date FROM app_ms_job_notification where status='Active' and notif_id=$id");
        $Data = str_replace('#end_date#',$InsTot , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#max_age#')>0){
        $InsTot=$obj->getNameQry("SELECT max_age FROM app_ms_job_sub_notification where status='Active' and notif_id=$id");
        $Data = str_replace('#max_age#',$InsTot , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#job_exp#')>0){
        $InsTot=$obj->getNameQry("SELECT tot_year_exp FROM app_job_general_eligibility where status='Active' and notif_id=$id");
        $Data = str_replace('#job_exp#',$InsTot , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#PostGrid#')>0){
        ?>
        <table class="GridTable" style="width: 99%;">
            <thead>
                <tr>
                    <td>Name of post</td>
                    <td>Number of post</td>
                    <td>Pay Band and Grade Pay</td>
                    <td>Method of recruitment</td>
                </tr>
            </thead>
            <tbody>
              <?php
              $rs = simplefetch("select *
                from app_ms_job_notification n
                INNER JOIN (select * from app_ms_job_sub_notification where `status`='Active') sn on sn.notif_id=n.notif_id
                INNER JOIN app_ms_pay_scale ps on ps.pay_scale_id=sn.pay_scale_id and ps.status='Active'
                INNER JOIN app_ms_designation d on d.desig_id=sn.desig_id and d.status='Active'
                INNER JOIN app_job_recruitment_breakup rb on rb.desig_id=d.desig_id and rb.status='Active'
                inner join app_ms_recruitment_type rt on rt.recruit_id=rb.recruit_id and rt.status='Active'

                WHERE n.status='Active' and n.notif_status=1 and n.notif_id= ?;", "i", [$id]);
              ob_start();
              if($rs[0]>0){
                foreach($rs[1] as $rowJ);
                ?>
                
                <tr style="text-align: center;">
                    <td><?php echo $rowJ['desig_name']; ?></td>
                    <td><?php echo $rowJ['reserve_post']; ?></td>
                    <td><?php echo $rowJ['abrivation'].' Rs. ('.$rowJ['pay_scale'].')<br/>with Grade Pay Rs. '.$rowJ['g_pay'] ; ?></td>
                    <td><?php echo $rowJ['recruitment_name']; ?></td>
                </tr>
                <?php
                  //echo "<br/>";
                ?>
            </tbody>
        </table>
        <?php                  
    }
    $TempGrid = ob_get_clean();
    
    $Data = str_replace('#PostGrid#',$TempGrid , $Data);
    
}   
if(strpos($Data,'#plac_wom_arch#')>0){
    $reg_stat=4;
    if(!file_exists('include/reg_statistical.inc.php'))            
        echo 'File Not found';  
        ob_start(); //Init the output buffering                    
        include('include/reg_statistical.inc.php');
        $Content = ob_get_clean();
        $Data = str_replace('#plac_wom_arch#',$Content , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#ratio_arch#')>0){
        $reg_stat=5;
        if(!file_exists('include/reg_statistical.inc.php'))            
            echo 'File Not found';  
        ob_start(); //Init the output buffering                    
        include('include/reg_statistical.inc.php');
        $Content = ob_get_clean();
        $Data = str_replace('#ratio_arch#',$Content , $Data);//implement dynamic total of institutes    
    }
    if(strpos($Data,'#yearwise_arch#')>0){
        $reg_stat=6;
        if(!file_exists('include/reg_statistical.inc.php'))            
            echo 'File Not found';  
        ob_start(); //Init the output buffering                    
        include('include/reg_statistical.inc.php');
        $Content = ob_get_clean();
        $Data = str_replace('#yearwise_arch#',$Content , $Data);//implement dynamic total of institutes    
    }   
    return $Data;
}


function rtfPathManage(&$paratext,$forDB=true,$encodeDecodeFlage=true){
    global $obj;    
    if($forDB){ //echo "check";
        $paratext = html_entity_decode($paratext);     
        if (preg_match('~<body[^>]*>(.*?)</body>~si', $paratext, $data)){
            $paratext=$data[1];                        
        }        
        $paratext=str_replace(base_url(),"",$paratext);
        $paratext=($encodeDecodeFlage)?htmlspecialchars($paratext,ENT_QUOTES):$paratext;            
        
    }
    else{
        $paratext=str_replace('/WriteReadData',base_url().'/WriteReadData',$paratext ?? '');
        $paratext=($encodeDecodeFlage)?html_entity_decode($paratext):$paratext;
    }
    #($forDB)?str_replace($obj->base_url(),"",$paratext):str_replace('WriteReadData/',$obj->base_url().'/WriteReadData/',$paratext);    
}


function showChild($parent_lsID,$level,$Lid,$perID){
    #echo "Level:".$level.">>>LinkId:".$Lid.">>>ParentLSid:".$parent_lsID.">>>>>perID:".$perID;        
    if(!empty($S_lid) && $level>0)
        $parent=$S_lid;
    else
        $parent=$M_lid ?? '';
    
    $NewLevel=($level+1);
   
    $rs1=simplefetch("select ls.link_level,nls.tot,wlt.type_id,case when ls.position is null then '9999999999' else ls.position end as newPos,ls.ls_id,ls.pos_id,ls.position,ls.uplink,ls.up_position, lf.lid,lt.type,l.lang,wlt.link_name from web_links_final lf
        INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id
        INNER JOIN web_lang l on l.lang_id=wlt.lang_id
        INNER JOIN web_link_type lt on lt.type_id=wlt.type_id
        INNER JOIN web_links_structure ls on ls.lid=lf.lid
        LEFT JOIN (select count(ls_id)as tot,parent_ls_id from web_links_structure where STATUS='Active' and parent_ls_id is not null GROUP BY parent_ls_id) nls on nls.parent_ls_id=ls.ls_id
        where lf.`status`='Active' and ls.status='Active' and wlt.continuous_content=0 and ls.link_level=$NewLevel and ls.parent_ls_id=$parent_lsID order by lt.type,newPos, wlt.link_name");
    if($rs1[0]>0){
        ?>
        <tr>
            <td style=""><?php //echo "Level: $level TableID:".$level.$parent_lsID?>
            <table style="margin-left: 30px; display: none;" class="maintab" id="tab_<?php echo $level.$parent_lsID?>" cellpadding="3" cellspacing="2" bordercolor="lightgrey">
                <?php
                foreach($rs1[1] as $row1){
                    $SetSubClass=$expClass=$glypIcon=$imgName='';
                    switch($row1['type_id']){
                        case 1:
                        $SetSubClass='btn--btn-sm text-secondary disabled none';
                        $imgName='assets/images/no_sub.gif';
                        $glypIcon='<i class="fas fa-file-alt ms-1" aria-hidden="true">';
                        break;
                        
                        case 2:
                        $SetSubClass='btn--btn-sm text-secondary disabled none';
                        $imgName='assets/images/no_sub.gif';
                        $glypIcon='<i class="fa fa-location-arrow ms-1" aria-hidden="true"></i>';
                        break;
                        
                        case 3:
                        $expClass='showTab';
                        $SetSubClass='enable setSubLink';
                        $imgName='assets/images/expand.gif';
                        $glypIcon='<i class="fa fa-desktop ms-1" aria-hidden="true"></i>';
                        break;
                        
                    }
                    if(empty($row1['tot'])){
                        $imgName='assets/images/no_sub.gif';
                    }
                    ?>                                
                    <tr style="vertical-align: middle;">
                        <?php
                        
                        ?>
                        <td class="align-middle"><?php //echo "Level: $NewLevel ImageID:".$NewLevel.$row1['ls_id'] ?>                                
                        <input type="image" src="<?php echo $imgName;?>" alt="View List" title="View List" id="img_<?php echo $NewLevel.$row1['ls_id'] ?>" data-id="<?php echo $NewLevel.$row1['ls_id'] ?>" class="<?php echo $expClass;?>" />&nbsp;
                        <span class="<?php echo $SetSubClass;?>"  href="#" data-lsid="<?php echo $row1['ls_id']?>" link-levl="<?php echo $row1['link_level']?>" link-lid="<?php echo $row1['lid']?>" title="<?php echo html_entity_decode($row1['link_name'])?>"><?php echo html_entity_decode($row1['link_name'])?><?php echo $glypIcon; ?></span>
                    </td> 
                    <?php   
                    showChild($row1['ls_id'],$row1['link_level'],$row1['lid'],$perID);     
                    
                    ?>
                </tr>
                <?php                                
            }
            ?>    
        </table>
    </td>
</tr>
<?php
}
}

?>