define([
        'uiComponent',
        'ko',
        'jquery'
    ],
    function(Component, ko, $) {
        'use strict';
        return Component.extend({
            country: ko.observable(''),
            street_number: ko.observable(''),
            street: ko.observable(''),
            size: ko.observable(''),

            initialize: function(config) {
                this._super();
                this.country = ko.observable(config.country);
                this.street = ko.observable(config.street);
                this.street_number = ko.observable(config.street_number);
                this.size = ko.observable(config.size);
                var root = this;

                ourAsyncFunction($('#company').val());

                $('#company').on('change', function() {
                    ourAsyncFunction($(this).val());
                })

                async function ourAsyncFunction(id) {
                    $.ajax({
                        url: `${config.rest_api_url}/${id}`,
                        success: function(res){
                            setCompanyDetails(res);
                        }
                    })
                }

                function setCompanyDetails(data) {
                    root.country(data[1]);
                    root.street(data[3]);
                    root.street_number(data[4]);
                    root.size(data[5]);
                }
            }
        });
    }
);
