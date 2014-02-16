function refresh_page_value(pane_override) {
	if (records_total == 0) {
		pages_total = 1;
		cur_page = 1;
	} else {
		pages_total = Math.ceil(records_total / cur_itemsper);
	}
	
	if (cur_page > pages_total) {cur_page = pages_total}

	var htmlToSet = "";
	var startPage = parseInt(cur_page) - 3;
	var endPage = parseInt(cur_page) + 3;

	if (pages_total > 7) {
		while (startPage < 1) {
			startPage++;
			endPage++;
		}
		
		while (endPage > pages_total) {
			startPage--;
			endPage--;
		}	
	} else {
		startPage = 1;
		endPage = pages_total;
	}
	
	if (!cur_pane) {
		var cur_pane = pane_override;
	}
	
	console.log(cur_pane);
	
	for (var i=startPage;i<=endPage;i++) {
		if (String(i) == cur_page) {
			switch(cur_pane) {
				case "button_boxes":
					htmlToSet += "<a class=\"btn btn_boxes_page active\">"+i+"</a>";
					break;
				default:
					htmlToSet += "<a class=\"btn btn_logs_page active\">"+i+"</a>";
					break;
			}
		} else {
			switch(cur_pane) {
				case "button_boxes":
					htmlToSet += "<a class=\"btn btn_boxes_page\">"+i+"</a>";
					break;
				default:
					htmlToSet += "<a class=\"btn btn_logs_page\">"+i+"</a>";
					break;
			}
		}
	}
	
	$('.btnlst_page').html(htmlToSet);
	
	records_start = ((cur_page-1)*cur_itemsper)+1;
	records_end = records_start + cur_itemsper;
	if (records_end > records_total) {records_end = records_total;}
	if (records_end == 0) {records_start = 0;}
	htmlToSet = "[" + records_start + " - " + records_end + " of " + records_total + "]" + " [Page " + cur_page + " of " + pages_total + "]";
	$('.pages_label').html(htmlToSet);
}