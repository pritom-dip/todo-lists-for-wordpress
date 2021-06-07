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
        if (get_option('tdlw_todo_lists')) {
            $all_todos = unserialize($todos);
        }
        ob_start();
        include TDLW_TEMPLATES_DIR . '/lists.php';
        $html = ob_get_clean();
        return $html;
    }
}
