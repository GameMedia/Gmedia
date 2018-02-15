function view(id){
	"use strict";
	
	jQuery.ajax({
			url:  domain+"content-management/regulasi/getRegulasiData",
			dataType: "json",
			type: "POST",
			data: {
					'id' : id
				  },
			beforeSend: loadingShow('#form_regulasi'),
			success: function(data) {
										sessOut(data);
										if(data.count){
											jQuery('#id').val(data.id);
											jQuery('#type').val(data.type);
											jQuery('#name').val(data.name);
											jQuery('#description').val(data.description);
											jQuery('#path_ori').val(data.path_ori);
											jQuery('#path_thumb').val(data.path_thumb);
											jQuery('#url_ori').val(data.url_ori);
											jQuery('#url_thumb').val(data.url_thumb);
											jQuery('#img_mime').val(data.mime_type);
											jQuery('#display-banner').html('<a href="'+data.url+data.url_thumb+'" target="_blank">File</a>').css('display','inline');
											jQuery('#update_by').html(data.update_by);
											jQuery('#update_time').html(data.update_time);
												
											if(data.status) {
												jQuery('#status').attr('checked', 'checked');
											} else 
												jQuery('#status').attr('checked');
																							
											bootstrapSwitch('status', data.status);
										} else {
											
										}
										loadingHide('#form_regulasi');
									}
		   });	
}

function save(){
	var id = jQuery('#id').val(),
		type = jQuery('#type').val(),
		name = jQuery('#name').val(),
		description = jQuery('#description').val(),
		path_ori = jQuery('#path_ori').val(),
		path_thumb = jQuery('#path_thumb').val(),
		url_ori = jQuery('#url_ori').val(),
		url_thumb = jQuery('#url_thumb').val(),
		mime_type = jQuery('#img_mime').val(),
		status = jQuery('#status').is(':checked') ? 1 : 0;
	
	var form = $('#form_regulasi');
	var error = $('.alert-error-save', form);
    var success = $('.alert-success-save', form);
		
	jQuery.ajax({
			url:  domain+"content-management/regulasi/saveRegulasi",
			dataType: "json",
			type: "POST",
			data: {
					'id' : id,
					'type' : type,
					'name' : name,
					'description' : description,
					'path_ori' : path_ori,
					'path_thumb' : path_thumb,
					'url_ori' : url_ori,
					'url_thumb' : url_thumb,
					'mime_type' : mime_type,
					'status' : status
				  },
			beforeSend: loadingShow('#form_regulasi'),
			success: function(data) {
										sessOut(data);
										if(data.success){
                    						error.hide();
                    						UIToastr.showToaster("success", data.title, data.message);	
                    						$('#datatable').DataTable().ajax.reload();
											clearForm();
											jQuery(".btn-close-modal").trigger("click");
										} else {
											UIToastr.showToaster("error", data.title, data.message);
										}
										loadingHide('#form_regulasi')
									}
		   });	
}

function clearSearchForm(){
	jQuery('#search_id_content_type').val('');
	jQuery('#search_name').val('');
	jQuery('#search_status').val('');
}

function clearForm(){
	jQuery('#id').val('');	
	jQuery('#type').val('');
	jQuery('#name').val('');
	jQuery('#description').val('');
	jQuery('#path_ori').val('');
	jQuery('#path_thumb').val('');
	jQuery('#url_ori').val('');
	jQuery('#url_thumb').val('');
	jQuery('#img_mime').val('');
	jQuery('#display-banner').html('');
	
	jQuery('#status').prop('checked', false);
	
	bootstrapSwitch('status', false);
}

$(function () {
    'use strict';
    $('#fileupload').fileupload({
		url: domain+"content-management/regulasi/uploadRegulasi?files",
		type: 'POST',
		cache: false,
		dataType: 'json',
		processData: false, // Don't process the files
		contentType: false, // Set content type to false as jQuery will tell the server its a query string request,
        progressall: function (e, data) {
			$('.progress-bar').css(
                'width', '0%'
            );
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        },
		success: function(data, textStatus, jqXHR)
		{
			if(data.status){
				jQuery('#path_ori').val(data.files['path_ori']);
				jQuery('#path_thumb').val(data.files['path_thumb']);
				jQuery('#url_ori').val(data.files['url_ori']);
				jQuery('#url_thumb').val(data.files['url_thumb']);
				jQuery('#img_width').val(data.files['img_width']);
				jQuery('#img_height').val(data.files['img_height']);
				jQuery('#img_mime').val(data.files['img_mime']);
				jQuery('#display-banner').html('<a href="'+data.icon+'" target="_blank">View File</a>').css('display','inline');
			} else {
				$('.progress-bar').css(
					'width', '0%'
				);
				UIToastr.showToaster("error", "Upload Banner", data.message);
			}
			loadingHide('body');
		},
		error: function(jqXHR, textStatus, errorThrown)
		{
			console.log('ERRORS: ' + textStatus);
			// STOP LOADING SPINNER
		}
	});
});