<!-- plugins:js -->
<script src="<?= base_url('vendors/js/vendor.bundle.base.js') ?>"></script>
<script src="<?= base_url('vendors/sweetalert/sweetalert.min.js') ?>"></script>
<script src="<?= base_url('vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('vendors/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('vendors/MY_vendors/dropify/js/dropify.min.js') ?>"></script>
<!-- endinject -->

<!-- Plugin js for this page -->
<script src="<?= base_url('vendors/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('vendors/datatables.net/jquery.dataTables.js') ?>"></script>
<script src="<?= base_url('vendors/datatables.net-bs4/dataTables.bootstrap4.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<!-- End plugin js for this page -->

<!-- inject:js -->
<script src="<?= base_url('assets/js/off-canvas.js') ?>"></script>
<script src="<?= base_url('assets/js/hoverable-collapse.js') ?>"></script>
<script src="<?= base_url('assets/js/template.js') ?>"></script>
<script src="<?= base_url('assets/js/settings.js') ?>"></script>
<script src="<?= base_url('assets/js/todolist.js') ?>"></script>
<script src="<?= base_url('assets/js/tooltips.js') ?>"></script>
<!-- endinject -->

<script>
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('.toggle_tooltip').tooltip({
      placement: 'top',
      delay: {
        show: 500,
        hide: 100
      }
    })
</script>