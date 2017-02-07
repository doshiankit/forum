
<script type="text/javascript">
  $(document).ready(function(){
	 var base_url = "<?php echo base_url();?>";
	 var url =base_url+"users_json";
    $('#user_datatables').DataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": url,
		// "dom": '<"top"f>rt<"bottom"pil><"clear">'
		});
	$('.modal').on('hidden.bs.modal', function(e){
		$('.modal-body').find('input').val('');
	});	
			
		
	 $("#thread_add_id").click(function(){
		 var login = "<?php echo $this->session->userdata('login')?>";
		 if(login == false){
			 window.location.href = "<?php echo base_url()?>login/";
		 }else{
			 $('#user_add_modal').modal('show');
		 }
	
		 
	 });
	 $('#user_edit_modal').on('show.bs.modal', function(e) {
        var user_id =  e.relatedTarget.dataset.edit_id;
		$.ajax({
            type : 'post',
            url : '<?php echo base_url();?>user_edit/', //Here you will fetch records 
            data :  'user_id='+ user_id, //Pass $id
            success : function(data){
				
				var custom_data= jQuery.parseJSON(data);
				$("#edit_username").val(custom_data.username);
				$("#edit_password").val(custom_data.password);
				$("#edit_first_name").val(custom_data.first_name);
				$("#edit_last_name").val(custom_data.last_name);
				$("#edit_email").val(custom_data.email);
				$('select[name=status]').val(custom_data.status);
				$("#edit_id").val(custom_data.id);
            }
        });
    });
	 $("#edit_submit").click(function(){
		submit_form("edit_user","user_edit_modal","user_datatables");
	});
	 $("#add_submit").click(function(){
		submit_form("add_user","user_add_modal","user_datatables");
	});
  });

</script>
      <div class="container-fluid mimin-wrapper">
            <!-- start: Content -->
            <div id="content">
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                   <div class="panel-heading">
                          <h3><?php echo $page_title;?> <div class="btn-group" role="group" aria-label="..." style= "float:right;">
						<!--<a href="#thread_add_modal" class="btn btn-primary" id="thread_add_id" data-toggle="modal">New Thread</a> -->
						<button type="button" class="btn btn-primary" id ="thread_add_id">
							Add User
						</button>
                          </div>
						</h3>
		</div>
						</h3>
					</div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="user_datatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Username</th>
                          <th>First Name</th>
                          <th>Last Name</th>
						  <th>Email</th>
						  <th>Status</th>
						  <th>Creation Date</th>
						  <?php 
						   $accountinfo = $this->session->userdata('accountinfo');
						   if(isset($accountinfo) && !empty($accountinfo) && $accountinfo['type'] = -1){
							   echo "<th data-orderable='false'>Actions</th>";
						   }
						  ?>
                        </tr>
                      </thead>
                   
                        </table>
                      </div>
                  </div>
                </div>
              </div>  
              </div>
            </div>
      </div>
	 
    <div class="modal fade"  id="user_edit_modal" tabindex="-1" role ="dialog" aria-labelledby="user_edit_modal" aria-hidden="true">
        <div class="modal-dialog">
		     <div class="modal-content">
			 	<form class="form-horizontal" id="edit_user" name="edit_user" method="post" action ="<?php echo base_url();?>user_save/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
					<h4 class="modal-title" id ="modal_title">Edit User</h4>
				</div>
				<div class="modal-body">
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="username">Username :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "username" id = "edit_username" value="" required ></input>
								  </div>
						 </div>
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="password">Password :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "password" id = "edit_password" value="" required ></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="first_name">First Name :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "first_name" id = "edit_first_name" value="" required ></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="last_name">Last Name :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "last_name" id = "edit_last_name" value=""></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="email">Email  :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "email" id = "edit_email" value="" required></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="demo-is-inputsmall">Status :</label>
								  <div class="col-sm-5 ">
										<select class ="form-control" name ="status" id ="status">
										 <option value ="0">Active</option>
										 <option value ="1">Inactive</option>
										</select>
								  </div>
						 </div>
						 <input type ="hidden" name ="id" id ="edit_id" value =""/>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id ="edit_submit" > Edit User</button>
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close </button>
				</div>
				</form>
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	<div class="modal fade"  id="user_add_modal" tabindex="-1" role ="dialog" aria-labelledby="user_add_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<form class="form-horizontal" id="add_user" name="add_user" method="post" action ="<?php echo base_url();?>user_add/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
					<h4 class="modal-title" id ="modal_title">Add User</h4>
				</div>
				<div class="modal-body">
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="username">Username :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "username" id = "add_username" value="" required ></input>
								  </div>
						 </div>
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="password">Password :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "password" id = "add_password" value="" required ></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="first_name">First Name :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "first_name" id = "add_first_name" value="" required ></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="last_name">Last Name :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "last_name" id = "add_last_name" value=""></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="email">Email  :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "email" id = "add_email" value="" required></input>
								  </div>
						 </div>
						  <div class="form-group">
								<label class="col-sm-3 control-label" for="demo-is-inputsmall">Status :</label>
								  <div class="col-sm-5 ">
										<select class ="form-control" name ="status" id ="add_status">
										 <option value ="0">Active</option>
										 <option value ="1">Inactive</option>
										</select>
								  </div>
						 </div>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id ="add_submit" > Add User</button>
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close </button>
				</div>
				</form>
			</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>
</html>
