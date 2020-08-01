<!DOCTYPE html>
<html>
<head>
<title>CPFI | FORGOT PASSWORD</title>
<link rel="shortcut icon" href="<?= base_url('assets/image/misc/ico.ico') ?>" type="image/x-icon">
<link href="<?php echo base_url('assets/css/login.css'); ?>" rel="stylesheet" id="bootstrap-css">
<link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" id="bootstrap-css">
<script src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/swal.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function($) {
    $(document).on('submit', '#frm-new-password', function(e) {
      e.preventDefault();
      var frm = $(this).serialize();
      $.ajax({
        url: '<?php echo base_url(); ?>' + 'submit-new-password',
        type: 'POST',
        dataType: 'JSON',
        data: frm,
        success: function(res){
          var cnt = Object.keys(res).length;
          // console.log(typeof res.msg, typeof cnt);

          if (cnt === 1 && res.msg == 'failed') {
            Swal.fire(
              'Oops!',
              'Invalid Email',
              'error'
            ); 
          } 
          else if(res.msg == 'success'){
            Swal.fire(
              'Success!',
              'Password Successfully Updated!',
              'success'
            ); 
            setTimeout(() => {
              window.location.href = '<?php echo base_url('login'); ?>';
            }, 3000);
          } else {
            $.each(res, function(index, el) {
              $('div[ref="'+index+'"]').html(el).show();
              setTimeout(function(){
                $('div[ref="'+index+'"]').html(el).hide();
              }, 5000);
            });
          }
        }
      });
    }); 
  });
</script>
</head>

<body>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first pt-4">
      <img 
        src="<?php echo base_url('assets/image/misc/logo.png'); ?>" 
        class="m-4" 
        id="icon" 
        alt="User Icon" 
        style="box-shadow: 1px 3px 17px #f0f0f0;"/>
    </div>
    <!-- Login Form -->
    <form id="frm-new-password">
      <input type="password" id="new-password" class="fadeIn second" name="new-password" placeholder="New password">
      <div ref="new-password" class="invalid-feedback">
        
      </div>
      <input type="password" id="re-new-password" class="fadeIn second" name="re-new-password" placeholder="Re-Enter New Password">
      <div ref="re-new-password" class="invalid-feedback">
        
      </div>
      <input type="hidden" name="username" value="<?php echo !empty($username) ? $username : ''; ?>">
      <input type="submit" class="fadeIn fourth" value="Reset now">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="<?php echo base_url('login'); ?>">Already have account?</a>
    </div>

  </div>
</div>
</body>
</html>