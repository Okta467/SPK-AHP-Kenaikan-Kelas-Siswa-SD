<!-- plugins:js -->
<script src="<?= base_url('vendors/js/vendor.bundle.base.js') ?>"></script>
<script src="<?= base_url('vendors/sweetalert/sweetalert.min.js') ?>"></script>
<script src="<?= base_url('vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('vendors/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('vendors/MY_vendors/dropify/js/dropify.min.js') ?>"></script>
<script src="<?= base_url("vendors/MY_Vendors/switchery/dist/switchery.min.js") ?>"></script>
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
    
    function initAllSwitcheryJs() {
      var elems = document.querySelectorAll('.js-switch');
      
      for (var i = 0; i < elems.length; i++) {
        var switchery = new Switchery(elems[i]);
      }
    }

    function delay(fn, ms) {
      let timer = 0
      return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
      }
    }
      
    function getURLParameterVal(urlParam) {
      // Get the full URL of the current page
      const url = new URL(window.location.href);
    
      // Get the URLSearchParams object
      const params = new URLSearchParams(url.search);
    
      // Get the value of the 'go' parameter
      const goParam = params.get(urlParam);
      
      return goParam;
    }
    
    function removeDuplicateHighlightedSidebarList(pageName) {
      // Select all .nav-item elements inside .sidebar that have a .nav-link child with href not equal to "kriteria.php?go=kriteria"
      var elements = document.querySelectorAll('.sidebar .nav:not(.sub-menu) > .nav-item');
    
      // Loop through each selected element
      elements.forEach(function(element) {
          // Find the child .nav-link element
          var link = element.querySelector('.nav-link');
          var href = `${pageName}.php?go=${pageName}`;
    
          // Check if the href does not match "kriteria.php?go=kriteria"
          if (link && link.getAttribute('href') !== href) {
            // Remove the 'active' class from the parent .nav-item element
            element.classList.remove('active');
          }
      });
    }
    
    $(document).ready(function() {
      currentGo = getURLParameterVal('go');
      removeDuplicateHighlightedSidebarList(currentGo);
    });
</script>