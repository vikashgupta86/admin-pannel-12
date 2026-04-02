<?php include_once '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) ."/appcode/ForAjax.inc.php");
#$obj->AjaxFilePrevent();
#$obj->userAuthenticationPageLevel();
$data=array();
$function = $_POST['function'];
$fUser=$_REQUEST['fUsr']   ; 
$writeReadData="../WriteReadData";
if($fUser==1)
    $writeReadData="WriteReadData";

    switch($function) {
        case('getState'):
            
           /*if (file_exists('chat.txt')) {
               $lines = file('chat.txt');
           }
           $data['state'] = count($lines);*/
           $chatID=$obj->getNameQry("select max(chat_id)as ct from web_chat where status='Active'");
           $data['state']=$chatID;
        break;
        
        case('update'):                 
          $state = $_POST['state'];
          $subQry= !(empty($state))?"and chat_id>'$state'":'';
          $chatData=array();
            $rs=$obj->simplefetch("SELECT wc.user_id,wc.chat_id,wc.message,ifnull(up.profile_img,'np.png')as prPic,date_format(sent_on,'%h:%i %p')as mTime from web_chat wc
INNER JOIN web_users_profile up on up.user_id=wc.user_id where wc.status='Active' $subQry order by wc.chat_id");
            if($rs[0]<=0){
                $chatData=false;
            }
            else{
                $sNo;
                $prevUser='';
                foreach($rs[1] as $row){
                    if($prevUser!=$row['user_id']){
                        $dyClasss=(($sNo++%2)==0)?"pull-right":"pull-left";
                        $prevUser=$row['user_id'];    
                    }
                    
                    $chatData[]=<<<EOF
                    <li class="left clearfix admin_chat">
                            <span class="chat-img1 $dyClasss">
                                <img src="$writeReadData/PF45214/$row[prPic]" alt="User Avatar" class="img-circle">
                            </span>
                            <div class="chat-body1 clearfix">
                                <p>$row[message]</p>
                                <div class="chat_time pull-left">$row[mTime]</div>
                            </div>
                        </li>
EOF;
                    $state=$row['chat_id'];
                }
            }
          $data['text'] = $chatData;
          $data['state'] = $state;  
        break;
       
       case('send'):
       	 /*$nickname = htmlentities(strip_tags($_POST['nickname']));
	     $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	     $message = htmlentities(strip_tags($_POST['message']));
	     if (($message) != "\n") {
	       if (preg_match($reg_exUrl, $message, $url)) {
	          $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
	       } 
	          fwrite(fopen('chat.txt', 'a'), "<span>". $nickname . "</span>" . $message = str_replace("\n", " ", $message) . "\n"); 
	     }*/
        
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	    $message = htmlentities(strip_tags($_POST['details']));
	    if (($message) != "\n") {
	       if (preg_match($reg_exUrl, $message, $url)) {
	          $message = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank">'.$url[0].'</a>', $message);
	       } 
           $cTime=str_replace(array('/',' '),'',$obj->curdatetime());
           #$obj->simplefetchUA("insert into web_chat (message,user_id,sent_on) values ('$message','$_SESSION[userid]','$cTime')",3);           
	       $obj->insert("web_chat","message,user_id,sent_on","$message|$$|$_SESSION[userid]|$$|$cTime");   
	     }
        break;
        
        case('l_chat'):
            $lStatus=($_POST['flage']=='true')?'1':'0';
            $obj->update("web_cms_config","live_chat","$lStatus","conf_id=1");
        break;
    }    
    echo $obj->frm_response($data,true,false);