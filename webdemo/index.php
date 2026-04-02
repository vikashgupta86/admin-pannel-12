<?php


//  max_allowed_connections


  if (isset($_GET['clear']) && $_GET['clear'] === '1') {
    if (isset($_COOKIE['legacy_cookie'])) {
      setcookie('legacy_cookie', '', time() - 3600, '/');
      unset($_COOKIE['legacy_cookie']);
    }
  }

  if (isset($_GET['lang'])) {
    $lang = (int) $_GET['lang'];
    if (!in_array($lang, [1,2,3], true)) {
        header('Location: index.php');
        exit;
    }
    $_SESSION['lang'] = $lang;
}

$lang = $_SESSION['lang'] ?? 1;



include './appcode/globals.inc.php';
// include './appcode/usercon_pdo.inc.php';
include_once './include/website_common.inc.php';
include './include/header.inc.php';


$sql = "SELECT lt.link_name, lt.title, lt.url, lt.header_img, lt.details
          FROM web_links_final lf
            INNER JOIN web_link_temp lt ON lt.link_temp_id = lf.link_temp_id
            INNER JOIN web_links_structure ls ON ls.lid = lf.lid
          WHERE lf.status='Active'
            AND lt.status='Active'
            AND ls.status='Active'
            AND ls.pos_id = 6
            AND ls.link_level IS NULL
            AND (lf.expiry_date IS NULL OR lf.expiry_date > CURRENT_DATE())
            AND lt.lang_id = ?
            AND ls.position = 999 LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lang);
    $stmt->execute();
    $result = $stmt->get_result();
    $modalRow = $result->fetch_assoc();
    $stmt->close();
?>

      <?php
        if (isset($_SESSION['schoolid'])) {
          unset($_SESSION['schoolid']);
        }

        include 'include/topmain.inc.php';
        include 'include/banner.inc.php';
        include 'include/middle.inc.php';
        include 'include/footer_main.inc.php';
      ?>

    <?php if ($modalRow && !empty($modalRow['link_name'])): ?>
      <div class="modal fade" id="myModel" tabindex="-1" style="z-index:9999999;">
        <div class="modal-dialog" style="max-width:70%;margin:auto;">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <?php 
              /*
              if (!empty($modalRow['header_img'])): ?>
                <a href="<?= e($modalRow['url']) ?>" target="_blank">
                  <img src="WriteReadData/HD87168/<?= safeFile($modalRow['header_img']) ?>" alt="<?= e($modalRow['title']) ?>" style="max-width:100%;" />
                </a>
              <?php endif;
              */ ?>

              <?php if (!empty($modalRow['details'])): ?>
                <div><?= _html_entity_decode($modalRow['details']); ?></div>
              <?php endif; ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <script>
        document.addEventListener("DOMContentLoaded", function(){
          var modal = new bootstrap.Modal(document.getElementById('myModel'));
          modal.show();
        });
      </script>

    <?php endif; ?>

    
  </body>
</html>