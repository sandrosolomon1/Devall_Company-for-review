define([
        'ko',
        'uiComponent',
        'jquery'
    ],
    function(ko, Component, $) {
        'use strict';
        return Component.extend({
            country: ko.observable(''),
            street_number: ko.observable(''),
            street: ko.observable(''),
            size: ko.observable(''),

            initialize: function(config) {
                this._super();
                this.country(config.country);
                this.street(config.street);
                this.street_number(config.street_number);
                this.size(config.size);

                $('#company').on('change', function() {
                    ourAsyncFunction($(this).val());
                })

                async function ourAsyncFunction(id) {
                    $.ajax({
                        url: config.rest_api_url,
                        contentType: "application/json",
                        dataType: 'json',
                        success: function(res){
                            console.log(res);
                            setCompanyDetails(res[id]);
                        }
                    })
                }

                function setCompanyDetails(data) {
                    this.country(data.country);
                    this.street(data.street);
                    this.streetNumber(data.streetNumber);
                    this.size(data.size);
                }
            }
        });
    }
);
