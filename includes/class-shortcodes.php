<?php

namespace pritom\TodoListsForWordPress;

class Shortcode
{
    /**
     * Shortcode constructor.
     */
    public function __construct()
    {
        add_shortcode('todo_lists', array($this, 'todo_list_shortcode'));
    }

    public function todo_list_shortcode($attr)
    {
        $params     = shortcode_atts(['option' => null], $attr);
        $todos      = get_option('tdlw_todo_lists', true);
        $all_todos  = [];

        $user_id = get_current_user_id();
        $user_meta = get_user_meta($user_id, 'tdlw_todo_lists', true);
        if ($user_meta) {
            $all_todos = unserialize($user_meta);
        }

        $option = "on";
        if (get_option('tdlw_settings')) {
            $settings = get_option("tdlw_settings", true);
            if (isset($settings['add_todo_settings'])) {
                $option = $settings['add_todo_settings'];
            }
        }

        ob_start();
        include TDLW_TEMPLATES_DIR . '/lists.php';
        $html = ob_get_clean();
        return $html;
    }
}
