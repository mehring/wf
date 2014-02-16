<style type="text/css">

	.addHelpModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}
	
	.addHelpModal_inner {
		position:absolute;
		top:0;
		left:0;
		z-index:2;
		border-radius:7px;
		background-image:url(../../assets/img/ui/well_bg.png);
		background-position:center top;
		background-repeat:repeat-x;
		background-color:#EFEFEF;
		border:9px solid rgba(0,0,0,0.40);
		-webkit-background-clip: padding-box; /* for Safari */
    	background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
	}
	
</style>

<div class="addHelpModal">
	<input class="help_id" type="hidden" />
	<input class="help_project_id" type="hidden" />
	<input class="help_project_name" type="hidden" />
	<div class="addHelpModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title">Add Help For - <div style="display:inline-block;" class="addHelp_name"></div></div>
            
            <div class="addHelpModal_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
            <div class="addHelpModal_content">

                <table class="addHelpModal_content_table" cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr style="background:none;">
                    	<td align="left" valign="top">

                            <div class="mattswell" style="text-align:left;margin-bottom:10px;">
                                <table style="background-color:transparent;" cellpadding="5px" width="100%">
                                    <tr class="admin_help_filterGroup admin_help_filterGroup_job" style="background-color:transparent;">
                                        <td align="right" valign="middle" width="100px">Job:&nbsp;</td>
                                        <td align="left" valign="top">
                                            <div class="admin_help_filter_job_loading" style="text-align:center;display:none;">
                                                <img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'>
                                            </div>
                                            <div class="admin_help_filter_job_body">
                                                <select class="admin_help_filter_job" style="width:100%;margin-bottom:0px;">
                                                    <option value="-1">Select One</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            <textarea id="admin_help_tinymce"></textarea>

                        </td>
                    </tr>
                    <tr style="background:none;" class="addHelpModal_content_table_taskbar">
                    	<td align="center">
                        	<a class="btn btn-large btn-danger addHelpModal_button_close"><i class="icon-remove icon-white"></i>&nbsp;Cancel</a>&nbsp;
                            <a class="btn btn-large btn-success addHelpModal_button_save"><i class="icon-ok icon-white"></i>&nbsp;Save and Close</a>&nbsp;
                        </td>
                    </tr>
                </table>
            
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">

	function resizeaddHelpModal() {
		var WW = $(window).width();
		var WH = $(window).height();
		
		var modal_inner_W = WW-80;
		var modal_inner_H = WH-80;
		var modal_inner_T = (WH/2) - (modal_inner_H/2);
		var modal_inner_L = (WW/2) - (modal_inner_W/2);
		
		var modal_outer_W = WW-50;
		var modal_outer_H = WH-50;
		var modal_outer_T = (WH/2) - (modal_outer_H/2);
		var modal_outer_L = (WW/2) - (modal_outer_W/2);
		
		$(".addHelpModal").width(WW).height(WH);
		$(".addHelpModal_inner").width(modal_inner_W).height(modal_inner_H).css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});;
		$(".addHelpModal_content_table").height(modal_inner_H-50);
		$(".addHelpModal_content_table_taskbar").height($(".addHelpModal_button_save").height());
		if(Object.prototype.toString.call( tinymce.editors ) === '[object Array]') {
			$('#admin_help_tinymce').tinymce().theme.resizeTo(null,modal_inner_H-250);
		}
	}
	
	function hideaddHelpModal() {
		$(".addHelpModal .addHelpModal_inner").fadeOut(function() {
			$(".addHelpModal").hide();	
		});
	}
	
	function showaddHelpModal(id_to_edit) {
		if (!id_to_edit) {id_to_edit = -1;}
		
		if (id_to_edit < 0) {
			$(".admin_help_filter_job").val(-1);
			$('#admin_help_tinymce').tinymce().execCommand('mceSetContent',false,'');
		} else {
			for (var i=0;i<cur_help.length;i++) {
				if (cur_help[i].id == id_to_edit) {
					$(".admin_help_filter_job").val(cur_help[i].job_id);
					$('#admin_help_tinymce').tinymce().execCommand('mceSetContent',false,cur_help[i].help_content);
				}
			}
		}
		
		$(".help_id").val(id_to_edit);
		$(".addHelpModal .addHelpModal_inner").hide();
		$(".addHelpModal_content").show();
		$(".addHelpModal_loading").hide();
		$(".addHelpModal").show();
		$(".addHelpModal .addHelpModal_inner").fadeIn();
	}
	
	$(".addHelpModal_button_close").click(function() { hideaddHelpModal(); });
	
	$(".addHelpModal_button_save").click(function() {
		var help_id = $('.help_id').val();
		var project_id = $('.help_project_id').val();
		var job_id = $('.admin_help_filter_job').val();
		var msg_body = $("#admin_help_tinymce").tinymce().getContent();
		
		var data_to_send = {
			'help_id':help_id,
			'project_id':project_id,
			'job_id':job_id,
			'msg_body':msg_body
		};
		
		if (job_id == "-1") {
			alert("Select a job first.");
		} else {
			$('.addHelpModal_content').hide();
			$('.addHelpModal_loading').show();
			
			$.ajax({
				url:'<?php echo(base_url("index.php/ajax_help/save_help")); ?>',
				type:"POST",
				dataType:"json",
				data:{data_to_send:data_to_send},
				complete:function(data){
					hideaddHelpModal();
					refresh_admin_help_list(project_id)
				}
			});
			
		}
		
	});

	$(document).ready(function() {
		
		$('#admin_help_tinymce').tinymce({
			script_url:"<?php echo(base_url("assets/js/tinymce/tinymce.min.js")); ?>",
			toolbar:"newdocument bold italic underline strikethrough fontselect fontsizeselect alignleft aligncenter alignright alignjustify bullist numlist outdent indent undo redo removeformat image",
			theme_advanced_resizing:true,
			menubar:false,
			plugins:"image",
			setup:function(ed)
			{
				ed.on('init', function() 
				{
					this.getDoc().body.style.fontSize = '16px';
					resizeaddHelpModal();
				});
			},
			height:200
		});

		resizeaddHelpModal();
			
	});
	$(window).resize(function() {resizeaddHelpModal();});
	$(window).scroll(function() {resizeaddHelpModal();});
</script>