<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
// if(isset($_REQUEST['frmType'])&& $_REQUEST['frmType']==1){
//     $frmVal=array(        
//         "link_pubDate|text|y|10|10|dt|Please enter/ select Valid Date!",
//         "link_expDate|text|n|10|10|dt|Please enter/ select Valid Date!",
//         "link_nrevDate|text|n|10|10|dt|Please enter/ select Valid Date!",
//     );
//     $ValiStr=implode('|$$|',$frmVal);
//     $FrmError=$chk->requestcheck($ValiStr,"formNC","div",true,true);
//     if($FrmError[0]){
//         $result[0]=false;
//         $result[1]=$FrmError;
//         goto ComeHere;        
//     }
// }

if(isset($_REQUEST['frmType'])){
    switch($_REQUEST['frmType']){
        case 1:
            /*$ChkModule=$obj->getNameQry("select link_temp_id from web_link_temp where status='Active' and trim(lower(link_name))=trim(lower('$_REQUEST[l_name]'))");
            if(!empty($ChkModule)){
                $result[2]=array(true,'Requested Link Name already exist!','alert-info');
                goto ComeHere;                                                        
            }*/
            $FielArr=array(
                't_temp_id'=>$_REQUEST['t_temp_id'],
                't_id'=>$_REQUEST['t_id'],                
                'publish_date'=>!empty($_REQUEST['link_pubDate'])? $_REQUEST['link_pubDate']:'',                               
                'expiry_date'=>!empty($_REQUEST['link_expDate'])? $_REQUEST['link_expDate']:'',
                'next_review_date'=>!empty($_REQUEST['link_nrevDate'])? $_REQUEST['link_nrevDate']:'',                                                
                'publish_by'=>$_SESSION['userid'],
                /*'publish_date'=>$obj->curdatetime()*/ 
                'publish_time'=>$_REQUEST['ptime'],
                'expiry_time'=>$_REQUEST['ctime'],
				              
            );
            
            
            $lid=getName("web_tender_temp","concat(ifnull(ct_id,''),'|$$|',ifnull(t_id,''),'|$$|',ifnull(main_t_temp_id,''))as str","corrigendum=1 and t_temp_id= ".$_REQUEST['t_temp_id']."");
           // $lid=explode('|$$|',$lid);            
            if(empty($lid[0])){
               
               // $success=$obj->insert("web_tender_corrigendum_final",$Fields,$Values);  
                $success = insert("web_tender_corrigendum_final", $FielArr, 1);   
                
              //  var_dump($success); die();
            }
            else{
                
               // $success=$obj->update("web_tender_corrigendum_final",$Fields,$Values,"ct_id=$lid[0]");

               $tmpid = $lid[0];
                $success = update("web_tender_corrigendum_final", $FielArr, "ct_id = $tmpid", 1 );
            }
            
            if($success){
				
                $cDate= date('Y-m-d H:i:s');
				$publish_date=!empty($_REQUEST['link_pubDate'])? $_REQUEST['link_pubDate']:'';   
				$publish_time=$_REQUEST['ptime'];
				$expiry_date=!empty($_REQUEST['link_expDate'])? $_REQUEST['link_expDate']:'';
				$expiry_time=$_REQUEST['ctime'];
				

                //$obj->update("web_tender_temp","publish_by|$$|publish_on","$_SESSION[userid]|$$|$cDate","t_temp_id=$_REQUEST[t_temp_id]");

                $tmpid = $_REQUEST['t_temp_id'];
                $updatetndrcat = "UPDATE web_tender_temp SET publish_by = ?, publish_on = ? WHERE t_temp_id = ? ";
                $success = simplefetchUA($updatetndrcat, "iisiii", [$_SESSION['userid'], $cDate, $tmpid]);

                /*$obj->update("web_tender_final","expiry_date|$$|expiry_time","$expiry_date|$$|$expiry_time","t_id=$_REQUEST[t_id]");*/

               // $obj->update("web_tender_final","expiry_date|$$|expiry_time|$$|publish_date|$$|publish_time","$expiry_date|$$|$expiry_time|$$|$publish_date|$$|$publish_time","t_id=$_REQUEST[t_id]");

               $tid = $_REQUEST['t_id'];
                    $updatetndrcat = "UPDATE web_tender_final SET expiry_date = ?, expiry_time = ?, publish_date = ?, publish_time = ? WHERE t_id = ? ";
                    $success = simplefetchUA($updatetndrcat, "ssssi", [$expiry_date, $expiry_time, $publish_date, $publish_time, $tid]);
				
            }            
        break;
    }
}

if($success)
    $result[0]=true;

//ComeHere:
echo frm_response($result);
?>