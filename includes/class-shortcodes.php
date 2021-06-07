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
        $params = shortcode_atts(['option' => null], $attr);
        ob_start();
        include TDLW_TEMPLATES_DIR . '/lists.php';
        $html = ob_get_clean();
        return $html;
    }
}
