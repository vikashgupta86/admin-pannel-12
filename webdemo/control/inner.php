<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
    <small>Control panel</small>
  </h1>
  <!--
  <ol class="breadcrumb">
    <li><a href="<?php //echo "main.php?per_id=($_REQUEST[per_id] ?? '')&amp;EncHid=$_SESSION[EncTok]";?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
  -->
</section>

<!-- Main content -->
<section class="content">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <div class="row">
            <div class="col-md-12">
              <h3><?php 

              $usr_session='';
      if($_SESSION['user_type'] =='20'){

           $usr_session= " and (lt.entry_by='".$_SESSION['userid']."' || lt.nmnh_type='".$_SESSION['musume_type']."')";
      }
              echo getNameQry("select ifnull(count(lt.link_temp_id),0)as ct from web_link_temp lt
                INNER JOIN web_links_final lf on lt.link_temp_id=lf.link_temp_id
                where lt.`status`='Active' and lf.`status`='Active' and lt.app_reject=1 $usr_session");?></h3>
                <p>Total Published Links</p>
              </div>
            </div>

          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <div class="row">
              <div class="col-md-12">
                <h3><?php echo getNameQry("select ifnull(count(lt.link_temp_id),0)as ct from web_link_temp lt
                where lt.`status`='Active' and lt.app_reject is null $usr_session");?></h3>
                <p>Pending for Approval</p>
              </div>
            </div>
              <!--<h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>-->
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <div class="row">
                  <div class="col-md-12">
                    <h3><?php echo getNameQry("select ifnull(count(lt.link_temp_id),0)as ct from web_link_temp lt
                    where lt.`status`='Active' and lt.app_reject=1 and lt.publish_by is null $usr_session");?></h3>
                    <p>Pending for Published</p>
                  </div>
                </div>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
       <!--    <div class="col-lg-3 col-xs-6">
           
            <div class="small-box bg-red">
              <div class="inner">
                <div class="row">
                  <div class="col-md-12">
                    <h3><?php echo getNameQry("select ifnull(count(tt.t_temp_id),0)as ct from web_tender_temp tt
                      INNER JOIN web_tender_final tf on tf.t_temp_id=tt.t_temp_id
                      where tt.status='Active' and tf.status='Active' and tt.app_reject=1 and tt.publish_by is not null and tt.close_date>=CURRENT_DATE()");?></h3>
                      <p>Total Active Tenders</p>
                    </div>
                  </div>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
           
          </div> -->
          <!-- /.row -->

          <!-- <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
          
                <div class="info-box-content">
                  <span class="info-box-text">New Members</span>
                  <span class="info-box-number">2,000</span>
                </div>
                /.info-box-content
              </div>
              /.info-box
            </div>
          </div> -->
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-7">
              <!-- Custom tabs (Charts with tabs)-->

              <!-- /.nav-tabs-custom -->

              <!-- Chat box -->

              <!-- /.box (chat box) -->

              <!-- TO DO List -->
          <?php /*<div class="box box-primary">
            <div class="box-header">
              <i class="ion ion-clipboard"></i>

              <h3 class="box-title">To Do List</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="todo-list">
                <li>
                  <!-- drag handle -->
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <!-- checkbox -->
                  <input type="checkbox" value="">
                  <!-- todo text -->
                  <span class="text">Design a nice theme</span>
                  <!-- Emphasis label -->
                 
                  <!-- General tools such as edit or delete-->
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <input type="checkbox" value="">
                  <span class="text">Make the theme responsive</span>
                  
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <input type="checkbox" value="">
                  <span class="text">Let theme shine like a star</span>
                 
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <input type="checkbox" value="">
                  <span class="text">Let theme shine like a star</span>
                 
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <input type="checkbox" value="">
                  <span class="text">Check your messages and notifications</span>
                
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <input type="checkbox" value="">
                  <span class="text">Let theme shine like a star</span>
                
                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix no-border">
              <button type="button" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
            </div>
            </div>*/?>
            <!-- /.box -->

            <!-- quick email widget -->
            <!--
            <form name="formNC" id="formNC" method="post" autocomplete="off" role="form" action="<?php echo "quick_mail_action.php?per_id=$_SESSION[per_id]&amp;EncHid=$_SESSION[EncTok]";?>" enctype="multipart/form-data" novalidate="">
              <div class="box box-info">
                <div class="box-header">
                  <i class="fa fa-envelope"></i>

                  <h3 class="box-title">Quick Email</h3>
                  <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                      <i class="fa fa-times"></i></button>
                    </div>
                  </div>

                  <div class="box-body">
                    <div class="form-group">
                      <input type="email" class="form-control" name="emailto" id="emailto" placeholder="Email to:" data-validate="emailto|text|y|1|500|email|Please enter Valid Email-ID!"/>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-validate="subject|text|y|1|500|alnum_spc|Please enter valid subject!"/>
                    </div>
                    <div>
                      <textarea class="textarea" placeholder="Message" name="msg" id="msg" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" data-validate="msg|text|y|1|2500|alnum_spc|Please enter valid Message!"></textarea>
                    </div>              
                  </div>
                  <div class="box-footer clearfix">
                    <button type="submit" class="pull-right btn btn-default" id="sendEmail">Send
                      <i class="fa fa-arrow-circle-right"></i></button>
                    </div>            
                  </div>
                </form>
                -->
              </section>
        <?php /*<section class="col-lg-5">

          <!-- Map box -->
          
          <!-- /.box -->

          <!-- solid sales graph -->
        
          <!-- /.box -->

          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              <i class="fa fa-calendar"></i>

              <h3 class="box-title">Calendar</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <!-- button with a dropdown -->
                <div class="btn-group">
                  <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bars"></i></button>
                  <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="#">Add new event</a></li>
                    <li><a href="#">Clear events</a></li>
                    <li class="divider"></li>
                    <li><a href="#">View calendar</a></li>
                  </ul>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
              <!-- /. tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <!--The calendar -->
              <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-black">
              <div class="row">
                <div class="col-sm-6">
                  <!-- Progress bars -->
                  <div class="clearfix">
                    <span class="pull-left">Task #1</span>
                    <small class="pull-right">90%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 90%;"></div>
                  </div>

                  <div class="clearfix">
                    <span class="pull-left">Task #2</span>
                    <small class="pull-right">70%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 70%;"></div>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                  <div class="clearfix">
                    <span class="pull-left">Task #3</span>
                    <small class="pull-right">60%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 60%;"></div>
                  </div>

                  <div class="clearfix">
                    <span class="pull-left">Task #4</span>
                    <small class="pull-right">40%</small>
                  </div>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-green" style="width: 40%;"></div>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.box -->

          </section>*/?>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->

      </section>
      <!-- /.content -->
      <script type="text/javascript">
        $(function(){
          $('#formNC').formChecks({ajaxSubFunc:frmAction}).SetToFirstFocus();
        })

        function frmAction(){
          $.base64.utf8encode = true;

          var formData = new FormData();
    //formData.append('name', $('#formNC').serialize());
    //formData.append('l_file', $('#l_file')[0].files[0]);
    
    var other_data = $('#formNC').serializeArray();
    $.each(other_data,function(key,input){
      formData.append(input.name,input.value);
    });
    
    $.ajax({
      type     : "POST",
      dataType: "text",
      cache    : false,        
      enctype: 'multipart/form-data',
      url      : $('#formNC').attr('action'),
        data     : formData,//$('#formNC').serialize(),        
        processData: false,
        contentType: false,
        
        beforeSend: function(){
          $.fn.ajaxLoading();
        },        
        success  : function(data) {                                    
          try{
            data=$.parseJSON($.base64.atob(data));            
            if(data[0]){                    
              $('#formNC')[0].reset();                    
              $.fn.custom_alert({msg:'Email has been sent!'});                                                            
            }
            else{                    
              if(data[1]!= undefined && data[1][0]==true){
                FEror=data[1][1];                    
                $.fn.ShowError(FEror);    
              }
              else if(data[2]!= undefined && data[2][0]==true){
                MEror=data[2][1];
                        //console.log(MEror);
                        $.fn.custom_alert({msg:MEror});                        
                      }
                      else{
                        $.fn.custom_alert({msg:'Request not Completed Successfully!'});                                                
                      }
                    }
                  }
                  catch(err) {
                    $.fn.custom_alert({msg:err.message});                                                
                  }

                },
                error:function(){            
                  $.fn.custom_alert({msg:'Something went wrong, Please try again!'});                        
                },
                complete: function(){            
                  $.fn.ajaxLoading({show:false});
                },
              });
  }
</script>