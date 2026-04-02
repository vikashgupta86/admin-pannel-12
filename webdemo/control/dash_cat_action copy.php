<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$Fman=$_REQUEST['frmType']==2 ? 'n' : 'y';

$Fman1=$_REQUEST['frmType']==3 ? 'n' : 'y';

    
    $FielArr=array(
            'prog_name'=>htmlspecialchars($_REQUEST['c_name'],ENT_QUOTES),
            'prog_name_hin'=>htmlspecialchars($_REQUEST['hc_name'],ENT_QUOTES),
            'entry_by'=>$_SESSION['userid'],
            'entry_date'=>date('Y-m-d H:i:s'),
            'ip_addr' => $_SERVER['REMOTE_ADDR'],
        );

    //var_dump($FielArr);
        
    if(isset($_REQUEST['frmType'])){
        switch($_REQUEST['frmType']){
            case 1:#for the add                
                $ChkCat=getNameQry("SELECT prog_id FROM web_dash_prog WHERE status='Active' AND lower(trim(prog_name))=lower(trim('$_REQUEST[c_name]'))");
                if(!empty($ChkCat)){
                    $result[2]=array(true,'Requested Category already exist!','alert-info');
                    goto ComeHere;                                                        
                }
            break;
            case 2:#update
                $ChkCat=getNameQry("SELECT prog_id FROM web_dash_prog WHERE status='Active' AND prog_id != ".$_REQUEST['prog_id']." AND lower(trim(prog_name))=lower(trim('$_REQUEST[c_name]'))");
                if(!empty($ChkCat)){
                    $result[2]=array(true,'Requested Category already exist!','alert-info');
                    goto ComeHere;                                                        
                }
            break;
        }
    }    
    
    if(isset($_REQUEST['frmType'])){

        switch($_REQUEST['frmType']){
            case 1:#for the add                
                
                //$success=insert("web_dash_prog",$Fields,$Values);
                $insertRes = insert("web_dash_prog", $FielArr, 1);
                $success = ($insertRes !== false);

            break;
            case 2:#update
                /*$ChkCat=simplefetch("SELECT pc.m_cat_id,pc.img_name from web_media_category pc
                WHERE pc.`status`='Active' and pc.app_reject=1 and pc.m_cat_id=$_REQUEST[m_cat_id]");
                if($ChkCat[0]<=0){*/

                    //$success=update("web_dash_prog",$Fields,$Values,"prog_id=$_REQUEST[prog_id]");

                    $prg_id = (int)$_REQUEST['prog_id'];

                    $success = update(
                        "web_dash_prog",
                        $FielArr,
                        "prog_id = $prg_id",
                        1
                    );
                /*}
                else{
                    $FielArr=array_merge($FielArr,array(
                        'old_m_cat_id'=>$_REQUEST['m_cat_id'],
                    ));
                    if(!isset($FielArr['img_name']) || empty($FielArr['img_name']))
                        $FielArr['img_name']=$ChkCat[1][0]['img_name'];
                                         
                    $Fields=implode(',',array_keys($FielArr));
                    $Values=implode("|$$|",$FielArr);
                    
                    $success=insert("web_media_category",$Fields,$Values);
                }*/
                
            break;
            
            case 3:
            
               // $success=delete("web_dash_prog","prog_id=$_REQUEST[prog_id]");

                $prg_id = (int)$_REQUEST['prog_id'];

                $success = delete(
                    "web_dash_prog",
                    "prog_id = $prg_id",
                    1
                );

            break;
        }
    }
    
    
    
if($success)
$result[0]=true;

//ComeHere:
//echo frm_response($result);
var_dum($result);