<?php

namespace Pritom\TodoListsForWordPress\Admin;

class Admin
{
	/**
	 * The single instance of the class.
	 *
	 * @var Admin
	 * @since 1.0.0
	 */
	protected static $init = null;

	/**
	 * Frontend Instance.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Admin - Main instance.
	 */
	public static function init()
	{
		if (is_null(self::$init)) {
			self::$init = new self();
			self::$init->setup();
		}

		return self::$init;
	}

	/**
	 * Initialize all Admin related stuff
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function setup()
	{
		$this->includes();
		$this->init_hooks();
		$this->instance();
	}

	/**
	 * Includes all files related to admin
	 */
	public function includes()
	{
		require_once dirname(__FILE__) . '/class-widget.php';
	}

	private function init_hooks()
	{
		add_action('admin_init', array($this, 'buffer'), 1);
		add_action('init', array($this, 'includes'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
	}


	/**
	 * Fire off all the instances
	 *
	 * @since 1.0.0
	 */
	protected function instance()
	{
		new Widget();
	}

	/**
	 * Output buffering allows admin screens to make redirects later on.
	 *
	 * @since 1.0.0
	 */
	public function buffer()
	{
		ob_start();
	}


	public function enqueue_scripts($hook)
	{
		global $post;

		wp_enqueue_media();

		wp_register_style('todo-lists-for-wordpress', TDLW_ASSETS_URL . "/css/admin.css", [], TDLW_VERSION);
		wp_register_script('todo-lists-for-wordpress', TDLW_ASSETS_URL . "/js/admin/admin.js", ['jquery', 'wp-util'], TDLW_VERSION, true);
		wp_localize_script('todo-lists-for-wordpress', 'tdlw', ['ajaxurl' => admin_url('admin-ajax.php'), 'nonce' => 'todo-lists-for-wordpress']);
		wp_enqueue_style('todo-lists-for-wordpress');
		wp_enqueue_script('todo-lists-for-wordpress');

		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wp-color-picker');
	}
}

Admin::init();
