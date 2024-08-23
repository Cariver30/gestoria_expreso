/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form Advanced Js File
*/

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


        

       


        

    

        

        // Time Picker
        $('#timepicker').timepicker({
            icons: {
                up: 'mdi mdi-chevron-up',
                down: 'mdi mdi-chevron-down'
            },
            appendWidgetTo: "#timepicker-input-group1"
        });
        $('#timepicker2').timepicker({
            showMeridian: false,
            icons: {
                up: 'mdi mdi-chevron-up',
                down: 'mdi mdi-chevron-down'
            },
            appendWidgetTo: "#timepicker-input-group2"
        });
        $('#timepicker3').timepicker({
            minuteStep: 15,
            icons: {
                up: 'mdi mdi-chevron-up',
                down: 'mdi mdi-chevron-down'
            },
            appendWidgetTo: "#timepicker-input-group3"
        });


        //Bootstrap-TouchSpin
        var defaultOptions = {
        };

        // touchspin
        $('[data-toggle="touchspin"]').each(function (idx, obj) {
            var objOptions = $.extend({}, defaultOptions, $(obj).data());
            $(obj).TouchSpin(objOptions);
        });

        $("input[name='demo3_21']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });
        $("input[name='demo3_22']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        });

        $("input[name='demo_vertical']").TouchSpin({
            verticalbuttons: true
        });

        //Bootstrap-MaxLength
        $('input#defaultconfig').maxlength({
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        });

        $('input#thresholdconfig').maxlength({
            threshold: 20,
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        });

        $('input#moreoptions').maxlength({
            alwaysShow: true,
            warningClass: "badge bg-success",
            limitReachedClass: "badge bg-danger"
        });

        $('input#alloptions').maxlength({
            alwaysShow: true,
            warningClass: "badge bg-success",
            limitReachedClass: "badge bg-danger",
            separator: ' out of ',
            preText: 'You typed ',
            postText: ' chars available.',
            validate: true
        });

        $('textarea#textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
        });

        $('input#placement').maxlength({
            alwaysShow: true,
            placement: 'top-left',
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-warning"
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

$(function () {
    'use strict';

    var $date = $('.docs-date');
    var $container = $('.docs-datepicker-container');
    var $trigger = $('.docs-datepicker-trigger');
    var options = {
        show: function (e) {
            console.log(e.type, e.namespace);
        },
        hide: function (e) {
            console.log(e.type, e.namespace);
        },
        pick: function (e) {
            console.log(e.type, e.namespace, e.view);
        }
    };

    $date.on({
        'show.datepicker': function (e) {
            console.log(e.type, e.namespace);
        },
        'hide.datepicker': function (e) {
            console.log(e.type, e.namespace);
        },
        'pick.datepicker': function (e) {
            console.log(e.type, e.namespace, e.view);
        }
    }).datepicker(options);

    $('.docs-options, .docs-toggles').on('change', function (e) {
        var target = e.target;
        var $target = $(target);
        var name = $target.attr('name');
        var value = target.type === 'checkbox' ? target.checked : $target.val();
        var $optionContainer;

        switch (name) {
            case 'container':
                if (value) {
                    value = $container;
                    $container.show();
                } else {
                    $container.hide();
                }

                break;

            case 'trigger':
                if (value) {
                    value = $trigger;
                    $trigger.prop('disabled', false);
                } else {
                    $trigger.prop('disabled', true);
                }

                break;

            case 'inline':
                $optionContainer = $('input[name="container"]');

                if (!$optionContainer.prop('checked')) {
                    $optionContainer.click();
                }

                break;

            case 'language':
                $('input[name="format"]').val($.fn.datepicker.languages[value].format);
                break;
        }

        options[name] = value;
        $date.datepicker('reset').datepicker('destroy').datepicker(options);
    });

    $('.docs-actions').on('click', 'button', function (e) {
        var data = $(this).data();
        var args = data.arguments || [];
        var result;

        e.stopPropagation();

        if (data.method) {
            if (data.source) {
                $date.datepicker(data.method, $(data.source).val());
            } else {
                result = $date.datepicker(data.method, args[0], args[1], args[2]);

                if (result && data.target) {
                    $(data.target).val(result);
                }
            }
        }
    });

});