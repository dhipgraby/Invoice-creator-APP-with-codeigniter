<script>
    $('#card_info').on('submit', function() {
        $('#save_card').prop('disabled', true);
        var parameters = $('#card_info').serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>subscription/subscriptions/save_card",
            data: parameters,
            success: function(data) {
                var array = JSON.parse(data);
                switch (array.result) {
                    case 'success':
                        $("#resultados").html(array.msg);
                        $('#card_modal').modal('hide');
                        update_info(array.pm_id);
                        break;
                    case 'error':
                        $('#modal_res').html(array.msg);
                        break;
                }
                $('#save_card').prop('disabled', false);
                disable_alert();
            }
        });
    });

    function update_info(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>subscription/subscriptions/update_info/" + id,
            data: {},
            success: function(data) {
                $("#payment_info").html(data);
            }
        });
    }

    function cancel_subscription() {
        $('#cancel_plan').prop('disabled',true);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>subscription/update/cancel_subscription",
            data: {},
            success: function(data) {
                $('#cancel_plan').prop('disabled',false);
                $("#cancel_res").html(data);
            }
        });
    }
</script>