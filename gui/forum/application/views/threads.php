
<script type="text/javascript">
  $(document).ready(function(){
	 var base_url = "<?php echo base_url();?>";
	 var url =base_url+"forum_json";
	 <?php 
		$accountinfo = $this->session->userdata('accountinfo');
		if(isset($accountinfo) && $accountinfo['type'] == -1){ ?>
		
 $('#forum_datatables').DataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": url,
		"columns": [
		{ "width": "40%" },
		{ "width": "15%" },
		{ "width": "15%" },
		{ "width": "20%" },
		]
		});
		
			
		<?php }else{ ?>
		 $('#forum_datatables').DataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": url,
		"columns": [
		{ "width": "40%" },
		{ "width": "25%" },
		{ "width": "25%" },
		]
		});
		<?php
			}
		
		?>
    
	 $("#thread_add_id").click(function(){
		 var login = "<?php echo $this->session->userdata('login')?>";
		 if(login == false){
			 window.location.href = "<?php echo base_url()?>login/";
		 }else{
			 $('#thread_add_modal').modal('show');
		 }
	
		 
	 });
	 $('#thread_edit_modal').on('show.bs.modal', function(e) {
        var thread_id =  e.relatedTarget.dataset.edit_id;
		$.ajax({
            type : 'post',
            url : '<?php echo base_url();?>thread_edit/', //Here you will fetch records 
            data :  'thread_id='+ thread_id, //Pass $id
            success : function(data){
				var custom_data= jQuery.parseJSON(data)
				$("#subject").val(custom_data.subject);
				$("#id").val(custom_data.thread_id);
            }
        });
    });
	$('.modal').on('hidden.bs.modal', function(e){
		$('.modal-body').find('textarea,input').val('');
	});
	 $("#edit_submit").click(function(){
		submit_form("edit_thread","thread_edit_modal","forum_datatables");
	});
	$('#add_submit').click(function(e) {
	    submit_form("add_thread","thread_add_modal","forum_datatables");
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
						<button type="button" class="btn btn-primary" id ="thread_add_id">
							New Thread
						</button>
                          </div>
						</h3>
		</div>
						</h3>
					</div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="forum_datatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Subject</th>
                          <th>Author</th>
                          <th>Last Post</th>
						  <?php 
						   $accountinfo = $this->session->userdata('accountinfo');
						   if(isset($accountinfo) && !empty($accountinfo) && $accountinfo['type'] = -1){
							   echo "<th data-orderable='false'> Actions</th>";
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
	 
    <div class="modal fade"  id="thread_edit_modal" tabindex="-1" role ="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<form class="form-horizontal" id="edit_thread" name="edit_thread" method="post" action ="<?php echo base_url();?>thread_save/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id ="modal_title">Edit Subject</h4>
				</div>
				<div class="modal-body">
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="subject">Subject :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "subject" id = "subject" value = "" required ></input>
								  </div>
								  <input type ="hidden" name ="id" id ="id"/>
						 </div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close </button>
					<button type="button" class="btn btn-primary" id ="edit_submit" > Save changes</button>
				</div>
				</form>
			</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	
	    <div class="modal fade"  id="thread_add_modal" tabindex="-1" role ="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
			<form class="form-horizontal" id="add_thread" name="add_thread" method="post" action ="<?php echo base_url();?>thread_add/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
					<h4 class="modal-title" id ="modal_title">Add Thread</h4>
				</div>
				<div class="modal-body">
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="add_subject">Subject :</label>
								  <div class="col-sm-5 ">
										<input type="text"  class="form-control" placeholder="" name= "add_subject" id = "add_subject" value="" required></input>
								  </div>
						 </div>
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="information">Information :</label>
								 <textarea name="information" rows=11 cols=50 maxlength=250 required ></textarea>
						 </div>
						</div>
				</div>		
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close </button>
					<button type="button" class="btn btn-primary" id ="add_submit" > Save changes</button>
				</div>
				</form>
			</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</body>
</html>
