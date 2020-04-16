</div><!-- wrapper -->
<script type="text/javascript">
	var baseURL = '<?php echo base_url(); ?>';
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/j-validate.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/j-additional-methods.js"></script>
<!-- SweetAlert -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/swal.js"></script>
<!-- DataTables -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>
<!-- Popper.JS -->
<script 
	src="<?php echo base_url(); ?>assets/js/app.js?random=<?php echo mt_rand(); ?>"></script>
<script 
	src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" ></script>
<!-- Bootstrap JS -->
<script 
	src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" ></script>
<script 
	src="<?php echo base_url(); ?>assets/js/moment.min.js" ></script>
<script 
	src="<?php echo base_url(); ?>assets/js/moment.min.js" ></script>
<script 
	src="<?php echo base_url(); ?>assets/js/moment.locales.min.js"></script>
<script 
	src="<?php echo base_url(); ?>assets/js/daterangepicker.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        	
        });
    });
</script>

<!-- spinner -->
<div class="spinner-cont">
	<div class="lds-roller">
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
</div>
<!-- end spinner -->

<!-- generic modal -->
<div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-labelledby="cust-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
    </div>
  </div>
</div>
<!-- end generic modal -->



</body>
</html>