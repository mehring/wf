<style type="text/css">

	.addBoxModal {
		position:fixed;
		top:0;
		left:0;
		z-index:900;
		display:none;
	}
	
	.addBoxModal_inner {
		position:absolute;
		top:0;
		left:0;
		z-index:2;
		border-radius:7px;
		background-image:url(../../assets/img/ui/well_bg.png);
		background-position:center top;
		background-repeat:repeat-x;
		background-color:#EFEFEF;
		border:thin solid #C8C8C8;
		border:9px solid rgba(0,0,0,0.40);
		-webkit-background-clip: padding-box; /* for Safari */
    	background-clip: padding-box; /* for IE9+, Firefox 4+, Opera, Chrome */
	}
	
</style>

<div class="addBoxModal">
	<div class="addBoxModal_inner">
    	<div style="padding:10px;">
        	<div class="mattswell_title">Add Boxes to <div style="display:inline-block;" class="addBox_name"></div></div>
            
            <div class="addBoxModal_loading" style="text-align:center;"><img src='<?php echo(base_url("assets/img/ajax-loader.gif")); ?>'></div>
            <div class="addBoxModal_duplicates" style="text-align:center;">
            	<strong>There are duplicate box names in the list, do you wish to add anyway?</strong><br /><br />
                <a class="btn btn-danger btn-large addBox_button_dups_cancel"><i class="icon-remove icon-white"></i>&nbsp;Cancel</a>&nbsp;
                <a class="btn btn-success btn-large addBox_button_dups_yes"><i class="icon-ok icon-white"></i>&nbsp;Yes</a>
            </div>
            <div class="addBoxModal_content">

                <table class="addBoxModal_content_table" cellpadding="0" cellspacing="0" border="0" width="100%">
                	<tr style="background:none;">
                    	<td align="center" valign="middle" style="overflow:scroll;" width="50%">
                        	<strong>Prefix</strong><br />
                            <input class="addBox_field_prefix" type="text" /><br />
                            <br />
                            <strong># Range</strong><br />
                            <input class="addBox_field_rangeStart" type="text" style="width:100px;" />
                            to
                            <input class="addBox_field_rangeEnd" type="text" style="width:100px;" /><br />
                            <br />
                        	<strong>Suffix</strong><br />
                            <input class="addBox_field_suffix" type="text" /><br />
                            <br />
                            <div class="btn-group">
                            	<a class="btn addBox_button_clearList">Clear List</a>
                                <a class="btn addBox_button_addToList">Add to List <i class="icon-chevron-right"></i></a>
                            </div>
                        </td>
                        <td align="left" valign="top" class="addBox_list_cell">
                        	<div class="mattswell">
                            	Enter box names that you want to add to the list below. Each new line is a seperate box.<br />
                                <br />
                                <textarea class="addBox_list"></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr style="background:none;" class="addBoxModal_content_table_taskbar">
                    	<td align="center" colspan="2">
                        	<a class="btn btn-large btn-danger addBoxModal_button_close"><i class="icon-remove icon-white"></i>&nbsp;Cancel</a>&nbsp;
                            <a class="btn btn-large btn-success addBoxModal_button_save"><i class="icon-ok icon-white"></i>&nbsp;Add Boxes</a>&nbsp;
                        </td>
                    </tr>
                </table>
            
            </div>
            
        </div>
    </div>
</div>

