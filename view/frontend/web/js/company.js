define(
    [
        'uiComponent',
        'ko',
        'jquery'
    ],
    function (Component, ko, $) {
        'use strict';
        return Component.extend(
            {
                country: ko.observable(''),
                streetNumber: ko.observable(''),
                street: ko.observable(''),
                size: ko.observable(''),

                initialize: function (config) {
                    this._super();
                    this.country = ko.observable(config.country);
                    this.street = ko.observable(config.street);
                    this.streetNumber = ko.observable(config.streetNumber);
                    this.size = ko.observable(config.size);
                    var root = this;

                    ourAsyncFunction($('#company').val());

                    $('#company').on(
                        'change',
                        function () {
                            ourAsyncFunction($(this).val());
                        }
                    )

                    function ourAsyncFunction(id)
                    {
                        $.ajax(
                            {
                                url: `${config.restApiUrl}/${id}`,
                                success: function (res) {
                                    setCompanyDetails(res);
                                }
                            }
                        )
                    }

                    function setCompanyDetails(data)
                    {
                        root.country(data.country);
                        root.street(data.street);
                        root.streetNumber(data.number);
                        root.size(data.size);
                    }
                }
            }
        );
    }
);
