/**
 * Todo List for WordPress Admin
 * 
 *
 * Copyright (c) 2021 Pritom Chowdhury Dip
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */

window.Project = (function (window, document, $, undefined) {
    'use strict';

    var app = {
        initialize: function () {
            console.log('admin working');
        }
    };

    $(document).ready(app.initialize);

    return app;
})(window, document, jQuery);