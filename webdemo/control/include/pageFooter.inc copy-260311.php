        </main>

        <footer class="main-footer justify-content-between small text-center mt-auto">
            <div class="mb-2 mb-sm-0 text-center">
                <strong>Copyright &copy; <?php echo curdatetime('Y').' '.$_ENV['APP_DEPART']; ?></strong> All rights reserved.
            </div>
        </footer>
    </div>
</div>




<div class="modal fade" id="PopWind" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="PopWindTitle">Loading...</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" id="modalBody">
        <div class="text-center py-4">
          <div class="spinner-border"></div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- 
<div class="modal-container"></div>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; </strong> All rights
    reserved.
  </footer> -->
  <?php #include('include/chat.inc.php');?>

        <script src="../control/assets/js/bootstrap.bundle.min.js"></script>
        <script src="../control/assets/js/migrate.jquery.js"></script>
        <script src="../control/assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="../control/assets/js/script.js"></script>
        <script src="../control/assets/js/tinymce.js"></script>
        <script src="../control/assets/vendor/validate-js/validate.min.js"></script>
    </body>
</html>