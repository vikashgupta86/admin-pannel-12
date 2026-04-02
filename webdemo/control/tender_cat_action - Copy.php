<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

    
    // $FielArr=array(
    //         'cat_name'=>htmlspecialchars($_REQUEST['c_name'],ENT_QUOTES),
    //         #'cat_name_h'=>htmlspecialchars($_REQUEST['hc_name'],ENT_QUOTES),
    //         'creator_id'=>$_SESSION['userid'],
    //         'creation_date'=>$obj->curdatetime(),
    //     );
        
    if(isset($_REQUEST['frmType']))
    {


        $frmVal=array(    
            "c_name|text|y|1|500|alnum_spc|Please enter Valid Name!",                  
        );
        
        $ValiStr=implode('|$$|',$frmVal);
        
        $FrmError = requestcheck($ValiStr,"formNC","div",true,true);
        if($FrmError)
        {
            $result[0]=false;
            $result[1]=$FrmError;
           // goto ComeHere;        
        }
        
        $FielArr=array(
            'cat_name'=>htmlspecialchars($_REQUEST['c_name'],ENT_QUOTES),
            #'cat_name_h'=>htmlspecialchars($_REQUEST['hc_name'],ENT_QUOTES),
            'creator_id'=>$_SESSION['userid'],
            'creation_date'=> date('Y-m-d H:i:s'),
        );
        


        switch($_REQUEST['frmType'])
        {
            case 1:#for the add          
               
                // $ChkCat = getNameQry("SELECT t_cat_id FROM web_tender_category WHERE status='Active' AND app_reject is null AND lower(trim(cat_name)) = lower(trim('$_REQUEST[c_name]'))");

                $ChkCatquery = "SELECT t_cat_id FROM web_tender_category WHERE status='Active' AND app_reject is null AND lower(trim(cat_name)) = ? ";
                $ChkCat simplefetch($ChkCatquery, "s", lower(trim($_REQUEST['c_name'])));

                if(!empty($ChkCat)){
                    $result[2]=array(true,'Requested Category already exist!','alert-info');
                    goto ComeHere;                                                        
                }

            break;
            case 2:#update
                //$ChkCat=$obj->getNameQry("select t_cat_id from web_tender_category where status='Active' and app_reject is null and t_cat_id!=$_REQUEST[t_cat_id] and lower(trim(cat_name))=lower(trim('$_REQUEST[c_name]'))");

                $ChkCatquery = "SELECT t_cat_id FROM web_tender_category WHERE status='Active' AND app_reject is null AND t_cat_id != ? AND lower(trim(cat_name)) = ? ";
                $ChkCat simplefetch($ChkCatquery, "is", $_REQUEST['t_cat_id'],  lower(trim($_REQUEST['c_name'])));

                if(!empty($ChkCat)){
                    $result[2]=array(true,'Requested Category already exist!','alert-info');
                    goto ComeHere;                                                        
                }
            break;
        }
    }    
    
    
    if(isset($_REQUEST['frmType']))
    {
        switch($_REQUEST['frmType']){
            case 1:#for the add                
                $Fields=implode(',',array_keys($FielArr));
                $Values=implode("|$$|",$FielArr);
                
               // $success=$obj->insert("web_tender_category",$Fields,$Values);

                $tndrcat = "INSERT INTO web_tender_category (cat_name, creator_id, creation_date) VALUES (?, ?, '1970-01-01 00:00:00')";
                $success = simplefetchUA($tndrcat, "sis", [$_REQUEST['c_name'], $_SESSION['userid'], date('Y-m-d H:i:s')]);

            break;
            case 2:#update
                    
                   // $success=$obj->update("web_tender_category",$Fields,$Values,"t_cat_id=$_REQUEST[t_cat_id]");

                    $updatetndrcat = "UPDATE web_tender_category SET cat_name = ?, creator_id = ?, creation_date = ? WHERE t_cat_id = ?";

                    $success = simplefetchUA($updatetndrcat, "sisi", [$_REQUEST['c_name'], $_SESSION['userid'], date('Y-m-d H:i:s'), $_REQUEST['t_cat_id']]);
            break;
            
            case 3:
                $deletetndrcat = "DELETE FROM web_tender_category WHERE t_cat_id = ?";

                $success = simplefetchUA($deletetndrcat, "i", [$_REQUEST['t_cat_id']]);

               // $success=$obj->delete("web_tender_category","t_cat_id=$_REQUEST[t_cat_id]");
            break;
        }
    }
    
    
    
if($success)
$result[0]=true;

//ComeHere:
echo frm_response($result);