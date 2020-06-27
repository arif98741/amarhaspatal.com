"use strict";
jQuery(document).ready(function (e) {

	jQuery(".open-map").on("click",function(){
		var $this	= jQuery(this);
		$this.parents('figure').find(".overlay-map").slideToggle("slow");
		jQuery(this, ".see-map").toggleClass("active");
	});
	jQuery("#download-btn").on("click",function(){
		var _this	= jQuery(this);
		var _date	= jQuery('#do-date').val();
		var _year	= jQuery('#do-year').val();
		var _month	= jQuery('#do-month').val();
		var loder_html	= '<div class="docdirect-site-wrap"><div class="docdirect-loader"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div>';
		jQuery('body').append(loder_html);
		jQuery.ajax({
			type: "POST",
			url: localize_vars.ajaxurl,
			data: 'year='+_year+'&month='+_month+'&date='+_date+'&action=docdirect_download_pdf',
			dataType: "json",
			success: function (response) {
				jQuery('body').find('.docdirect-site-wrap').remove();
				if (response.type == 'success') {
					//window.location.href=response.url;
					fetch(response.url)
					  .then(resp => resp.blob())
					  .then(blob => {
						const url = window.URL.createObjectURL(blob);
						const a = document.createElement('a');
						a.style.display = 'none';
						a.href = url;
						// the filename you want
						a.download = response.file+'.pdf';
						document.body.appendChild(a);
						a.click();
						window.URL.revokeObjectURL(url);
					  })
					  .catch(() => alert('some issue.'));
				} else {
					
				}
			}
		});
	});
});

/*
 * @get absolute path
 * @return{}
*/
function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}