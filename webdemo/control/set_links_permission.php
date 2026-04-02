<?php 
    include '../appcode/globals.inc.php';
    include_once(BASE_PATH .'/control/include/include.inc.php');
    userAuthenticationPageLevel();
    userAuthenticationMainLevel();
    include_once('include/pageHeader.inc.php');
    include('include/top_user_info.inc.php'); 
    $frmError = $secFrmFlage = false;
?>
    
<h2 class="h5 content-header text-dark">Set Links Permission</h2>


                <div class="box-body">
                    <form name="frm" id="frm" action="<?php echo curPageName() . "?per_id={$_REQUEST['per_id']}&EncHid={$_SESSION['EncTok']}" ?>" role="form" class="form-border clearfix col-sm-6 col-sm-offset-3" method="post">
                        <input type="hidden" name="preSub" id="preSub" value="1" />
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Choose User</label>
                            <select name="user_id" id="user_id" class="form-control" data-validate="user_id|text|y|1|10|num|dontselect=-1|Please enter Valid option!">
                                <option value="-1">--- Select ---</option>
                                <?php
                                $subQry1 = ($_SESSION['user_type'] != 1) ? " and wu.user_type_id !=1 and wu.user_id !=$_SESSION[userid]" : " ";
                                $rs2 = simplefetch("SELECT wut.user_type,wut.user_type_id,wu.user_id,wu.uname from web_users wu INNER JOIN web_st_user_type wut on wu.user_type_id=wut.user_type_id where wu.`status`='Active' and wut.`status`='Active' $subQry1 GROUP BY wut.user_type_id");
                                if ($rs2[0] > 0) {
                                    foreach ($rs2[1] as $row2) {
                                        echo "<optgroup label='$row2[user_type]'></optgroup>";

                                        $rs3 = simplefetch("SELECT wut.user_type,wu.user_id,wu.uname from web_users wu INNER JOIN web_st_user_type wut on wu.user_type_id=wut.user_type_id where wu.`status`='Active' and wut.`status`='Active' and wut.user_type_id=$row2[user_type_id]");
                                        foreach ($rs3[1] as $row3) {
                                            if ($row3['user_id'] == ($_REQUEST['user_id'] ?? '')) {
                                                echo "<option value='$row3[user_id]' selected >$row3[uname]</option>";
                                            } else {
                                                echo "<option value='$row3[user_id]' >$row3[uname]</option>";
                                            }
                                        }
                                    } 
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-8 col-sm-offset-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>



                <?php
                if (isset($_REQUEST['preSub']) && $_REQUEST['preSub'] == 1 && $frmError == false) {
                    $secFrmFlage = true;
                ?>
                    <div class="box-body clearfix">
                        <div class="panel panel-default">
                            <div class="panel-heading box-title mt-5"><b>Links</b></div>
                            <div class="panel-body">
                                <form class="clearfix" name="frmmain" id="frmmain" method="post" action="set_links_permission_action.php">
                                    <input type="hidden" name="per_id" id="per_id" value="<?php echo $_REQUEST['per_id'] ?>" />
                                    <input type="hidden" name="EncHid" id="EncHid" value="<?php echo $_SESSION['EncTok'] ?>" />
                                    <input type="hidden" name="user_type_id" id="user_type_id" value="<?php echo $_REQUEST['user_id']; ?>" />
                                    <div class="col-sm-12 col-sm-offset-2">
                                        <table id="GridData" class="table table-bordered table-striped table-hover clearfix">
                                            <thead>
                                                <tr style="background-color: #b498768f;">
                                                    <th>S.No</th>
                                                    <th>Link Name</th>
                                                    <th class="text-center">Select All <label for="chk[]"><input type="checkbox" name="chk" id="chk"></label></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <?php
                                                $rs1 = simplefetch("select nls.tot,ls.ls_id,ifnull(ls.link_level,0)as link_level,lf.lid,lt.link_name,lt.type_id,lt.lang_id,case when ls.position is null then '9999999999' else ls.position end as lPos from web_links_structure ls INNER JOIN web_links_final lf on lf.lid=ls.lid INNER JOIN web_link_temp lt on lt.link_temp_id=lf.link_temp_id LEFT JOIN (select count(ls_id)as tot,parent_ls_id from web_links_structure where STATUS='Active' and parent_ls_id is not null GROUP BY parent_ls_id) nls on nls.parent_ls_id=ls.ls_id where ls.`status`='Active' and ls.link_level is null and lt.lang_id=1 and lt.content_type=1 ORDER BY lt.link_name");
                                                // echo"<pre>";
                                                // print_r($rs1);
                                                // echo"</pre>";
                                                
                                                if ($rs1[0] > 0) {
                                                    $sNo="0";
                                                    foreach ($rs1[1] as $row) {

                                                        $rs1 = simplefetch("select * from web_links_permission where status = 'Active' and ls_id = $row[ls_id] and user_id = $_REQUEST[user_id] ", 1);

                                                        $flage = '';
                                                        if ($rs1[0] > 0) {
                                                            $flage = 'checked';
                                                        }
                                                ?>

                                                        <tr style="background-color:#f6f6f6;" id="<?php echo $row['ls_id']; ?>">
                                                            <td style="font-weight: bold; " class="reorder"><?php echo ++$sNo; ?></td>
                                                            <td style="font-weight: bold; "><?php echo $row['link_name'] ?></td>

                                                            <td class="text-center error-message">
                                                                <div><input class="cls_<?php echo $row['ls_id']; ?>" data-id="cls_<?php echo $row['ls_id']; ?>" type="checkbox" name="chk[]" id="chk_<?php echo $row['ls_id']; ?>" value="<?php echo $row['ls_id']; ?>" <?php echo $flage; ?> data-validate="<?php echo end($rs1[1]) == $row ? "chk[]|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed.." : "" ?>">
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        <?php

                                                        $rs2 = simplefetch("select ls.link_level,nls.tot,wlt.type_id,case when ls.position is null then '9999999999' else ls.position end as newPos,ls.ls_id,ls.pos_id,ls.position,ls.uplink,ls.up_position, lf.lid,lt.type,l.lang,wlt.link_name from web_links_final lf INNER JOIN web_link_temp wlt on wlt.link_temp_id=lf.link_temp_id INNER JOIN web_lang l on l.lang_id=wlt.lang_id INNER JOIN web_link_type lt on lt.type_id=wlt.type_id INNER JOIN web_links_structure ls on ls.lid=lf.lid LEFT JOIN (select count(ls_id)as tot,parent_ls_id from web_links_structure where STATUS='Active' and parent_ls_id is not null GROUP BY parent_ls_id) nls on nls.parent_ls_id=ls.ls_id where lf.`status`='Active' and ls.status='Active' and wlt.continuous_content=0 and ls.link_level=1 and ls.parent_ls_id=$row[ls_id] order by lt.type,newPos, wlt.link_name");
                                                        if ($rs2[0] > 0) {
                                                            foreach ($rs2[1] as $row4) {
                                                                $rs2 = simplefetch("select * from web_links_permission where status = 'Active' and ls_id = $row4[ls_id] and user_id = $_REQUEST[user_id] ", 1);

                                                                $flage = '';
                                                                if ($rs2[0] > 0) {
                                                                    $flage = 'checked';
                                                                }

                                                        ?>

                                                                <tr style="background-color:rgb(255 242 228 / 1%);" id="<?php echo $row4['ls_id']; ?>">
                                                                    <td class="reorder"><span style='font-size:20px;'>&#10625;</span></td>
                                                                    <td><?php echo $row4['link_name'] ?></td>

                                                                    <td class="text-center error-message">
                                                                        <div><input class="cls_<?php echo $row['ls_id']; ?> cls_<?php echo $row4['ls_id']; ?>" type="checkbox" name="chk[]" id="chk_<?php echo $row4['ls_id']; ?>" value="<?php echo $row4['ls_id']; ?>" <?php echo $flage; ?> data-validate="<?php echo end($rs2[1]) == $row4 ? "chk[]|checkbox|y|1|2|selmin=1|Please Select atleast One Checkbox to Proceed.." : "" ?>">
                                                                        </div>
                                                                    </td>

                                                                </tr>
                                                        <?php


                                                            }
                                                        }
                                                    }
                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                        <div class="col-sm-5 col-sm-offset-5 clearfix">
                                            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Update" />
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        <div id="ShowMsg"></div>
                    </div>
                <?php
                }
                ?>
     
     

<script type="text/javascript">
    function subFrm() {
        $.base64.utf8encode = true;
        $.ajax({
            type: "POST",
            dataType: "text",
            cache: false,
            url: $('#frmmain').attr('action'),
            data: $('#frmmain').serialize(),
            beforeSend: function() {
                $.fn.ajaxLoading();
            },
            success: function(data) {
                try {
                    data = $.parseJSON($.base64.atob(data));
                    if (data[0]) {
                        $('#ShowMsg').ShowMsg({
                            msg: 'Request Completed Successfully!',
                            alertClass: 'alert-success'
                        });
                    } else {
                        if (data[1] != undefined && data[1][0] == true) {
                            FEror = data[1][1];
                            $.fn.ShowError(FEror);
                        } else if (data[2] != undefined && data[2][0] == true) {
                            MEror = data[2][1];
                            $('#ShowMsg').ShowMsg({
                                msg: MEror,
                                alertClass: data[2][2]
                            });
                        } else {
                            $('#ShowMsg').ShowMsg({
                                msg: 'Request not Completed Successfully!',
                                alertClass: 'alert-danger'
                            });
                        }
                    }
                } catch (err) {
                    $('#ShowMsg').ShowMsg({
                        msg: "<strong>Error:</strong> Unexpected Response received, You may try again!",
                        alertClass: 'alert-warning'
                    });
                }

            },
            error: function() {
                $.fn.custom_alert({
                    msg: 'Something went wrong, Please try again!'
                });
            },
            complete: function() {
                $.fn.ajaxLoading({
                    show: false
                });
            },
        });
    }


    $(function() {
        $('#frm').formChecks();
        <?php
        if ($secFrmFlage == true) {
        ?>
            $('#frmmain').formChecks({
                ajaxSubFunc: subFrm
            }).SetToFirstFocus();
        <?php
        }
        ?>
        $('#chk').click(function() {
            $.fn.CheckAll({
                chkName: 'chk[]',
                ckFlage: $(this).is(':checked')
            })
        })


        $('[class^="cls_"]').click(function(e) {
            m_class = e.currentTarget.className;
            // alert(m_class);
            if ($(e.currentTarget).is(":checked")) {
                $("." + m_class).prop('checked', true);
            } else {
                $("." + m_class).prop("checked", false);
            }
        })
    })


    // $('.showTab').click(function() {
    //     // alert('11');
    //     //console.log($(this).data('id'))
    //     sId = $(this).data('id');
    //     if ($('#tab_' + sId).is(':visible')) {
    //         //console.log('yes');
    //         $('#img_' + sId).attr({
    //             'src': 'images/expand.gif'
    //         });
    //         $('#tab_' + sId).hide();
    //     } else {
    //         //console.log('no');
    //         $('#img_' + sId).attr({
    //             'src': 'images/collapse.gif'
    //         });
    //         $('#tab_' + sId).show();

    //     }

    // })
</script>
        <?php include('include/pageFooter.inc.php'); ?>
