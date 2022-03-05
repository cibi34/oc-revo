(function($) {
"use strict";
	var url = jQuery(".scwatbwsr_url").val();
	var proid = jQuery(".product_id").val();
	var roomwidth = jQuery(".scw_roomwidth").val();
	var roomheight = jQuery(".scw_roomheight").val();
	var posttype = jQuery(".scw_posttype").val();

	
	jQuery(".tbf").before(jQuery(".scwatbwsr_content").show());
	jQuery(".scwatbwsr_content").after(jQuery("form.cart"));

	
	jQuery(".scwatbwsr_map_tables_table").each(function(){
		var thistb = jQuery(this);

		thistb.children(".scwatbwsr_map_tables_table_label").on("click", function(){
			if(jQuery(this).hasClass("active")){
				jQuery(this).removeClass("active");
				jQuery(".tbf-selected-table>input").val("");

			}else{
				jQuery(".scwatbwsr_map_tables_table").each(function(){
					jQuery(this).find(".scwatbwsr_map_tables_table_label.active").removeClass("active");
				});

				jQuery(this).addClass("active");
				const vlabel = jQuery(this).text().trim();
				jQuery(".tbf-selected-table>input").val(vlabel);

			}
			getPrice(this);
			getMaxPeople(this);

		});
	});

	function getPrice(label){
		var seat = jQuery(label).text().trim();
		jQuery.ajax({
			type: "POST",
			url: url+"helper.php",
			data:{
				task: "sess_seats",
				seat: seat,
				proid: proid,
				posttype: posttype
			},
			beforeSend : function(data){
				jQuery(".scwatbwsr_map").css("opacity", "0.5");
			},
			success : function(data){
				jQuery(".scwatbwsr_map").css("opacity", "1");

				if(posttype == "events"){
					const sum = data + "€";
					jQuery(".tbf-mindestverzehr>input").val(sum);
				}
			}
		});
	}

	function getMaxPeople(label){
		var seat = jQuery(label).text().trim();
		jQuery.ajax({
			type: "POST",
			url: url+"helper.php",
			data:{
				task: "get_max_ppl",
				seat: seat,
				proid: proid,
				posttype: posttype
			},
			success : function(data){

				if(posttype == "events"){
					jQuery(".tbf-number-ppl select option").each(function(){
						$(this).show();
						if(parseInt(jQuery(this).val()) > parseInt(data)){
							$(this).hide();
						}
					});
					jQuery(".tbf-number-ppl label").text("Anzahl Gäste (max. " + data + ")" );
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