jQuery(document).ready(function ($) {
    class SecureShell {

        constructor() {
            this.connections = $('#connections');
            this.isConnected = $('#is_connected');
            this.loading = $('#connection_loading');

            this.setDropdown();

            this.addListeners();
        }

        setDropdown() {
            let connection = this.getUrlParam('connect');

            this.isConnected.toggle(connection !== null);
            // this.loading.toggle(connection !== null);

            this.connections.children().each(function (){
                if ($(this).text() === connection) {
                    $(this).prop("selected", true);
                }
            });
        }

        getUrlParam(paramName) {
            let urlParams= new URLSearchParams(window.location.search);

            return  urlParams.get(paramName);
        }

        addListeners() {
            let self = this;

            this.connections.on('change', function () {
                let page = document.location.href.replace(document.location.search, '');
                let selected = $('#connections').find('option:selected').text();
                let query = (self.connections.val() !== '0') ? '?connect=' + selected : '';
                self.loading.show();
                self.isConnected.hide();

                window.location = page + query
            })
        }
    }

    new SecureShell();
});
