+function ($) { "use strict";

    var CreateCampaign = function() {

        this.create = function() {
            var newPopup = $('<a />')

            newPopup.popup({
                handler: 'onCreateCampaign',
                extraData: {}
            })
        }

    }

    $.createCampaign = new CreateCampaign;

}(window.jQuery);