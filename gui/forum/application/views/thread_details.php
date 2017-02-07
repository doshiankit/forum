<script type="text/javascript">
  $(document).ready(function(){
	 var base_url = "<?php echo base_url();?>";
	 var thread_id ="<?php echo $thread_id?>";
	 var url =base_url+"thread_details_json/"+thread_id+"/";
	 $("#thread_add_id").click(function(){
		 var login = "<?php echo $this->session->userdata('login')?>";
		 if(login == false){
			 window.location.href = "<?php echo base_url()?>login/";
		 }else{
			 $('#thread_add_modal').modal('show');
		 }		 
	 });
    $('#thread_details_datatables').DataTable({
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": url,
		"columns": [
		{ "width": "25%" },
		null,
		]
	});
	$('#thread_detail_edit_modal').on('show.bs.modal', function(e) {
        var thread_id =  e.relatedTarget.dataset.edit_id;
		$.ajax({
            type : 'post',
            url : '<?php echo base_url();?>thread_detail_edit/', //Here you will fetch records 
            data :  'thread_id='+ thread_id, //Pass $id
            success : function(data){
				var custom_data= jQuery.parseJSON(data)
				$("#edit_information").val(custom_data.thread_details);
				$("#id").val(custom_data.id);
            }
        });
    });
	$("#add_submit").click(function(){
		submit_form("add_thread","thread_add_modal","thread_details_datatables");
	});
	$("#edit_submit").click(function(){
		submit_form("edit_thread","thread_detail_edit_modal","thread_details_datatables");
	});
  });
</script>

      <div class="container-fluid mimin-wrapper">
            <!-- start: Content -->
            <div id="content">
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading"><h3><?php echo $page_title;?> <div class="btn-group" role="group" aria-label="..." style= "float:right;">
						<!--<a href="#thread_add_modal" class="btn btn-primary" id="thread_add_id" data-toggle="modal">New Thread</a> -->
						<button type="button" class="btn btn-primary" id ="thread_add_id">
							Add reply
						</button>
                          </div>
						</h3>
					</div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="thread_details_datatables" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th style= "width : 25%;">Author</th>
                          <th style= "width : 75%;">Comment</th>
                        </tr>
                      </thead>
                   
                        </table>
                      </div>
                  </div>
                </div>
              </div>  
              </div>
            </div>
          <!-- end: content -->
      </div>
	   <div class="modal fade"  id="thread_add_modal" tabindex="-1" role ="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
				<form class="form-horizontal" id="add_thread" name="add_thread" method="post" action ="<?php echo base_url();?>thread_details_add/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
					<h4 class="modal-title" id ="modal_title">Add Reply</h4>
				</div>
				<div class="modal-body">
					
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="demo-is-inputsmall">Reply :</label>
								 <textarea name="information" id ="information" rows="10" cols="50"></textarea>
						 </div>
						 <input type ="hidden" name ="thread_id" id ="thread_id" value ="<?php echo $thread_id; ?>"/>
						</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value ="Close"/>
					<input type="button" class="btn btn-primary" id ="add_submit" value ="Save changes"/>
				</div>
				</form>
			</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	 <div class="modal fade"  id="thread_detail_edit_modal" tabindex="-1" role ="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
			<form class="form-horizontal" id="edit_thread" name="edit_thread" method="post" action ="<?php echo base_url();?>thread_details_edit/">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
					<h4 class="modal-title" id ="modal_title">Edit Reply</h4>
				</div>
				<div class="modal-body">
						<div class="panel-body">
						 <div class="form-group">
								<label class="col-sm-3 control-label" for="demo-is-inputsmall">Reply :</label>
								 <textarea name="edit_information" id ="edit_information" rows="10" cols="50"></textarea>
						 </div>
						 <input type ="hidden" name ="thread_id" id ="thread_id" value ="<?php echo $thread_id; ?>"/>
						 <input type ="hidden" name ="id" id ="id"/>
						</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value ="Close"/>
					<input type="button" class="btn btn-primary" id ="edit_submit" value ="Save changes"/>
				</div>
			</form>
			</div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
<!-- end: Javascript -->
</body>
</html>
