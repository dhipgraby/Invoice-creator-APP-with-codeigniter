<script>
	var loadgif = '<img style="width:30px;" src="<?php echo base_url('images/load.gif') ?>">';
	var checkgif = '<img src="<?php echo base_url('images/check.gif') ?>" style="width:80px;">';

	function update_filter() {

		var filter = $('#filter').val();
		$('#filter2').val(filter);
	}

	function go_to(url) {

		window.location.href = '<?php echo base_url() ?>' + url;

	}


	function open_slapp(url) {
		window.open('https://slappinvoice.com/' + url, '_blank');
	}

	function go_slapp(url) {
		if (empty(url)) {
			url = "";
		}
		window.location.href = 'https://slappinvoice.com/' + url;
	}

	function alert_msg(content, type, attr = null) {
		if (attr != null) {
			attr = attr;
		} else {
			attr = '';
		}
		var str = '';
		str += '<div class="alert alert-' + type + '" ' + attr + ' role="alert"><button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close"> <i class="far fa-times-circle"></i> </button>' + content + ' </div>';
		return str;

	}

	function disable_alert() {
		setTimeout(function() {
			$('.alert').fadeOut();
		}, 4000);
	}
	//PDF 
	function open_pdf(id) {
		$('#pdf_view').html("<div id='preload_gif' align='center'><h3 class='light-c'>Generando archivo PDF..."+loadgif+"</h3></div>");
		$('#pdf_view').append('<embed id="div_pdf" src="<?php echo base_url() ?>pdf/' + id + '" class="hidden" width="100%" height="750vh">');
		setTimeout(function() {
			$('#preload_gif').addClass('hidden');
			$('#div_pdf').removeClass('hidden');
		}, 5000);

	}
	//PDF 
	function open_pdf_basic(id) {
		$('#pdf_view').html("<div id='preload_gif' align='center'><h3 class='light-c'>Generando archivo PDF..."+loadgif+"</h3></div>");
		$('#pdf_view').append('<embed id="div_pdf" src="<?php echo base_url() ?>pdf/basic/' + id + '" class="hidden" width="100%" height="750vh">');
		setTimeout(function() {
			$('#preload_gif').addClass('hidden');
			$('#div_pdf').removeClass('hidden');
		}, 5000);
		}

	function empty(str) {
		return (!str || 0 === str.length);
	}

	$('input').attr('autocomplete', 'off');

	$(function() {
		$('[data-toggle="tooltip"]').tooltip();
	})
</script>