require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function(
        $,
        modal
    ) {
        let form = $('#price-request-form');
        form.mage('validation', {});
        let options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            buttons: [{
                text: $.mage.__('Send'),
                class: '',
                click: function () {
                    if(form.validation('isValid')){
                        $.ajax({
                            url: form.attr('action'),
                            data: form.serialize(),
                            type: 'POST',
                            success: function() {
                                form[0].reset();
                                $('#price-request-popup-form').modal('closeModal');
                            }
                        });
                    }
                }
            }]
        };

        let popup = modal(options, $('#price-request-popup-form'));
        $("#price-request-button").on('click',function(){
            $("#price-request-popup-form").modal("openModal");
        });
    }
);
