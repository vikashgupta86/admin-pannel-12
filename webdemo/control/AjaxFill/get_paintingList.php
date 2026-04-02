<?php include '../../appcode/globals.inc.php';
require_once(dirname_r(__FILE__, 3) . "/appcode/DataTable/dataTableServer.inc.php");
$obj->AjaxFilePrevent();
$obj->userAuthenticationPageLevel();
$data = array();
#echo '<pre>';print_r($_REQUEST);
$LimitQry = $sspObj->limit($_GET);
// $subQry=(isset($_REQUEST['lid']) && $_REQUEST['lid']!='-1')?" and lf.lid=$_REQUEST[lid]":'';
$rs = $obj->simplefetch("select * from school_shortlisted_$_REQUEST[comp_notice_id] where group_id=$_REQUEST[grp] and status = 'Active' ");
if ($rs[0] > 0) {
    $LinkStr = '<option value=\'-1\'>Choose Any</option>';
    $sNo = (!empty($_REQUEST['start'])) ? intval($_REQUEST['start']) : '0';
    
    foreach ($rs[1] as $row) {

        $rs2 = $obj->simplefetch("select * from school_register_$_REQUEST[comp_notice_id] where school_id=$row[school_id] and status = 'Active' ");
        if ($rs2[0] > 0) {   
            foreach ($rs2[1] as $row2) {}
        }

        $rs3 = $obj->simplefetch("select * from school_classes where class_id=$row[class] and status = 'Active' ");
        if ($rs3[0] > 0) {   
            foreach ($rs3[1] as $row3) {}
        }

        $LinkStr='';
        if($row['rank']==NULL)
            $LinkStr = "<option value='NULL'>SELECT</option>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>";
        else if($row['rank']==1)
            $LinkStr = "<option value='NULL'>SELECT</option>
                <option selected value='1'>1</option>
                <option value='2'>2</option>
                <option value='3'>3</option>";
        else if($row['rank']==2)
            $LinkStr = "<option value='NULL'>SELECT</option>
                <option value='1'>1</option>
                <option selected value='2'>2</option>
                <option value='3'>3</option>";
        else if($row['rank']==3)
            $LinkStr = "<option value='NULL'>SELECT</option>
                <option value='1'>1</option>
                <option value='2'>2</option>
                <option selected value='3'>3</option>";

        $data[] = array(
            
            ++$sNo,
            html_entity_decode($row2['school_name']),
            html_entity_decode($row2['reg_no']),
            $row['student_name'],
            $row['enr_no'],
            $row3['class'],
            "<div class=\"text-center tools\"> 
                        <i class=\"fa fa-eye\" data-toggle=\"tooltip\" aria-hidden=\"true\" id='photo_view' data-photo='$row[photo]' title='View'></i>
                    </div>",
            "<div class=\"text-center\">
                <select name=\"pos_id_$row[shortlist_id]\" id=\"pos_id_$row[shortlist_id]\" onchange=\"checkRank(this)\" class=\"btn form-control\" data-grp=\"$_REQUEST[grp]\" data-not_id=\"$_REQUEST[comp_notice_id]\" data-sid=\"$row[shortlist_id]\" data-validate=\"pos_id_$row[shortlist_id]|text|y|1|10|num|dontselect=-1|Please enter Valid option!\">
                $LinkStr
                </select>
            </div>",
            // "<div class=\"text-center\">
                // <button type='button' onclick='saveRank(this)' data-grp=\"$_REQUEST[grp]\" data-not_id=\"$_REQUEST[comp_notice_id]\" id=\"$row[shortlist_id]\" class='save_rank btn btn-dark'>Save</button>
            // </div>",
        );

        $LinkStr = '<option value=\'-1\'>Choose Any</option>';
    }
}

$recordsTotal = $obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
$recordsFiltered = $obj->getNameQry("select count(wu.user_id)  from web_users wu
        INNER JOIN web_st_user_type ut on ut.user_type_id=wu.user_type_id
         where wu.status='Active' and wu.user_id!=1");
$resData = array(
    "draw" => isset($request['draw']) ? intval($request['draw']) : 0,
    "recordsTotal"  => intval($recordsTotal),
    "recordsFiltered"  => intval($recordsFiltered),
    "data" =>  $data
);
echo $obj->frm_response($resData, true, false);
