<script type="text/javascript">
$(function(){
	
	/*--------------------------------------------------------------------------------------------------
	Generic Ajax based form submission and then load the Jquery Upload file form if applicable

		created 2017-04-19 11:22:04 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/

	$.showBusy = function(){
		window.setTimeout(function(){
			$('#btnsubmit').hide("fast");$('#btnbusy').show("fast");$('#btninfo').removeClass('btnok btnfailed').addClass('btnprocess').show("fast").text('Processing...').css("text-decoration", "blink");
		}, 1);
	}
	
	$.showInfo = function(sState, sMsg){
		window.setTimeout(function(){
			$('#btnsubmit').show("fast");$('#btnbusy').hide("fast");
			if (sState === '1'){$('#btninfo').removeClass('btnprocess btnfailed').addClass('btnok').html(sMsg)}
			else {$('#btninfo').removeClass('btnprocess btnok').addClass('btnfailed').html(sMsg)}
		}, 1);
	}
	
	$('#myform').submit(function(e){
		var sMode = 'update';
		var sAct = $(this).attr("action");
		e.preventDefault();
		$(".ckeditor").each(function(i, elm){
			var idcode = $(this).attr('id');
			if (idcode == 'desc')
			{
				CKEDITOR.instances.desc.updateElement();
			}
			if (idcode == 'body')
			{
				CKEDITOR.instances.body.updateElement();
			}
		});
		$.ajax({
			url: sAct, 
			type: "POST",
			dataType: "html", 
			data: $('#myform').serialize(),
			beforeSend: function(){$.showBusy()}, 
			success: function(uReturn){
				//var oRet = JSON.parse(uReturn);
				var oRet = jQuery.parseJSON(uReturn);
				if(oRet.state === '1'){
					$('#id').val(oRet.id);
					// Hide all error elements inside the form
					$(':input', '#myform').each(function(){
						sElm = $(this).attr("id"); sElmErr = '#' + sElm + 'err';
						$(sElmErr).hide('slow'); $(sElmErr).removeClass("red");
					});
				}else{
					// Show each error on its predefined place
					$(':input', '#myform').each(function(){
						sElm = $(this).attr("id"); sElmErr = '#' + sElm + 'err';
						if ($(sElmErr).length) {
							// Use [property] to avoid using eval()
							if (oRet[sElm] !== undefined) {
								$(sElmErr).html(oRet[sElm]).show('slow'); $(sElmErr).addClass("red");
							} else {
								$(sElmErr).removeClass("red"); $(sElmErr).hide('slow');
							}
						}
					});
				}
				$.showInfo(oRet.state, oRet.state_msg);

				// ( (oRet['isJfu'] !== undefined) && (oRet['isJfu'] === '1') )
				if ((oRet.state === '1') && (oRet.mode === 'insert'))
				{
					if ( (oRet.isJfu !== null) && (oRet.isJfu === '1') )
					{
						$.ajax({
							url: oRet.jfu_view_uri, 
							type: "POST",
							dataType: "html", 
							success: function(uReturn){
								$("#divjfuview").html(uReturn);
								}
						});
					}
					if ($('#divdocadd').length)
					{
						$('#divdocadd').show("fast");
					}

				}

			} // if ajax succeeded
		});

		return false; // in multiple ajax request, to prevent ajax re-send html code to the browser
	});

});
</script>