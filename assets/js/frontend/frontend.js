/**
 * Todo list for wordpress 
 *
 * Copyright (c) 2021 Pritom Chowdhury Dip
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */

window.Project = (function (window, document, $, undefined) {
	'use strict';
	var app = {
		init: function () {

			console.log('frontend working');
		}
	};
	$(document).ready(app.init);

	return app;

})(window, document, jQuery);
