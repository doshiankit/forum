<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="description" content="Miminium Admin Template v.1">
  <meta name="author" content="Isna Nur Azis">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $page_title;?></title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/plugins/animate.min.css"/>

  <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logomi.png">
  <!-- start: Javascript -->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

<!-- plugins -->
<script src="<?php echo base_url(); ?>assets/js/plugins/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery.datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/datatables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>assets/js/plugins/summernote.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<script>
  $(document).ready(function(){
	 $('#my_profile_modal').on('show.bs.modal', function(e) {
        var user_id =  e.relatedTarget.dataset.edit_id;
		$.ajax({
            type : 'post',
            url : '<?php echo base_url();?>user_edit/', //Here you will fetch records 
            data :  'user_id='+ user_id, //Pass $id
            success : function(data){
				alert(data);
				var custom_data= jQuery.parseJSON(data);
				$("#username").val(custom_data.username);
				$("#password").val(custom_data.password);
				$("#first_name").val(custom_data.first_name);
				$("#last_name").val(custom_data.last_name);
				$("#email").val(custom_data.email);
				$("#id").val(custom_data.id);
            }
        });
    });
	$("#update_profile").click(function(){
		submit_form("update_profile_form","my_profile_modal","");
	});
  });	
function submit_form(form_id,modal_id,grid_id){
    var form = $('#'+form_id);
	alert(form.attr('action'));
    $.ajax({
        type:'POST',
        url: form.attr('action'),
        data:$('#'+form_id).serialize(), 
        success: function(response) {
			alert(response);
		  $('#'+modal_id).modal('toggle');
		  if(grid_id != ''){
  	      var $lmTable = $("#"+grid_id).dataTable( { bRetrieve : true } );
		  $lmTable.fnDraw();
		  }
        }
    });
} 
</script>
</head>
<?php
$accountinfo = $this->session->userdata('accountinfo');
?>
<body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
			 <?php 
			   if(isset($accountinfo) && !empty($accountinfo) && $accountinfo['type'] == -1){ ?>
				   <ul class="nav navbar-nav ">
						<li><a href="<?php echo base_url();?>users/">User List </a></li>
						<li><a href="<?php echo base_url();?>">Forum List </a></li>
				  </ul>
				    
			 <?php  }
			 ?>
              <ul class="nav navbar-nav navbar-right user-nav">
			  <?php
				   if($this->session->userdata('login')){ 
                     echo "<li class='dropdown'>
						<a class='dropdown-toggle' data-toggle='dropdown' href='#'><span>".$accountinfo['first_name']." ".$accountinfo['last_name']."</span>";
					  echo "<span class='caret'></span></a>
					 <ul class='dropdown-menu'>
						<li><a href='#my_profile_modal' id='my_profile' data-toggle='modal' data-edit_id='".$accountinfo['id']."'><span class='fa fa-user'></span>My Profile</a></li>
						<li><a href='".base_url()."logout/'><span class='fa fa-user'></span> logout</a></li>
					</ul>";
				   }else{
					   ?>
					    <li class="user-name">
					   <div class="col-md-12"><a href="<?php echo base_url();?>login/"><i class="fa fa-sign-in"></i> sign-in</a></div>
				   <? }
				?>
				</li>
              </ul>
            </div>
          </div>
        </nav>
		<div class="modal fade"  id="my_profile_modal" tabindex="-1" role ="dialog" aria-labelledby="my_profile_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<form class="form-horizontal" id="update_profile_form" name="update_profile_form" method="post" action ="<?php echo base_url();?>update_profile/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
					<h4 class="modal-title" id ="modal_title">My Profile</h4>
				</div>
				<div class="modal-body">
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="username">Username :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "username" id = "username" value="" required ></input>
								  </div>
						 </div>
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="password">Password :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "password" id = "password" value="" required ></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="first_name">First Name :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "first_name" id = "first_name" value="" required ></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="last_name">Last Name :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "last_name" id = "last_name" value=""></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="email">Email  :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "email" id = "email" value="" required></input>
								  </div>
						 </div>
						  <input type ="hidden" name ="id" id ="id" value =""/>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id ="update_profile" > Update Profile</button>
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close </button>
				</div>
				</form>
			</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
