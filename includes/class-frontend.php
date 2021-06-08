<?php

namespace pritom\TodoListsForWordPress;

class Frontend
{
	/**
	 * The single instance of the class.
	 *
	 * @var Frontend
	 * @since 1.0.0
	 */
	protected static $init = null;

	/**
	 * Frontend Instance.
	 *
	 * @since 1.0.0
	 * @static
	 * @return Frontend - Main instance.
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
	 * Initialize all frontend related stuff
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
	 * Includes all frontend related files
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function includes()
	{
		require_once dirname(__FILE__) . '/class-shortcodes.php';
		require_once dirname(__FILE__) . '/class-form-ajax.php';
	}

	/**
	 * Register all frontend related hooks
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function init_hooks()
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
	}

	/**
	 * Fire off all the instances
	 *
	 * @since 1.0.0
	 */
	protected function instance()
	{
		new Shortcode();
		new FormAjax();
	}

	/**
	 * Loads all frontend scripts/styles
	 *
	 * @param $hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts($hook)
	{
		wp_enqueue_script('jquery');
		wp_register_style('todo-lists-for-wordpress', TDLW_ASSETS_URL . "/css/frontend.css", TDLW_VERSION);
		wp_register_script('todo-lists-for-wordpress', TDLW_ASSETS_URL . "/js/frontend/frontend.js", ['jquery', 'wp-util'], TDLW_VERSION, true);
		wp_enqueue_style('todo-lists-for-wordpress');
		wp_enqueue_script('todo-lists-for-wordpress');

		wp_localize_script(
			'todo-lists-for-wordpress',
			'tdlw',
			[
				'ajaxurl'       			=> admin_url('admin-ajax.php'),
				'nonce'         			=> wp_create_nonce('todo-lists-for-wordpress')
			]
		);
	}
}

Frontend::init();
