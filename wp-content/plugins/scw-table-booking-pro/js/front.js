(function($) {
"use strict";
	var url = jQuery(".scwatbwsr_url").val();
	var proid = jQuery(".product_id").val();
	var roomid = jQuery(".profileid").val();
	var tbbookedcolor = jQuery(".tbbookedcolor").val();
	var seatbookedcolor = jQuery(".seatbookedcolor").val();
	var compulsory = jQuery(".scw_compulsory").val();
	var bookingtime = jQuery(".scw_bookingtime").val();
	var date_format = jQuery(".scw_date_format").val();
	var roomwidth = jQuery(".scw_roomwidth").val();
	var roomheight = jQuery(".scw_roomheight").val();
	var posttype = jQuery(".scw_posttype").val();
	
	/*var phantram = 100/roomwidth*roomheight;
	var bw = jQuery(".scwatbwsr_map_block").width();
	console.log(bw);
	var fh = bw/100*phantram;
	jQuery(".scwatbwsr_map_block").css("height", fh+"px");*/
	
	jQuery(".tbf").before(jQuery(".scwatbwsr_content").show());
	jQuery(".scwatbwsr_content").after(jQuery("form.cart"));
	
	if(compulsory == "yes")
		jQuery(".single_add_to_cart_button").prop("disabled", true);
	
	function checkSchedule(schedule){
		jQuery.ajax({
			type: "POST",
			url: url+"helper.php",
			data:{
				task: "check_schedule",
				schedule: schedule,
				roomid: roomid,
				proid: proid,
				bookingtime: bookingtime
			},
			beforeSend : function(data){
				jQuery(".scwatbwsr_map").css("opacity", "0.5");
			},
			success : function(data){
				jQuery(".scwatbwsr_map").css("opacity", "1");
				
				jQuery(".scwatbwsr_map_tables_table").each(function(){
					var thistb = jQuery(this);
					
					var tbreadcolor = thistb.children(".scwatbwsr_table_readcolor").val();
					var seatreadcolor = thistb.children(".scwatbwsr_seat_readcolor").val();
					
					thistb.css("background", tbreadcolor+" none repeat scroll 0% 0% padding-box content-box");
					thistb.find(".scwatbwsr_map_tables_table_seat").css("background", seatreadcolor).removeClass("seatbooked");
				});
				
				if(data.length > 0){
					jQuery.each(data, function(key, val){
						var seat = val.replace(".", "");
						
						jQuery("#seat"+seat).css("background", seatbookedcolor).addClass("seatbooked");
					});
					
					jQuery(".scwatbwsr_map_tables_table").each(function(){
						if(jQuery(this).find(".scwatbwsr_map_tables_table_seat").size() == jQuery(this).find(".scwatbwsr_map_tables_table_seat.seatbooked").size())
							jQuery(this).css("background", tbbookedcolor+" none repeat scroll 0% 0% padding-box content-box");
					});
				}
			},
			dataType: 'json'
		});
	}
	
	jQuery(".scwatbwsr_map_tables_table").each(function(){
		var thistb = jQuery(this);
		
		thistb.find(".scwatbwsr_map_tables_table_seat").each(function(){
			var thiseat = jQuery(this);
			
			thiseat.on("click", function(){
				if(!thiseat.hasClass("seatbooked")){
					if(jQuery(".scwatbwsr_schedules_daily").size() > 0 || jQuery(".scwatbwsr_schedules_item").size() > 0){
						if(jQuery("#scwatbwsr_schedules_picker").val() || jQuery(".scwatbwsr_schedules_item.active").size() > 0){
							if(thiseat.hasClass("active"))
								thiseat.removeClass("active");
							else
								thiseat.addClass("active");
							sessSeat();
						}else
							alert("Please choose schedule first!");
					}else
						sessSeat();
				}
			});
		});
		thistb.children(".scwatbwsr_map_tables_table_label").on("click", function(){
			if(jQuery(".scwatbwsr_schedules_daily").size() > 0 || jQuery(".scwatbwsr_schedules_item").size() > 0){
				if(jQuery("#scwatbwsr_schedules_picker").val() || jQuery(".scwatbwsr_schedules_item.active").size() > 0){
					if(thistb.find(".seatbooked").size() > 0){
						alert("Can not book whole table!");
					}else{
						if(jQuery(this).hasClass("active")){
							jQuery(this).removeClass("active");
							thistb.find(".scwatbwsr_map_tables_table_seat").removeClass("active");
						}else{
							jQuery(this).addClass("active");
							thistb.find(".scwatbwsr_map_tables_table_seat").addClass("active");
						}
						sessSeat();
					}
				}else
					alert("Please choose schedule first!");
			}else{
				if(thistb.find(".seatbooked").size() > 0){
					alert("Can not book whole table!");
				}else{
					if(jQuery(this).hasClass("active")){
						jQuery(this).removeClass("active");
						thistb.find(".scwatbwsr_map_tables_table_seat").removeClass("active");
					}else{						
						jQuery(".scwatbwsr_map_tables_table").each(function(){
						jQuery(this).find(".scwatbwsr_map_tables_table_seat.active").removeClass("active");
						jQuery(this).find(".scwatbwsr_map_tables_table_label.active").removeClass("active");
					});

						jQuery(this).addClass("active");
						thistb.find(".scwatbwsr_map_tables_table_seat").addClass("active");
						jQuery(".tbf-selected-table>input").val(getSeats());
					}
					sessSeat();
				}
			}
		});
	});

	function getSeats(){
		var seats = "";
		jQuery(".scwatbwsr_map_tables_table").each(function(){
			var tbname = jQuery(this).children(".scwatbwsr_map_tables_table_label").text().trim();
			jQuery(this).find(".scwatbwsr_map_tables_table_seat.active").each(function(){
				if(seats)
					seats += "@"+tbname+"."+jQuery(this).text().trim();
				else
					seats += tbname+"."+jQuery(this).text().trim();
			});
		});
		return seats;
	}

	function sessSeat(){
		var seats = getSeats();
		jQuery.ajax({
			type: "POST",
			url: url+"helper.php",
			data:{
				task: "sess_seats",
				seats: seats,
				proid: proid,
				posttype: posttype
			},
			beforeSend : function(data){
				jQuery(".scwatbwsr_map").css("opacity", "0.5");
			},
			success : function(data){
				jQuery(".scwatbwsr_map").css("opacity", "1");
				
				if(compulsory == "yes"){
					if(jQuery(".scwatbwsr_map_tables_table_seat.active").size() > 0)
						jQuery(".single_add_to_cart_button").prop("disabled", false);
					else
						jQuery(".single_add_to_cart_button").prop("disabled", true);
				}
				
				if(posttype == "events"){
					jQuery(".scwatbwsr_total_value").text(data);
				}
			}
		});
	}
	
	const element = document.getElementById('scwatbwsr_map_panzoom');
	const zoomInButton = document.getElementById('scwatbwsr_map_zoom-in');
	const zoomOutButton = document.getElementById('scwatbwsr_map_zoom-out');
	const resetButton = document.getElementById('scwatbwsr_map_zoom_reset');
	const panzoom = Panzoom(element, {
		 bounds: true,
		 zoomDoubleClickSpeed: 1,
		 excludeClass: "scwatbwsr_map_exclude"
	});
	
	const parent = element.parentElement
	parent.addEventListener('wheel', panzoom.zoomWithWheel);
	zoomInButton.addEventListener('click', panzoom.zoomIn);
	zoomOutButton.addEventListener('click', panzoom.zoomOut);
	resetButton.addEventListener('click', panzoom.reset);
	jQuery(".tbf-selected-table > input").prop('readOnly', true);
	jQuery(".tbf-date > input").prop('readOnly', true);

	const date = jQuery(".scwatbwsr_schedule_item").attr("data-date");
	jQuery(".tbf-date > input").val(date);

})(jQuery);