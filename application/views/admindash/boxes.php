<style type="text/css">
	
	tbody tr {
		background-color:transparent;
	}
	
	.text_active {
		color:#49A942;
	}
	
	.text_hidden {
		color:#999;
		font-style:italic;
	}
	
	.custom_select_label {
		
	}
	
	.custom_select {
		font-size:18px;
		height:35px;
		width:100%;
		margin-top:5px;
	}
	
	.box_status_link:HOVER {
		cursor:pointer;
	}
	
	.table_nav {
		margin:0 !important;
	}
	
</style>

<div class="admin_boxes_projectSelector mattswell" style="text-align:left;display:none;"></div>

<div class="mattswell_title" style="padding-top:10px;">Boxes List</div>

<div class="admin_boxes_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>

<div class="admin_boxes" style="display:none;">
	<div class="btn-group" style="display:inline-block;float:left;">
    	<button class="btn button_admin_add_boxes"><i class="icon-plus"></i> Add Boxes</button>
    </div>
    
    <div class="admin_boxes_itemsper_selector" style="display:inline-block;float:right;position:relative;top:-37px;">
    	Display:&nbsp;
        <div style="display:inline-block;" class="btn-group admin_boxes_btnlst_itemsper" data-toggle="buttons-radio">
        	<a class="btn admin_boxes_btn_itemsper active">10</a>
            <a class="btn admin_boxes_btn_itemsper">25</a>
            <a class="btn admin_boxes_btn_itemsper">50</a>
            <a class="btn admin_boxes_btn_itemsper">100</a>
        </div>
        &nbsp;per page
    </div>
    
    <div class="page_selector" style="display:inline-block;float:right;position:relative;">
    	<div style="display:inline-block;" class="pages_label"></div>&nbsp;
        <div class="btn-group">
        	<a class="btn admin_boxes_btn_navpage_fast_backward"><i class="icon-fast-backward"></i></a>
            <a class="btn admin_boxes_btn_navpage_backward"><i class="icon-backward"></i></a>
        </div>
        <div style="display:inline-block;" class="btn-group btnlst_page" data-toggle="buttons-radio"></div>
        <div class="btn-group">
        	<a class="btn admin_boxes_btn_navpage_forward"><i class="icon-forward"></i></a>
            <a class="btn admin_boxes_btn_navpage_fast_forward"><i class="icon-fast-forward"></i></a>
        </div>
    </div>
    
    <div style="clear:both;"></div>
    
    <div class="list_boxes"></div>
    
    <div class="page_selector_bot" style="display:inline-block;float:right;">
    	<div style="display:inline-block;" class="pages_label"></div>&nbsp;
        <div class="btn-group">
        	<a class="btn admin_boxes_btn_navpage_fast_backward"><i class="icon-fast-backward"></i></a>
            <a class="btn admin_boxes_btn_navpage_backward"><i class="icon-backward"></i></a>
        </div>
        <div style="display:inline-block;" class="btn-group btnlst_page" data-toggle="buttons-radio"></div>
        <div class="btn-group">
        	<a class="btn admin_boxes_btn_navpage_forward"><i class="icon-forward"></i></a>
            <a class="btn admin_boxes_btn_navpage_fast_forward"><i class="icon-fast-forward"></i></a>
        </div>
    </div>
</div>

<div class="modal hide modal_renameBox">
  <div class="modal-header">
    <button type="button" class="close button_close_renameBox" aria-hidden="true">&times;</button>
    <h3>Modify Box</h3>
  </div>
  <div class="modal-body">
    <div class="modal_renameBox_name" style="text-align:center;">
    	<input type="hidden" class="field_renameBox_id" maxlength="100" />
        <table width="100%" cellpadding="4px" cellspacing="0" border="0">
        	<tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;">Name:</td>
                <td><input type="text" class="field_renameBox" maxlength="100" /></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;"># Small Format:</td>
                <td><input type="text" class="field_modBox_sf" /></td>
            </tr>
            <tr style="background-color:transparent;">
            	<td align="right" style="font-weight:bold;"># Large Format:</td>
                <td><input type="text" class="field_modBox_lf" /></td>
            </tr>
        </table>
    </div>
    <div class="modal_renameBox_loading" style="text-align:center; display:none;">
    	Attempting to modify <div class="renameBox_label" style="display:inline-block"></div><br />
    	<img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
    </div>
  </div>
  <div class="modal-footer modal_renameBox_footer">
    <a href="#" class="btn btn-danger button_close_renameBox"><i class="icon-remove icon-white"></i>&nbsp;Close</a>
    <a href="#" class="btn btn-primary button_renameBox_submit"><i class="icon-ok icon-white"></i>&nbsp;Submit</a>
  </div>
</div>

