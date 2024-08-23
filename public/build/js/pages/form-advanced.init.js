!function ($) {
    "use strict";

    var AdvancedForm = function () { };

    AdvancedForm.prototype.init = function () {

        // Select2
        $(".select2").select2();

        $(".select2-limiting").select2({
            maximumSelectionLength: 2
        });


        $(".select2-search-disable").select2({
            minimumResultsForSearch: Infinity
        });
    },
    //init
    $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),

    //Datepicker
    function ($) {
        "use strict";
        $.AdvancedForm.init();
    }(window.jQuery);

    