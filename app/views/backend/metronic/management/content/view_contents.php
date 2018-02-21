				<link rel="stylesheet" href="<?php echo ASSETS_PLUGINS;?>datatables/plugins/bootstrap/dataTables.bootstrap.css" type="text/css"/>
				<link rel="stylesheet" href="<?php echo ASSETS_PLUGINS;?>bootstrap-toastr/toastr.min.css" type="text/css"/>
				<link rel="stylesheet" href="<?php echo ASSETS_PLUGINS;?>bootstrap-multiselect/bootstrap-multiselect.css" type="text/css"/>
				<!--<div class="row margin-top-20">-->
				<div class="col-md-12 column sortable" id="list-content">
					<div class="portlet portlet-sortable light bordered">
						<div class="portlet-title tabbable-line">
							<div class="caption">
								<i class="icon-puzzle font-red-flamingo"></i>
								<span class="caption-subject bold font-red-flamingo uppercase"><?php echo $pageTitle;?></span>
							</div>
							<div class="actions">
								<select id="colList" multiple="multiple" class="toggle-vis yellow-stripe">
								  <option value="0" data-column="0" selected>Rec</option>
								  <option value="1" data-column="1" selected>Game</option>
								  <option value="1" data-column="2" selected>Content Type</option>
								  <option value="2" data-column="3" selected>Name</option>
								  <option value="3" data-column="4" selected>Image</option>
								  <option value="3" data-column="5" selected>Publish Time</option>
								  <option value="4" data-column="6" selected>Is Active?</option>
								  <option value="5" data-column="7" selected>Action</option>
								</select>
								<?php if($accessAdd){?>
								<a href="javascript:;" class="btn default yellow-stripe" onclick="showView(1)">
									<i class="fa fa-plus"></i>
									<span class="hidden-480">Add <?php echo $pageTitle;?> </span>
								</a>
								<?php } ?>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-container">
								<div class="table-actions-wrapper">
									<span></span>
								</div>
								<table class="table table-striped table-bordered table-hover" id="datatable">
								<thead>
								<tr role="row" class="heading">
									<th class="no-sort" width="50px">Rec.</th>
									<th width="100px">Game</th>
									<th width="100px">Type</th>
									<th>Name</th>
									<th class="no-sort" width="80px">Image</th>
									<th width="110px">Publish</th>
									<th width="70px">is Active?</th>
									<th  class="no-sort"width="100px">Actions</th>
								</tr>
								<tr role="row" class="filter">
									<td></td>
									<td>
										<select name="search_id_game" id="search_id_game" data-required="1" class="form-control form-filter input-sm" title="Game">
											<option value="">- All Game -</option>
											<?php foreach($games['rows'] as $key){ ?>
											<option value="<?php echo $key['id'];?>"><?php echo $key['name'];?></option>
											<?php } ?>
										</select>
									</td>
									<td>
										<select name="search_id_content_type" id="search_id_content_type" data-required="1" class="form-control form-filter input-sm" title="Type">
											<option value="">- All Type -</option>
											<?php foreach($content_types['rows'] as $key){ ?>
											<option value="<?php echo $key['id'];?>"><?php echo $key['name'];?></option>
											<?php } ?>
										</select>
									</td>
									<td><input type="text" class="form-control form-filter input-sm" id="search_name" name="search_name" placeholder="Search by Name"></td>
									<td></td>
									<td><input type="text" class="form-control form-filter input-sm" id="search_publish_time" name="search_publish_time" placeholder="Search by Time"></td>
									<td>
										<select name="search_status" id="search_status" class="form-control form-filter input-sm">
											<option value="">- All -</option>
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
									</td>
									<td>
										<div class="margin-bottom-5">
											<button class="btn btn-sm yellow filter-submit margin-bottom" title="Search"><i class="fa fa-search"></i></button>
											<button class="btn btn-sm red filter-cancel" title="Reset" onclick="clearSearchForm()"><i class="fa fa-times"></i></button>
										</div>
										
									</td>
								</tr>
								</thead>
								<tbody>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!--</div>-->
				<!-- /.modal -->
				<!-- <div id="formAdd" class="modal fade" tabindex="-1" data-backdrop="static" data-width="400" data-keyboard="false" data-attention-animation="true">-->
				<div class="col-md-12 column sortable" id="view-content" style="display:none">
					<div class="portlet portlet-sortable light bordered">
						<div class="portlet-title tabbable-line">
							<div class="caption">
								<i class="icon-puzzle font-red-flamingo"></i>
								<span class="caption-subject bold font-red-flamingo uppercase"><?php echo $pageTitle;?></span>
							</div>
							<div class="actions">
								<a href="javascript:;" class="btn default yellow-stripe" onclick="showView(0)">
									<i class="fa fa-bars"></i><span class="hidden-480"> Lists <?php echo $pageTitle;?> </span>
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-container">
								<form action="javascript:;" id="form_contents" class="form-horizontal">
									<div class="modal-body">
										<input type="hidden" name="id" id="id" readonly class="span6 m-wrap"/>
										<div class="form-group">
										  <label  class="col-md-2 control-label">Game</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips" data-original-title="please choose an Game" data-container="body"></i>
												<select name="id_game" id="id_game" data-required="1" class="form-control" title="Game">
													<option value="">- Choose Game -</option>
													<?php foreach($games['rows'] as $key){ ?>
													<option value="<?php echo $key['id'];?>"><?php echo $key['name'];?></option>
													<?php } ?>
												</select>
											</div>
										  </div>
										</div>
										<div class="form-group">
										  <label  class="col-md-2 control-label">Content Type</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips" data-original-title="please write a name" data-container="body"></i>
												<select name="id_content_type" id="id_content_type" data-required="1" class="form-control" title="Type">
													<option value="">- Choose Type -</option>
													<?php foreach($content_types['rows'] as $key){ ?>
													<option value="<?php echo $key['id'];?>"><?php echo $key['name'];?></option>
													<?php } ?>
												</select>
											</div>
										  </div>
										</div>
										<div class="form-group">
										  <label  class="col-md-2 control-label">Name</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips" data-original-title="please write a name" data-container="body"></i>
												<input type="text" maxlength="255" name="name" id="name" data-required="1" class="form-control" title="Name" placeholder="Name" />
											</div>
										  </div>
										</div>
										<div class="form-group">
										  <label  class="col-md-2 control-label">Short Description ID</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips" data-original-title="please write a short desc" data-container="body"></i>
												<textarea name="short_desc" id="short_desc" data-required="1" class="form-control" title="Short Description" placeholder="Short Description" rows="5"></textarea>
											</div>
										  </div>
										</div>						
										<div class="form-group">
										  <label  class="col-md-2 control-label">Long Description ID</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<textarea name="long_desc" id="long_desc" class="m-wrap"></textarea>
											</div>
										  </div>
										</div>	
										<div class="form-group">
										  <label  class="col-md-2 control-label">Short Description EN</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips" data-original-title="please write a short desc" data-container="body"></i>
												<textarea name="short_desc_en" id="short_desc_en" data-required="1" class="form-control" title="Short Description" placeholder="Short Description" rows="5"></textarea>
											</div>
										  </div>
										</div>						
										<div class="form-group">
										  <label  class="col-md-2 control-label">Long Description EN</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<textarea name="long_desc_en" id="long_desc_en" class="m-wrap"></textarea>
											</div>
										  </div>
										</div>	
										<div class="form-group">
										  <label  class="col-md-2 control-label">Published</label>
										  <div class="col-md-6">
											<div class="input-icon right">
												<input type="text" maxlength="20" name="publish_time" id="publish_time" data-required="1" class="form-control" title="Published" placeholder="Published"/>
											</div>
										  </div>
										  <div class="col-md-2">
											<div class="input-icon right">
											  <div class="input-group">
												<span class="input-group-addon">
												  <i class="fa fa-eye"></i>
												</span>
												<input type="text" maxlength="255" name="seen" id="seen" data-required="1" class="form-control" title="Seen" placeholder="Seen" disabled />
											  </div>
											</div>
										  </div>
										</div>
										<div class="form-group">
										  <label  class="col-md-2 control-label">Image</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<input type="hidden" id="id_gallery" name="id_gallery"/>
												<input type="hidden" id="path_thumb" name="path_thumb"/>
												<input type="hidden" id="path_ori" name="path_ori"/>
												<input type="hidden" id="url_thumb" name="url_thumb"/>
												<input type="hidden" id="url_ori" name="url_ori"/>
												<input type="hidden" id="img_width" name="img_width"/>
												<input type="hidden" id="img_height" name="img_height"/>
												<input type="hidden" id="img_mime" name="img_mime"/>
												<i class="fa fa-exclamation tooltips" data-original-title="please choose " data-container="body"></i>
												<input type="file" name="fileupload" id="fileupload" data-required="1" class="form-control" title="File" placeholder="File" value="Select File..."/>
												<!-- The global progress bar -->
												<div id="progress" class="progress" style="margin-top:10px;">
													<div class="progress-bar progress-bar-success"></div>
												</div>
												<span class="help-block" id="display-banner" style="display:none"></span>									
											</div>
										  </div>
										</div>	
										<div class="form-group">
										  <label  class="col-md-2 control-label">is Active?</label>
										  <div class="col-md-10">
											<div class="input-icon right">
												<i class="fa fa-exclamation tooltips" data-original-title="please choose is Active" data-container="body"></i>
												<input type="checkbox" id="status" name="status" class="make-switch" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
											</div>
										  </div>
										</div>
									</div>
									<div class="modal-footer">
										<p style="float:left">Last update by <i id="update_by"></i> On <i id="update_time"></i></p>
										<button type="button" class="btn btn-close-modal" data-dismiss="modal" onclick="clearForm();showView(0)">Close</button>
										<button type="submit" class="btn red<?php echo ($accessEdit)?' btn-edit':'';?><?php echo ($accessAdd)?' btn-add':'';?>"><i class="fa fa-save"></i> Save</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				
	
	<script type="text/javascript" src="<?php echo ASSETS_PLUGINS;?>datatables/media/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo ASSETS_PLUGINS;?>datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>	
	<script type="text/javascript" src="<?php echo ASSETS_PLUGINS;?>bootstrap-multiselect/bootstrap-multiselect.js"></script>
	<script type="text/javascript" src="<?php echo ASSETS_PLUGINS;?>bootstrap-toastr/toastr.min.js"></script>
	
	<script type="text/javascript" src="<?php echo ASSETS_PLUGINS;?>ckeditor/ckeditor.js"></script> 
			
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="<?php echo ASSETS_PLUGINS;?>jquery-file-upload/js/jquery.iframe-transport.js"></script>
	<script src="<?php echo ASSETS_PLUGINS;?>jquery-file-upload/js/jquery.fileupload.js"></script>
	
	<script type="text/javascript" src="assets/js/backend/datatable.js"></script>
	<script type="text/javascript" src="assets/js/backend/datatables.js?<?php echo date("mdH");?>"></script>
    <script type="text/javascript" src="assets/js/backend/ui-toastr.js"></script>
	
	<script type="text/javascript" src="assets/js/backend/management/content/contents.js?<?php echo date("mdH");?>"></script>
	<script type="text/javascript">
		var deleteID = "",
			deleteLangID = "";
		
		jQuery(document).ready(function() {	
			//Define Validation
			var rules = {
						id_game: {required: true},
						id_content_type: {required: true},
						name: {minlength: 4,required: true},
						short_desc: {required: true},
						publish_time: {required: true}
						};			
			
            FormValidation.init('form_contents', rules);
            
			TableAjax.init("datatable", "content-management/contents/loadContents");
			UIToastr.init();
			
			bootstrapMultiselect("colList");
			
			$(function(){
			  $('#modal-body-editor').css({ height: ($(window).innerHeight()-180)});
			  $('#cke_1_contents').css({ height: ($(window).innerHeight()-340) });
			  $(window).resize(function(){
				$('#modal-body-editor').css({ height: ($(window).innerHeight()-180) });
				$('#cke_1_contents').css({ height: ($(window).innerHeight()-340) });
			  });
			});
			
			CKEDITOR.replace( 'long_desc', {
				fullPage: true,
				allowedContent: true,
				extraPlugins: 'wysiwygarea'
			});
			
			CKEDITOR.replace( 'long_desc_en', {
				fullPage: true,
				allowedContent: true,
				extraPlugins: 'wysiwygarea'
			});
		});
    </script>
<?php $this->load->view($folderLayout.'_modal');?>