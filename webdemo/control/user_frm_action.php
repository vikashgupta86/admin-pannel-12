<?php include '../appcode/globals.inc.php';
include_once(dirname_r(__FILE__, 1) .'/include/include.inc.php');
AjaxFilePrevent();
userAuthenticationPageLevel();
$result=array(0=>false);
if (in_array($_REQUEST['frmType'], array(1, 2))) {
    $frmVal = array(
        "user_type_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!",
        "f_name|text|y|1|50|alnum_s|Please enter Valid First  Name!",
        "m_name|text|n|1|50|alnum_s|Please enter Valid Middle Name!",
        "l_name|text|y|1|50|alnum_s|Please enter Valid Last Name!",
        "address|textarea|n|1|2000|alnum_spc|Please enter Valid Source!",
        "state_id|text|n|1|10|num|dontselect=-1|Please enter Valid option!",
        "district_id|text|n|1|10|num|dontselect=-1|Please enter Valid option!",
        "pincode|text|n|6|10|alnum_spc|Please enter Valid Pincode!",
        "c_landline|text|n|1|5|num|Please enter Valid Number!",
        "landline|text|n|8|10|num|Please enter Valid Number!",
        "c_fax|text|n|1|5|num|Please enter Valid Number!",
        "fax|text|n|8|10|num|Please enter Valid Number!",
        "mob|text|n|10|11|num|Please enter mobile number !",
        "Demail|text|n|1|100|email|Please enter Proper Email!",
    );
    $other_degi = "";

    

    if(!in_array($_REQUEST['user_type_id'], array(1,2,4,8,9)))
    {
        $frmVal = array_merge($frmVal, array(
            "desig_id|text|n|1|10|num|dontselect=-1|Please enterf Valid option!"));
        $desig_id =$_REQUEST['desig_id'];
    }
 if(in_array($_REQUEST['user_type_id'], array(8)))
    {
        $frmVal = array_merge($frmVal, array(
            "department|text|y|1|10|num|dontselect=-1|Please enter Valid option!"));
        
    }

    if($_REQUEST['desig_id']==1)
    {
        $frmVal = array_merge($frmVal, array(
            "other_degi|text|y|1|50|alnum_spcA|Please enter Valid other designation Name!"));
        $other_degi =$_REQUEST['other_degi'];
    }

    $ValiStr = implode('|$$|', $frmVal);
    $FrmError = $chk->requestcheck($ValiStr, "formNC", "div", true);
    if ($FrmError) {
        $result[0] = false;
        $result[1] = $FrmError;
        goto ComeHere;
    }
}


