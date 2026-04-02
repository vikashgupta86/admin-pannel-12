<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);

$Fman=$_REQUEST['frmType']==2 ? 'n' : 'y';

$Fman1=$_REQUEST['frmType']==3 ? 'n' : 'y';

    
    $FielArr=array(
            'prog_id' => $_REQUEST['dash_cat_id'],
            'attribute_name' => htmlspecialchars($_REQUEST['prog_name'],ENT_QUOTES),
            'attribute_name_hin' => htmlspecialchars($_REQUEST['prog_name_h'],ENT_QUOTES),
            'value_type' => htmlspecialchars($_REQUEST['value_type'],ENT_QUOTES),
            'value_type_hin' => htmlspecialchars($_REQUEST['value_type_h'],ENT_QUOTES),
            'value' => $_REQUEST['value_num'],
            'entry_id' => $_SESSION['userid'],
            'entry_date' => date('Y-m-d H:i:s'),
        );
        
    if(isset($_REQUEST['frmType'])){
        switch($_REQUEST['frmType']){
            case 1:#for the add                
                $ChkCat=getNameQry("SELECT prog_data_id FROM web_dash_prog_data WHERE status='Active' AND lower(trim(attribute_name))=lower(trim('$_REQUEST[prog_name]'))");
                if(!empty($ChkCat)){
                    $result[2]=array(true,'Requested Name already exist!','alert-info');
                    goto ComeHere;                                                        
                }
            break;
            case 2:#update
                $ChkCat=getNameQry("SELECT prog_data_id FROM web_dash_prog_data WHERE status='Active' AND prog_data_id != ".$_REQUEST['prog_data_id']." AND lower(trim(attribute_name)) = lower(trim('$_REQUEST[prog_name]'))");
                if(!empty($ChkCat)){
                    $result[2]=array(true,'Requested Name already exist!','alert-info');
                    goto ComeHere;                                                        
                }
            break;
        }
    }    
    
    if(isset($_REQUEST['frmType'])){

        switch($_REQUEST['frmType']){
            case 1:#for the add                
                $Fields=implode(',',array_keys($FielArr));
                $Values=implode("|$$|",$FielArr);
                
                //$success=insert("web_dash_prog_data",$Fields,$Values);

                $insertRes = insert("web_dash_prog_data", $FielArr, 1);
                $success = ($insertRes !== false);

            break;
            case 2:#update
                
                    //$success=update("web_dash_prog_data",$Fields,$Values,"prog_data_id=$_REQUEST[prog_data_id]");

                    $prog_data_id = (int)$_REQUEST['prog_data_id'];

                    $success = update(
                        "web_dash_prog_data",
                        $FielArr,
                        "prog_data_id = $prog_data_id",
                        1
                    );
                
                
            break;
            
            case 3:
            
                //$success=delete("web_dash_prog_data","prog_data_id=$_REQUEST[prog_data_id]");

                $prg_did = (int)$_REQUEST['prog_data_id'];

                $success = delete(
                    "web_dash_prog_data",
                    "prog_data_id = $prg_did",
                    1
                );

            break;
        }
    }
    
    
    
if($success)
$result[0]=true;

// ComeHere:
// echo frm_response($result);

var_dump($result);