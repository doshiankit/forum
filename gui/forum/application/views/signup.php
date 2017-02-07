<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forum</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/simple-line-icons.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/animate.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/icheck/skins/flat/aero.css"/>
  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logomi.png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body id="mimin" class="dashboard form-signin-wrapper">

      <div class="container">

        <form class="form-signin" action ="<?php echo base_url();?>signup/" method ="post">
          <div class="panel periodic-login">
              <span class="atomic-number"><center><h2>Signup</h2></center></span>
              <div class="panel-body text-center">
                  <i class="icons icon-arrow-down"></i>
                  <div class="form-group form-animate-text" style="margin-top:20px !important;">
                    <input type="text" class="form-text" name= "username" required>
                    <span class="bar"></span>
                    <label>Username</label>
                  </div>
				  <div class="form-group form-animate-text" style="margin-top:20px !important;">
                    <input type="password" class="form-text" name ="password" required>
                    <span class="bar"></span>
                    <label>Password</label>
                  </div>
				  <div class="form-group form-animate-text" style="margin-top:20px !important;">
                    <input type="text" class="form-text" name ="first_name" required>
                    <span class="bar"></span>
                    <label>First Name</label>
                  </div>
				  <div class="form-group form-animate-text" style="margin-top:20px !important;">
                    <input type="text" class="form-text" name ="last_name">
                    <span class="bar"></span>
                    <label>Last Name</label>
                  </div>
                  
                  <div class="form-group form-animate-text" style="margin-top:20px !important;">
                    <input type="text" class="form-text" name ="email" required>
                    <span class="bar"></span>
                    <label>Email</label>
                  </div>
                  <input type="submit" class="btn col-md-12" value="SignUp"/>
              </div>
                <div class="text-center" style="padding:5px;">
                    <a href="<?php echo base_url();?>login/">Already have an account?</a>
                </div>
          </div>
        </form>

      </div>

      <!-- end: Content -->
      <!-- start: Javascript -->
      <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/jquery.ui.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

      <script src="<?php echo base_url(); ?>assets/js/plugins/moment.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/plugins/icheck.min.js"></script>

      <!-- custom -->
      <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
      <script type="text/javascript">
       $(document).ready(function(){
         $('input').iCheck({
          checkboxClass: 'icheckbox_flat-aero',
          radioClass: 'iradio_flat-aero'
        });
       });
     </script>
     <!-- end: Javascript -->
   </body>
   </html>