if(isset($_REQUEST['frmType'])){
    //if ($_ENV['APPMOD'] == 'Developing') {
    if (isset($_ENV['APPMOD']) && $_ENV['APPMOD'] == 'Developing') {
        // Check if DEV_PASS exists, otherwise use a default like '123456'
        $devPassword = $_ENV['DEV_PASS'] ?? 'ADMIN!@12';
		$Pass = array($devPassword, hash('sha256', $devPassword));
        
        //$Pass = array($_ENV['DEV_PASS'], hash('sha256', $_ENV[DEV_PASS]));
		
    } else {
        $Pass = generatePassword();
    }

    $FielArr=array(
        'uname' => ($_REQUEST['Demail'] ?? ''),                    
        'user_type_id'   => ($_REQUEST['user_type_id'] ?? ''),
        'created_on' => curdatetime(),
        'created_by' => $_SESSION['userid']
    );

    $FielArr1 = array(
        'f_name'        => ($_REQUEST['f_name'] ?? ''),
        'm_name'        => ($_REQUEST['m_name'] ?? ''),
        'l_name'        => ($_REQUEST['l_name'] ?? ''),
        'addr'          => ($_REQUEST['address'] ?? ''),
        'state_id'      => ($_REQUEST['state_id'] ?? ''),                
        'district_id'   => ($_REQUEST['district_id'] ?? ''),
        'pincode'       => ($_REQUEST['pincode'] ?? ''),
        'mobile'        => ($_REQUEST['mob'] ?? ''),
        'std_code'      => ($_REQUEST['c_landline'] ?? ''),
        'landline'      => ($_REQUEST['landline'] ?? ''),    
        'f_std_code'    => ($_REQUEST['c_fax'] ?? ''),
        'f_landline'    => ($_REQUEST['fax'] ?? ''),

    );

$userLog = trim($_REQUEST['user_log'] ?? '');


    switch($_REQUEST['frmType']){
        case 1:
        $ChkModule=getNameQry("select user_id from web_users where status='Active' and lower(trim(uname))=lower(trim(" . $userLog . "))");
        if(!empty($ChkModule)){
            $result[2]=array(true,'Requested Login-ID already exist!','alert-info');
            goto ComeHere;                                                        
        }

        if(isset($other_degi) && $other_degi !='' ){ 
            $isdegi = getNameQry("select desig_id from web_st_designation where status='Active' and lower(trim(designation))=lower(trim('$other_degi'))");

            if(!empty($isdegi)){  
                $isUserTypeApp = getNameQry("select designation from web_st_designation where status='Active' AND FIND_IN_SET($_REQUEST[user_type_id],applicable_for)  and lower(trim(designation))=lower(trim('$other_degi')) ");

                if(empty($isUserTypeApp))
                    {   $applicable_for = getNameQry("select applicable_for from web_st_designation where status='Active' and lower(trim(designation))=lower(trim('$other_degi'))");

                $applFor = $applicable_for.','.$_REQUEST['user_type_id'];
                update("web_st_designation", "applicable_for", $applFor, "desig_id=$isdegi");
            }
            $desig_ids  = $isdegi;
        }else{


            $FielArrU = array(
                'designation' => $other_degi,
                'applicable_for' =>$_REQUEST['user_type_id'],
                'created_on' => curdatetime(),
            );
                         //print_r($FielArrU); die();
            $Fields = implode(',', array_keys($FielArrU));
            $Values = implode("|$$|", $FielArrU);
            $successU = insert("web_st_designation", $Fields, $Values);
            $desig_ids  = $successU[0];
        }
    }else{
        $desig_ids  = $desig_id;
    }

        $FielArr['password']   = $Pass[1];
        $FielArr['my_val']     = $Pass[0];
        $FielArr['desig_id']   = $desig_ids;
        $FielArr['department'] = $_REQUEST['department'] ?? '';

        $success = insert("web_users", $FielArr);
    if($success){
        $FielArr1['user_id'] = $success[0];

        insert("web_users_profile", $FielArr1);
        ###########################
        $submodule = array();
        switch ($_REQUEST['user_type_id']) {
            case '99':#user as department

            break;

            default:
                /*//if user created by super, admin then extra permission assigned to outside department users
                if(in_array($_SESSION['user_type'], array('1', '2')) && !in_array($_SESSION['user_type'], array('12', '13', '14'))){
                    $submodule = array_merge($submodule, array(
                        '7' => array('1', '2'),
                        '20' => array('1', '2', '5'),
                    ));
                }*/
                break;
            }

            // AssignAutoPer($_REQUEST['user_type_id'], $success[0], $submodule);
        ##########################                    
            $rsu = simplefetch("select u.uname, concat(up.f_name,' ',ifnull(up.m_name,''),' ',ifnull(up.l_name,'')) as name from web_users u
                INNER JOIN web_users_profile up on u.user_id=up.user_id where u.status='Active' and u.user_id=$success[0]");
            if ($rsu[0] > 0) {
                foreach ($rsu[1] as $row);
                $emailID = strtolower(trim($row['uname']));
                $UserName = $row['name'];
                $UserName = ucwords($UserName);
                $msg = "Dear $UserName, <br><br>You have been registered on <b>\"http://defenceexim.gov.in\"</b>. Following are the login details.<br><br>USERNAME: <font size='+2'><b>$emailID</b></font><br><br>PASSWORD:<font size='+2'><b>$Pass[0]</b></font>
                <br><br><br><br>

                Regards <br>Tech Support Team<br>";
                $sub = "Login Credentials for $_ENV[APP_NAME] Portal";
                        // $emailID = 'sanjaykumar_comat@yahoo.com';
                send_mail($emailID, $msg, $sub);
            }
        }
        break;

        case 2:
        $ChkModule = getNameQry("select user_id from web_users where status='Active' and user_id!=$_REQUEST[user_id] and lower(trim(uname))=lower(trim('$_REQUEST[Demail]'))");
        if (!empty($ChkModule)) {
            $result[2] = array(true, 'Requested Login-ID already exist!', 'alert-info');
            goto ComeHere;
        }

        if(isset($other_degi) && $other_degi !='' ){
            $isdegi = getNameQry("select desig_id from web_st_designation where status='Active' and lower(trim(designation))=lower(trim('$other_degi'))");

            if(!empty($isdegi)){
                $isUserTypeApp = getNameQry("select designation from web_st_designation where status='Active' AND FIND_IN_SET($_REQUEST[user_type_id],applicable_for)  and lower(trim(designation))=lower(trim('$other_degi')) ");
        //echo $isUserTypeApp; die();
                if(empty($isUserTypeApp)){
                    $applicable_for = getNameQry("select applicable_for from web_st_designation where status='Active' and lower(trim(designation))=lower(trim('$other_degi'))");

                    $applFor = $applicable_for.','.$_REQUEST['user_type_id'];
                    update("web_st_designation", "applicable_for", $applFor, "desig_id=$isdegi");
                }
                $desig_ids  = $isdegi;
            }
            else{
                $FielArrU = array(
                    'designation' => $other_degi,
                    'applicable_for' =>$_REQUEST['user_type_id'],
                    'created_on' => curdatetime(),
                );
                $Fields = implode(',', array_keys($FielArrU));
                $Values = implode("|$$|", $FielArrU);
                $successU = insert("web_st_designation", $Fields, $Values);
                $desig_ids  = $successU[0];

            }
        }
        else{
            $desig_ids  = $desig_id;
        }

        $FielArr = array_merge($FielArr, array('desig_id' => $desig_ids));

        //$Fields = implode('|$$|', array_keys($FielArr));
        //$Values = implode("|$$|", $FielArr);

        //$success = update("web_users", $Fields, $Values, "user_id=$_REQUEST[user_id]");
        
        $success = update("web_users", $FielArr, "user_id=$_REQUEST[user_id]");
        if($success){
            //$Fields = implode('|$$|', array_keys($FielArr1));
            //$Values = implode("|$$|", $FielArr1);
            //update("web_users_profile", $Fields, $Values, "user_id=$_REQUEST[user_id]");
            update("web_users_profile", $FielArr1, "user_id=$_REQUEST[user_id]");
        }
        break;

        case 3:
        $success=delete("web_users","user_id=$_REQUEST[user_id]");
        break;

            case 4:#reset password                
            $FielArr=array(                    
                'password'=>$Pass[1],
                'my_val'=>$Pass[0],
                'updated_by'=>$_SESSION['userid'],
                'updated_type'=>'Administrator Reset'                    
            );
            //$Fields=implode('|$$|',array_keys($FielArr));
            //$Values=implode("|$$|",$FielArr);
            //$success=update("web_users",$Fields,$Values,"user_id=$_REQUEST[user_id] and current_status='Active'");
            $success = update("web_users", $FielArr, "user_id=$_REQUEST[user_id] and current_status='Active'");
            if($success){
                $cDate=curdatetime();
                simplefetch("insert into web_passlog(change_date,change_method,ip_addr,user_id,password, entry_by, entry_date) values ('$cDate','Administrator Reset','$_SERVER[REMOTE_ADDR]','$_REQUEST[user_id]','$Pass[1]', $_SESSION[userid], '$cDate')");

                $rsu = simplefetch("select u.uname, concat(up.f_name,' ',ifnull(up.m_name,''),' ',ifnull(up.l_name,'')) as name, u.user_id, u.user_type_id from web_users u
                    INNER JOIN web_users_profile up on u.user_id=up.user_id where u.status='Active' and u.user_id=$_REQUEST[user_id]");
                if($rsu[0] > 0) {
                    foreach ($rsu[1] as $row);

                    //$UserName = $row['name'];
                    //$UserName = ucwords($UserName);
                    $emailID = strtolower(trim($row['uname']));
                    $UserName = ucwords($row['name']);
                    $msg = "Dear $UserName, <br><br>Your Password request has been reset. Following are the login details.<br><br>USERNAME: <font size='+2'><b>$emailID</b></font><br><br>PASSWORD:<font size='+2'><b>$Pass[0]</b></font><br><br> Regards <br>D(EPC) Section<br>Department of Defence Production<br>(Ministry of Defence)";
                    $sub = "Reset Password request for $_ENV[APP_NAME] Portal";
                    #$emailID = 'sanjaykumar_comat@yahoo.com';
                    send_mail($emailID, $msg, $sub);
                }
            }
            break;
            
            case 5:#making Inactive
            //$success=update("web_users","current_status","Inactive","user_id=$_REQUEST[user_id] and current_status='Active'");
            $success = update("web_users", array("current_status" => "Inactive"), "user_id=$_REQUEST[user_id] and current_status='Active'");
            break;
            
            case 6:#making Active
            //$success=update("web_users","current_status","Active","user_id=$_REQUEST[user_id] and current_status='Inactive'");
            $success = update("web_users", array("current_status" => "Active"), "user_id=$_REQUEST[user_id] and current_status='Inactive'");
            break;
        }
        
        if($success)
            $result[0]=true;
    }

    ComeHere:
    echo frm_response($result);
    ?>