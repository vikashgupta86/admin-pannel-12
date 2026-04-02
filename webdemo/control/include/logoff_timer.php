<?php $Temp=LiveUsers(true); ?>

<script type="text/javascript">
    var SecondsTohhmmss = function(totalSeconds) {
    var hours   = Math.floor(totalSeconds / 3600);
    var minutes = Math.floor((totalSeconds - (hours * 3600)) / 60);
    var seconds = totalSeconds - (hours * 3600) - (minutes * 60);

    // round seconds
    seconds = Math.round(seconds * 100) / 100

    var result = (hours < 10 ? "0" + hours : hours);
    result += "-" + (minutes < 10 ? "0" + minutes : minutes);
    result += "-" + (seconds  < 10 ? "0" + seconds : seconds);
    return result;
  }

  var counter=900;
  function start_countdown(){
   myVar= setInterval(function(){ 
    if(counter>=0){      
      var countdownEl = document.getElementById("countdown");
      if(countdownEl) {
          var timeVal = SecondsTohhmmss(counter);
          // Only update text content to avoid focus issues or DOM flickering
          if(!countdownEl.querySelector('#ses_rest')) {
              countdownEl.innerHTML="You Will Be Logged Out In <span class='text-bold countdown-time'></span> <span id='ses_rest' class='btn btn-outline-light btn-xs ms-2' style='padding: 0 5px; font-size: 11px;'>Reset Session</span>";
          }
          var timeSpan = countdownEl.querySelector('.countdown-time');
          if(timeSpan) timeSpan.innerText = timeVal + " Sec";
      }
    }

   if(counter==0){
     $.ajax
     ({
       type:'post',
       url:'logoff.php',
       data:{
       
        <?php echo $GLOBALS['csrf']['token']; ?>,per_id:'<?php echo $_REQUEST['per_id'] ?? ''; ?>',EncHid:'<?= $_SESSION['EncTok']; ?>',
      },
      success:function(response) 
      {        
        window.location="<?php base_url(); ?>";
      }
    });
   }

   if(counter==300){
    $.fn.custom_alert({msg:'You are going to logoff in next 5 Minutes, due to no activity recognised since 15 minutes!'});
  }
  counter--;
}, 1000)
 }
 start_countdown();
 

 $(function(){
  $(document).delegate("#ses_rest", "click", function() {   
    counter=900;
    // console.warn('Reset Session')

    $.ajax
    ({
     type:'POST',
     dataType: "text",
     cache    : false,
     url:'<?php echo base_url() ?>/appcode/detect_activity.php',
     data:{
      <?php echo $GLOBALS['csrf']['token']; ?>,per_id:'<?php echo $_REQUEST['per_id'] ?? ''; ?>',EncHid:'<?php echo $_SESSION['EncTok'] ?>',
    },
    success:function(response) 
    {        
      console.log(response)
        // console.info('counter reset')
      }
    });
  })

    var idleState = false;
    var idleTimer = null;

    // Use a simpler approach that doesn't interfere with UI interactivity
    function resetCounter() {
        counter = 900;
        idleState = false;
        $("body").css('background-color','#fff');
        // Call the session reset logic directly instead of triggering a click on a button
        if (typeof $.ajax === 'function') {
            $.ajax({
                type:'POST',
                dataType: "text",
                cache: false,
                url:'<?php echo base_url() ?>/appcode/detect_activity.php',
                data:{
                    <?php echo $GLOBALS['csrf']['token']; ?>,
                    per_id:'<?php echo $_REQUEST['per_id'] ?? ''; ?>',
                    EncHid:'<?php echo $_SESSION['EncTok'] ?>',
                }
            });
        }
    }

    $(document).on('mousemove keydown scroll wheel touchmove', function () {
        clearTimeout(idleTimer);
        if (idleState == true) { 
            resetCounter();
        }
        idleTimer = setTimeout(function () { 
            idleState = true; 
            $("body").css('background-color','#000');
        }, 600000); // 10 minutes of complete inactivity before dimming
    });
})

 console.log('LiveUsers:' + '<?php echo $Temp[1];?>');  
</script>