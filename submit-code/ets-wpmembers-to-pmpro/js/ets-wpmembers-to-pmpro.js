
(function ($) {
	'use strict';


    // console.log(ets_wpmembers_to_pmpro_js_params);

    if ( ets_wpmembers_to_pmpro_js_params.is_admin ) {

        $('#ets-download-csv').on('click' , function(){

			$.ajax({
				url: ets_wpmembers_to_pmpro_js_params.admin_ajax,
				type: "POST",
				context: this,
				data: { 'action': 'ets_wpmembers_to_pmpro_download_csv', 'ets_wpmembers_to_pmpro_nonce': ets_wpmembers_to_pmpro_js_params.ets_wpmembers_to_pmpro_nonce },
				beforeSend: function () {  
                    $(this).attr("disabled", true);   
					$(this).siblings('span.ets-wpmembers-to-pmpro-spinner').addClass("active");
                    $('p.ets-csv-to-download').html('');
                                       
				},
				success: function (data) { 
                    $('p.ets-csv-to-download').html(data);
                   //console.log(data);
				},
				error: function (response, textStatus, errorThrown ) {
					console.log( textStatus + " :  " + response.status + " : " + errorThrown );
				},
				complete: function () {
                    $(this).attr("disabled", false);
					$(this).siblings('span.ets-wpmembers-to-pmpro-spinner').removeClass("active");
				}
			});
        });

        $('#ets-download-restrict').on('click' , function(){

			$.ajax({
				url: ets_wpmembers_to_pmpro_js_params.admin_ajax,
				type: "POST",
				context: this,
				data: { 'action': 'ets_wpmembers_to_pmpro_update_restrict_pmpro', 'ets_wpmembers_to_pmpro_nonce': ets_wpmembers_to_pmpro_js_params.ets_wpmembers_to_pmpro_nonce },
				beforeSend: function () {  
                    $(this).attr("disabled", true);   
					$(this).siblings('span.ets-wpmembers-to-pmpro-spinner').addClass("active");
                    $('p.ets-csv-to-restrict').html('');
                                       
				},
				success: function (data) { 
                    $('p.ets-csv-to-restrict').html(data);
                   //console.log(data);
				},
				error: function (response, textStatus, errorThrown ) {
					console.log( textStatus + " :  " + response.status + " : " + errorThrown );
				},
				complete: function () {
                    $(this).attr("disabled", false);
					$(this).siblings('span.ets-wpmembers-to-pmpro-spinner').removeClass("active");
				}
			});
        });		
    }
})(jQuery);