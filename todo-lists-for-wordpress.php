<?php

/**
 * Plugin Name: Todo lists for WordPress
 * Plugin URI:  
 * Description: A todo lists for users
 * Version:     1.0.0
 * Author:      Pritom Chowdhury Dip
 * Author URI:  http://pritom-dip.web.app/
 * License:     GPLv2+
 * Text Domain: todo-lists-for-wordpress
 * Domain Path: /i18n/languages/
 */

/**
 * Copyright (c) 2021 Pritom Chowdhury Dip 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

// don't call the file directly

if (!defined('ABSPATH')) exit;
/**
 * Main initiation class
 *
 * @since 1.0.0
 */

/**
 * Main Capopuptrigger Class.
 *
 * @class Capopuptrigger
 */
final class TodoListsForWordPress
{
    /**
     * To do Lists for WordPress version.
     *
     * @var string
     */
    public $version = '2.1.0';

    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '5.6.0';

    /**
     * The single instance of the class.
     *
     * @var TodoListsForWordPress
     * @since 1.0.0
     */
    protected static $instance = null;


    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();

    /**
     * Main TodoList Instance.
     *
     * Ensures only one instance of TodoListsForWordPress is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @return TodoListsForWordPress - Main instance.
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
            self::$instance->setup();
        }

        return self::$instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'todo-lists-for-wordpress'), '1.0.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'todo-lists-for-wordpress'), '2.1');
    }

    /**
     * Magic getter to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __get($prop)
    {
        if (array_key_exists($prop, $this->container)) {
            return $this->container[$prop];
        }

        return $this->{$prop};
    }

    /**
     * Magic isset to bypass referencing plugin.
     *
     * @param $prop
     *
     * @return mixed
     */
    public function __isset($prop)
    {
        return isset($this->{$prop}) || isset($this->container[$prop]);
    }

    /**
     * EverProjects Constructor.
     */
    public function setup()
    {
        $this->check_environment();
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
        $this->plugin_init();
        do_action('todo_lists_for_wordpress_loaded');
    }

    /**
     * Ensure theme and server variable compatibility
     */
    public function check_environment()
    {
        if (version_compare(PHP_VERSION, $this->min_php, '<=')) {
            deactivate_plugins(plugin_basename(__FILE__));

            wp_die("Unsupported PHP version Min required PHP Version:{$this->min_php}");
        }
    }

    /**
     * Define EverProjects Constants.
     *
     * @since 1.0.0
     * @return void
     */
    private function define_constants()
    {
        //$upload_dir = wp_upload_dir( null, false );
        define('TDLW_VERSION', $this->version);
        define('TDLW_FILE', __FILE__);
        define('TDLW_PATH', dirname(TDLW_FILE));
        define('TDLW_INCLUDES', TDLW_PATH . '/includes');
        define('TDLW_URL', plugins_url('', TDLW_FILE));
        define('TDLW_ASSETS_URL', TDLW_URL . '/assets');
        define('TDLW_TEMPLATES_DIR', TDLW_PATH . '/templates');
    }


    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     *
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined('DOING_AJAX');
            case 'cron':
                return defined('DOING_CRON');
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON') && !defined('REST_REQUEST');
        }
    }


    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {
        //core includes
        include_once TDLW_INCLUDES . '/core-functions.php';
        require_once plugin_dir_path(__FILE__) . "widgets/class-todoWidget.php";

        //admin includes
        if ($this->is_request('admin')) {
            include_once TDLW_INCLUDES . '/admin/class-admin.php';
        }

        //frontend includes
        if ($this->is_request('frontend')) {
            include_once TDLW_INCLUDES . '/class-frontend.php';
        }
    }

    /**
     * Hook into actions and filters.
     *
     * @since 2.3
     */
    private function init_hooks()
    {
        // Localize our plugin
        add_action('init', array($this, 'localization_setup'));
        add_action('widgets_init', array($this, 'register_all_widgets'));
    }

    public function register_all_widgets()
    {
        register_widget('TodoWidget');
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function localization_setup()
    {
        load_plugin_textdomain('todo-lists-for-wordpress', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Plugin action links
     *
     * @param  array $links
     *
     * @return array
     */
    public function plugin_action_links($links)
    {
        //$links[] = '<a href="' . admin_url( 'admin.php?page=' ) . '">' . __( 'Settings', '' ) . '</a>';
        return $links;
    }

    public function plugin_init()
    { }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', TDLW_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(TDLW_FILE));
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path()
    {
        return TDLW_TEMPLATES_DIR;
    }
}

function todo_list_for_wordPress()
{
    return TodoListsForWordPress::instance();
}

//fire off the plugin
todo_list_for_wordPress();