<script type="text/javascript">
	
	function refresh_admin_boxes_projectselector_list() {
		$('.admin_boxes_projectSelector').hide();
		$('.admin_boxes').hide();
		$('.admin_boxes_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/get_admin_boxes_projectselector_list")); ?>',
			dataType: 'html',
			success: function(data) {
				$('.admin_boxes_projectSelector').html(data);
				$('.admin_boxes_projectSelector').show();
				$('.admin_boxes').hide();
				$('.admin_boxes_loading').hide();
				
				var launch_project = $('.launch_project').val();
				if(launch_project != "") {
					$('.custom_select.boxes_projectSelector').val(launch_project);
					cur_project = launch_project;
					cur_page = 1;
					refresh_admin_boxes_list(launch_project);
					showaddBoxModal();
					$('.launch_project').val("");
				}
			},
			fail: function(data) {
				alert("Error while updating project selector list: "+data);
				$('.admin_boxes_projectSelector').show();
				$('.admin_boxes').hide();
				$('.admin_boxes_loading').hide();
			}
		});
	}

	function refresh_admin_boxes_list(project_selected) {	
		$('.admin_boxes').hide();
		$('.admin_boxes_loading').show();
		$('.admin_boxes_projectSelector').hide();
		refresh_page_value();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/get_admin_boxes_list")); ?>',
			type: 'post',
			dataType: 'json',
			data: {project_selected:project_selected,itemsper:cur_itemsper,page:cur_page},
			success: function(data) {
				records_total = data.boxes_total;

				htmlToSet = "";
				htmlToSet += "\
				<table class=\"table hover_table solid_table table-condensed\" style=\"margin-top:15px;\">\
    			\
				<thead><tr>\
					<th>Box Name</th>\
					<th>Status</th>\
					<th># SF</th>\
					<th># LF</th>\
					<th>Actions</th>\
				</tr></thead>\
				\
				<tbody>";
				
				for (var i=0;i<data.boxes.length;i++) {
					
					var cur_status_name = "";
					for (var j=0;j<data.statuses.length;j++) {
						if (data.boxes[i]['box_status_id'] == data.statuses[j]['id']) {
							cur_status_name = data.statuses[j]['box_status_name'];
						}
					}
					
					htmlToSet += "\
					<tr class=\"box_row\" itemID="+data.boxes[i]['id']+">\
						<td><?php echo("<img src=".base_url("assets/img/ui/icons/box.png")." />") ?>&nbsp;"+data.boxes[i]['box_name']+"</td>\
						<td style=\"padding: 2px 0 0 8px;\">\
							<ul class=\"nav nav-pills table_nav\">\
								<li class=\"dropdown\">\
									<a class=\"dropdown-toggle\" id=\"box_status_"+data.boxes[i]['id']+"\" data-toggle=\"dropdown\" role=\"button\" href=\"#\">"+cur_status_name+"&nbsp;<span class=\"caret\"></span></a>\
									<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"box_status_"+data.boxes[i]['id']+"\">";
									for (var j=0;j<data.statuses.length;j++) {
										htmlToSet += "<li><a class=\"box_status_link\" box_id=\""+data.boxes[i]['id']+"\" status_id=\""+data.statuses[j]['id']+"\">"+data.statuses[j]['box_status_name']+"</a></li>";
									}
					htmlToSet += "</ul>\
								</li>\
							</ul>\
						</td>\
						<td>"+data.boxes[i]['sf']+"</td>\
						<td>"+data.boxes[i]['lf']+"</td>\
						<td>\
						  <a class=\"admin_button black button_admin_rename_box\" style=\"color:black;\"\
						  	itemID="+data.boxes[i]['id']+"\
							sf="+data.boxes[i]['sf']+"\
							lf="+data.boxes[i]['lf']+"\
							box_name=\""+data.boxes[i]['box_name']+"\"><span class=\"ico-edit\"></span>&nbsp;Modify</a>\
						  <a class=\"admin_button red button_admin_delete_box\" style=\"color:red;\" itemID="+data.boxes[i]['id']+"><span class=\"ico-trash\"></span>&nbsp;Delete</a>\
						</td>\
					</tr>";
					
				}
				
				htmlToSet += "</tbody></table>";
				
				$('.list_boxes').html(htmlToSet);
				$('.admin_boxes_projectSelector').show();
				$('.admin_boxes').show();
				$('.admin_boxes_loading').hide();
				var left_to_set = $('.admin_boxes_itemsper_selector').width();
				$('.page_selector').css('left',left_to_set+"px");
				refresh_page_value('button_boxes')
			},
			fail: function(data) {
				alert("Error while updating boxes list: "+data);
				$('.admin_boxes_projectSelector').show();
				$('.admin_boxes').hide();
				$('.admin_boxes_loading').hide();
				refresh_page_value('button_boxes')
			}
		});
	}
	
	function sumbit_rename_box() {
		var box_id = $('.field_renameBox_id').val();
		var new_box_name = $('.field_renameBox').val();
		var box_sf = $('.field_modBox_sf').val();
		var box_lf = $('.field_modBox_lf').val();
		$('.modal_renameBox_name').hide();
		$('.modal_renameBox_footer').hide();
		$('.modal_renameBox_loading').show();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/rename_box")); ?>',
			type: 'post',
			dataType: 'html',
			data: {
				box_to_change:box_id,
				new_name:new_box_name,
				box_lf:box_lf,
				box_sf:box_sf
			},
			success: function(data) {
				$('.modal_renameBox').modal('hide');
				refresh_admin_boxes_list(cur_project);
			},
			error: function(data) {
				alert("I could not modify the box with that information.");
				$('.modal_renameBox_name').show();
				$('.modal_renameBox_footer').show();
				$('.modal_renameBox_loading').hide();
			}
		});
	}

	$('.box_status_link').live('click', function() {
		var box_id = $(this).attr('box_id');
		var status_id = $(this).attr('status_id');
		var status_name = $(this).html();
		$('#box_status_'+box_id).html(status_name + "&nbsp;<span class=\"caret\"></span>");
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/change_box_status")); ?>',
			type: 'post',
			data: {box_to_change:box_id,status_to_change:status_id}
		});
	});
	
	$('.boxes_projectSelector').live('change',function() {
		cur_project = $('option[class="boxes_projectSelector"]:selected', this).attr('item_id');
		if (cur_project == -1) {
			$('.admin_boxes').hide();
		} else {
			cur_page = 1;
			refresh_admin_boxes_list(cur_project);
		}
	});
	
	// ********* PAGINATION STUFF *********
	$('.btn_boxes_page').live('click',function() {
		cur_page = parseInt($(this).html());
		refresh_admin_boxes_list(cur_project);
	});
	
	$('.admin_boxes_btn_itemsper').click(function() {
		cur_itemsper = parseInt($(this).html());
		refresh_admin_boxes_list(cur_project);
	});
	
	$('.admin_boxes_btn_navpage_fast_backward').click(function() {
		cur_page = 1;
		refresh_admin_boxes_list(cur_project);
	});
	
	$('.admin_boxes_btn_navpage_backward').click(function() {
		var go_to_page = cur_page - 1;
		if (go_to_page < 1) {go_to_page = 1}
		cur_page = go_to_page;
		refresh_admin_boxes_list(cur_project);
	});
	
	$('.admin_boxes_btn_navpage_forward').click(function() {
		var go_to_page = cur_page + 1;
		if (go_to_page > pages_total) {go_to_page = pages_total}
		cur_page = go_to_page;
		refresh_admin_boxes_list(cur_project);
	});
	
	$('.admin_boxes_btn_navpage_fast_forward').click(function() {
		cur_page = pages_total;
		refresh_admin_boxes_list(cur_project);
	});
	
	// ********* END PAGINATION STUFF *********
	
	$('.button_admin_rename_box').live('click', function() {
		var box_name = $(this).attr('box_name');
		var box_id = $(this).attr('itemID');
		var box_sf = $(this).attr('sf');
		var box_lf = $(this).attr('lf');
		$('.renameBox_label').html(box_name);
		$('.field_renameBox').val(box_name);
		$('.field_renameBox_id').val(box_id);
		$('.field_modBox_sf').val(box_sf);
		$('.field_modBox_lf').val(box_lf);
		
		$('.modal_renameBox_name').show();
		$('.modal_renameBox_footer').show();
		$('.modal_renameBox_loading').hide();
		
		$('.modal_renameBox').modal('show');
		$('.modal_renameBox').on('shown',function() {
			$('.field_renameBox').focus();
		});
	});
	
	$('.button_admin_delete_box').live('click', function() {
		var ID_selected = $(this).attr('itemID');
		$('tr[itemID="'+ID_selected+'"]').hide('slow');
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/delete_box")); ?>',
			type: 'post',
			dataType: 'html',
			data: {box_to_delete:ID_selected},
			success: function(data) {
			},
			fail: function(data) {
				alert("Error while deleting box: "+data);
			}
		});
	});
	
	$('.button_admin_add_boxes').click(function() {showaddBoxModal();});
	
	$('.button_close_renameBox').click(function() {$('.modal_renameBox').modal('hide');});
	$('.button_renameBox_submit').click(function() {sumbit_rename_box();});
	$('.field_renameBox').keypress(function(e) {
		if (e.which == 13) {sumbit_rename_box();}
	});
	
</script>