<script type="text/javascript">
	var boxes_to_add_clean = new Array();
	
	function resizeaddBoxModal() {
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
		
		$(".addBoxModal").width(WW).height(WH);
		$(".addBoxModal_inner").width(modal_inner_W).height(modal_inner_H).css({"left":modal_inner_L+"px","top":modal_inner_T+"px"});;
		$(".addBoxModal_content_table").height(modal_inner_H-50);
		$(".addBoxModal_content_table_taskbar").height($(".addBoxModal_button_save").height());
		resizeAddBoxList()
	}
	
	function resizeAddBoxList() {
		var list_cell_h = $(".addBox_list_cell").height();
		var list_cell_w = $(".addBox_list_cell").width();
		$(".addBox_list").width(list_cell_w - 40);
		$(".addBox_list").height(list_cell_h - 100);
	}
	
	function hideaddBoxModal() {
		$(".addBoxModal .addBoxModal_inner").fadeOut(function() {
			$(".addBoxModal").hide();	
		});
	}
	
	function showaddBoxModal() {
		$(".addBoxModal .addBoxModal_inner").hide();
		$(".addBoxModal_content").show();
		$(".addBoxModal_loading").hide();
		$(".addBoxModal_duplicates").hide();
		$(".addBox_name").html($('.custom_select.boxes_projectSelector option:selected').text());
		$(".addBoxModal").show();
		$(".addBoxModal .addBoxModal_inner").fadeIn();
		$(".addBox_list").html("");
		$(".addBox_field_prefix").val("");
		$(".addBox_field_suffix").val("");
		$(".addBox_field_rangeStart").val("");
		$(".addBox_field_rangeEnd").val("");
		$(".addBox_list").val('');
		resizeAddBoxList();
	}
	
	function zero_fill(string,digits) {
		var returnText = string.toString();
		while(returnText.length < digits) {
			returnText = "0" + returnText;
		}
		return returnText;
	}
	
	function addBox_add_list_item(string) {
		var oldHTML = $(".addBox_list").val();
		if (oldHTML.trim() == "") {
			var newHTML = string;
		} else {
			var newHTML = oldHTML + "\n" + string;
		}
		$(".addBox_list").val(newHTML);
	}
	
	function addBox_submit() {
		$(".addBoxModal_loading").show();
		$(".addBoxModal_duplicates").hide();
		var project_selected = $('.custom_select.boxes_projectSelector').val();
		$.ajax({
			url: '<?php echo(base_url("index.php/ajax_box/addBox_submit")); ?>',
			type: 'post',
			dataType: 'html',
			data: {project_id_to_add:project_selected,boxes_list:boxes_to_add_clean},
			success: function(data) {
				hideaddBoxModal();
				refresh_admin_boxes_list(project_selected);
			},
			fail: function(data) {
				alert("Error while adding boxes!: "+data);
				hideaddBoxModal();
				refresh_admin_boxes_list(project_selected);
			}
		});
	}
	
	$(".addBox_button_addToList").click(function() {
		var prefix = $(".addBox_field_prefix").val();
		var suffix = $(".addBox_field_suffix").val();
		var rangeStart = $(".addBox_field_rangeStart").val();
		var rangeStart_int = parseInt(rangeStart);
		var rangeEnd = $(".addBox_field_rangeEnd").val();
		var rangeEnd_int = parseInt(rangeEnd);
		var num_digits = 0;
		var html_to_add = "";
		if (rangeStart.trim() == "" || rangeEnd.trim() == "") {
			alert("Need values for range start and range end.");
		} else {
			if (rangeStart_int > rangeEnd_int) {
				alert("Range end cannot be greater than range start.");
			} else {
				if (rangeStart.length > rangeEnd.length) {
					num_digits = rangeStart.length;
				} else {
					num_digits = rangeEnd.length;
				}
				htmlToAdd = ""
				for (i=rangeStart_int;i<=rangeEnd;i++) {
					htmlToAdd += prefix + zero_fill(i,num_digits) + suffix + "\n";
				}
				addBox_add_list_item(htmlToAdd);
			}
		}
	});
	
	$(".addBoxModal_button_save").click(function() {
		var list_text = $(".addBox_list").val();
		var boxes_to_add = list_text.split("\n");
		boxes_to_add_clean = new Array();
		var found_dup = 0;
		for (i=0;i<boxes_to_add.length;i++) {
			if (boxes_to_add[i].trim() != "") {boxes_to_add_clean.push(boxes_to_add[i].trim())};
		}
		if (boxes_to_add_clean.length == 0) {
			alert("There no no boxes in the list to add.");
		} else {
			$(".addBoxModal_content").hide();
			$(".addBoxModal_loading").show();
			
			boxes_to_add_clean.sort();
			for (i=0;i<boxes_to_add_clean.length;i++) {
				if (boxes_to_add_clean[i] == boxes_to_add_clean[i+1]) {found_dup = 1; break;}
			}
			
			if (found_dup == 1) {
				$(".addBoxModal_loading").hide();
				$(".addBoxModal_duplicates").show();
			} else {
				addBox_submit();
			}
		}
		
		
	});
	
	$(".addBox_button_dups_yes").click(function() {addBox_submit();});
	
	$(".addBox_button_dups_cancel").click(function() {
		$(".addBoxModal_duplicates").hide();
		$(".addBoxModal_content").show();
	});
	
	$(".addBox_button_clearList").click(function() {$(".addBox_list").val("")})
	
	$(".addBoxModal_button_close").click(function() {hideaddBoxModal();});
	
	$(document).ready(function() {resizeaddBoxModal();});
	$(window).resize(function() {resizeaddBoxModal();});
	$(window).scroll(function() {resizeaddBoxModal();});
</script>