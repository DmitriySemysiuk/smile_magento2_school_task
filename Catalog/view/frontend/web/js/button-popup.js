define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function(
        $,
        modal
    ) {
        return function (config, element) {
            let container = $("#price-request-popup-form");
            let form = $('#price-request-form');

            form.mage('validation', {});

            let options = {
                type: 'popup',
                responsive: true,
                innerScroll: true,
                buttons: [
                    {
                        text: $.mage.__('Send'),
                        class: 'action-primary action-accept',
                        click: function () {
                            if (form.validation('isValid')) {
                                $.ajax({
                                    url: form.attr('action'),
                                    data: form.serialize(),
                                    type: 'POST',
                                    success: function () {
                                        form[0].reset();
                                        this.closeModal();
                                    }
                                });
                            }
                        }
                    }
                    ]
            };

            let popup = modal(options, container);
            $(element).on('click', function () {
                container.modal("openModal");
            });

            $(".action-close").on("click", function(){
                form[0].reset();
            });
        }
    }
);
