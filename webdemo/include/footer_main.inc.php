<?php


$lang_id = (int)($_SESSION['lang'] ?? 1);

/* ======================================================
   ATOMIC VISITOR COUNTER
   ====================================================== */

$cookieName = ($lang_id === 2) ? 'hitcounthindi' : 'hitcount';

if (!isset($_COOKIE[$cookieName])) {

    $updateSql = "UPDATE web_counter SET ct = ct + 1 WHERE lang_id = ?";
    $stmt = $conn->prepare($updateSql);

    if (!$stmt) {
        throw new RuntimeException($conn->error);
    }

    $stmt->bind_param("i", $lang_id);
    $stmt->execute();
    $stmt->close();

    setcookie($cookieName, session_id(), time() + 86400, "/");
}

/* Fetch updated count */
$countSql = "SELECT IFNULL(ct,0) AS total FROM web_counter WHERE lang_id = ?";
$stmt = $conn->prepare($countSql);
$stmt->bind_param("i", $lang_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$hits = (int)($row['total'] ?? 0);
$stmt->close();

/* ======================================================
   FETCH FOOTER LINKS (POS 3)
   ====================================================== */

$content_type = !empty($_SESSION['userid_front']) ? 2 : 1;

$sqlFooter = "
SELECT 
    lf.lid,
    ls.ls_id,
    lt.link_name,
    CASE WHEN lt.type_id!=3 THEN 'target=\"_blank\"' ELSE '' END AS l_target,
    CASE WHEN lt.type_id=1 THEN 'showfile.php'
         WHEN lt.type_id=2 THEN 'showlink.php'
         ELSE '' END AS lfile
FROM web_links_final lf
INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
INNER JOIN web_links_structure ls ON ls.lid = lf.lid
WHERE lf.status='Active'
AND lt.status='Active'
AND ls.status='Active'
AND ls.pos_id=3
AND ls.link_level IS NULL
AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
AND lt.lang_id=?
AND lt.content_type=?
ORDER BY ls.position
";

$stmt = $conn->prepare($sqlFooter);
$stmt->bind_param("ii", $lang_id, $content_type);
$stmt->execute();
$footerLinks = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>


<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">

            <div class="col-md-4 text-center text-md-start mb-md-0">
                <span class="text-white">
                    © <?= date('Y') ?> Bureau of Energy Efficiency.
                </span>
            </div>

            <div class="col-md-8 text-end text-body">
                <?php foreach ($footerLinks as $index => $row): ?>


                    <?php
                    $parse_page = !empty($row['lfile']) ? $row['lfile'] : 'show_content.php';
                        $url = $parse_page . '?lang=' . $lang_id .
                               '&level=0&ls_id=' . (int)$row['ls_id'] .
                               '&lid=' . (int)$row['lid'];
                    ?>

                    <a class="border-bottom text-white" <?= $row['l_target'] ?> href="<?= htmlspecialchars($url) ?>">
                        <?= htmlspecialchars($row['link_name']) ?>
                    </a>

                    <?php if ($index < count($footerLinks) - 1): ?>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-6 text-center"></div>

            <div class="col-md-6" style="text-align: right;">
                <span class="text-white">
                    Visitor No.: <?= $hits ?>
                </span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="text-white">
                    Last Updated on: <?= date('d-m-Y') ?>
                </span>
            </div>
        </div>
    </div>
</div>


  <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/lib/wow/wow.min.js"></script>
    <script src="../assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../assets/lib/accessibility/script.js"></script>
    <script src="../assets/js/script.js"></script>


    <!-- Template Javascript -->
    <script src="../assets/js/main.js"></script>
        <script>
          $('#contactFormChat').submit(function() {
	          //var f = $(this).find('.form-group');
            let url = location.href;
            ferror = false,
            emailExp = /^[^\s()<>@,;:\/]+@\w[\w\.-]+\.[a-z]{2,}$/i;
            $('#contactFormChat input, #contactFormChat textarea').each(function(index){  
              var i = $(this); // current input
              var rule = i.attr('data-rule');
              if (rule !== undefined) {
                var ierror = false; // error flag for current input
                var pos = rule.indexOf(':', 0);
                if (pos >= 0) {
                  var exp = rule.substr(pos + 1, rule.length);
                  rule = rule.substr(0, pos);
                } else {
                  rule = rule.substr(pos + 1, rule.length);
                }
                switch (rule) {
                  case 'required':
                  if (i.val() === '') {
                    ferror = ierror = true;
                  }
                  break;
                  case 'minlen':
                  if (i.val().length < parseInt(exp)) {
                    ferror = ierror = true;
                  }
                  break;
                  case 'email':
                  if (!emailExp.test(i.val())) {
                    ferror = ierror = true;
                  }
                  break;
                  case 'checked':
                  if (! i.is(':checked')) {
                    ferror = ierror = true;
                  }
                  break;
                  case 'regexp':
                  exp = new RegExp(exp);
                  if (!exp.test(i.val())) {
                    ferror = ierror = true;
                  }
                  break;
                }
                i.next('.validation').html((ierror ? (i.attr('data-msg') !== undefined ? i.attr('data-msg') : 'wrong Input') : '')).show('blind');
              }
            });
            if (ferror) return false;
            else var str = $(this).serialize();
            $.ajax({
              type: "POST",
              url: "contactform/contactform.php",
              data: str,
              success: function(msg) {
              //alert(msg);
              if (msg == 'OK') {
                $(".sendmessage").removeClass("show");
                $(".errormessage").addClass("show");
                //$(".sendmessage").html('Message sent!');
                $('#contactFormChat').find("input, textarea").val("");
                refreshCaptcha();
                alert('Message sent!');
                //window.location.href=url;
                return false;
              } else if(msg == "captcha_Error"){
                $(".errormessage").removeClass("show");
                $(".sendmessage").addClass("show");
                $('.errormessage').html('Please Fill Correct Captcha Code!');
              } else {
                $(".errormessage").removeClass("show");
                $('.errormessage').html(msg);
              }
            }
          });
          return false;  
        });
      </script>
      <script type="text/javascript">
        $( document ).ready(function() {
          $('.box-carousel').slick({
            dots: false,
            arrows: true,
            slidesToShow:8,
            slidesToScroll:1,
            autoplay: 1,
            wrap:false,
            prevArrow: "<button type='button' class='mission-prev-arrow'></button>",
            nextArrow: "<button type='button' class='mission-next-arrow'></button>"
          });
        });
      </script>
      <script type="text/javascript">
        $(function () {
          $(".demo1").bootstrapNews({
            newsPerPage: 5,
            autoplay: true,
			      pauseOnHover:true,
            direction: 'up',
            newsTickerInterval: 4000,
            onToDo: function () {
              //console.log(this);
            }
          });
        });
      </script>
      <script type="text/javascript">
        jQuery(document).ready(function ($) {
          $('.my-news-ticker').AcmeTicker({
            type:'marquee',/*horizontal/horizontal/Marquee/type*/
            direction: 'left',/*up/down/left/right*/
            speed: 0.05,/*true/false/number*/ /*For vertical/horizontal 600*//*For marquee 0.05*//*For typewriter 50*/
            controls: {
              toggle: $('.acme-news-ticker-pause'),/*Can be used for horizontal/horizontal/typewriter*//*not work for marquee*/
            }
          });
        })
      </script> 
      
      <script>
        window.onscroll = function() { toggleStickyHeader() };
        
        const header = document.getElementById("main-nav-container");
        const stickyThreshold = 100; // Pixels scrolled before header sticks
        
        function toggleStickyHeader() {
          if (window.pageYOffset > stickyThreshold) {
            header.classList.add("sticky-active");
          } else {
            header.classList.remove("sticky-active");
          }
        }
        </script>
        
        