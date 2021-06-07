/**
 * Todo list for wordpress 
 *
 * Copyright (c) 2021 Pritom Chowdhury Dip
 * Licensed under the GPLv2+ license.
 */

/*jslint browser: true */
/*global jQuery:false */
/*global tdlw:false */

window.Project = (function (window, document, $, undefined) {
	'use strict';
	var app = {
		init: function () {
			$('#tdlw_submit_btn').on('click', app.addTodo);
			$(document).find("input[id^='singleTodo-']").live('click', app.updateTodo)
		},
		addTodo: function () {
			const todo = $("#tdlw_todo_field").val();
			const data = {
				'action': 'tdlw_add_new_todo',
				todo
			};

			wp.ajax.send('tdlw_add_new_todo', {
				data: data,
				dataType: 'json',
				success: function (res) {
					if (res.success) {
						$("#tdlw_todo_field").val('');
						$(".todo-wrapper").html('');
						$(".todo-wrapper").append(res.html);
					}
				},
				error: function (error) {
					console.log('error', error);
				}
			});
		},
		updateTodo: function () {
			const updateInput = $(this);
			const num = this.id.split('-')[1];
			const data = {
				'action': 'tdlw_update_todo',
				'key': num
			};
			wp.ajax.send('tdlw_update_todo', {
				data: data,
				dataType: 'json',
				success: function (res) {
					if (res.success) {
						updateInput.parent().toggleClass("line");
					}
				},
				error: function (error) {
					console.log('error', error);
				}
			});
		}
	};
	$(document).ready(app.init);

	return app;

})(window, document, jQuery);
