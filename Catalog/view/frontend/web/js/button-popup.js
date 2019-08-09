require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function(
        $,
        modal
    ) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            buttons: [{
                text: $.mage.__('Send mail'),
                class: '',
                click: function () {
                    sendMail();
                    this.closeModal();
                }
            }]
        };

        var popup = modal(options, $('#price-request-popup-form'));
        $("#price-request-button").on('click',function(){
            $("#price-request-popup-form").modal("openModal");
        });

        function sendMail() {
            alert("qwer");
        }
    }
);
