<?php

namespace Pritom\TodoListsForWordPress\Admin;

use Pritom\TodoListsForWordPress\Admin\Settings_API;

class Settings
{
	private $settings_api;

	function __construct()
	{
		$this->settings_api = new Settings_API();
		add_action('admin_init', array($this, 'admin_init'));
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	function admin_init()
	{
		//set the settings
		$this->settings_api->set_sections($this->get_settings_sections());
		$this->settings_api->set_fields($this->get_settings_fields());

		//initialize settings
		$this->settings_api->admin_init();
	}

	function get_settings_sections()
	{
		$sections = array(
			array(
				'id'    => 'tdlw_settings',
				'title' => __('Todo List Settings', 'todo-lists-for-wordpress')
			),
		);

		return apply_filters('tdlw_settings_sections', $sections);
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields()
	{

		$settings_fields = array(

			'tdlw_settings' => array(

				array(
					'name'    => 'add_todo_settings',
					'label'   => __('Add Todo Option', 'todo-lists-for-wordpress'),
					'type'    => 'checkbox',
					'default' => false,
					'checked' => true,
					'class'   => 'add_todo_class',
				),

			),
		);

		return apply_filters('tdlw_settings_fields', $settings_fields);
	}

	/**
	 * Add Portfolio Gallary settings sub menu to Portfolio admin menu
	 *
	 * @since 1.0.0
	 */

	function admin_menu()
	{
		add_menu_page(
			__('Todo Settings', 'todo-lists-for-wordpress'),
			'Todo List Settings',
			'manage_options',
			'tdlw_settings',
			array($this, 'settings_page'),
			'dashicons-admin-tools',
			6
		);
	}

	/**
	 * Menu page for Portfolio Gallery sub menu
	 *
	 * @since 1.0.0
	 */

	function settings_page()
	{

		echo '<div class="wrap">';
		$this->settings_api->show_settings();

		$options = get_option('tdlw_settings');
		if ($options != '') {
			echo '<p>Place the shortcode and you will get the form.</p>';
			echo '<h1 style="margin-top: 0px;">do_shortcode[toiree_restaurant_reservation_api]</h1>';
		}

		echo '</div>';
	}
}
