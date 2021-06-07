<?php

namespace pritom\TodoListsForWordPress;

class FormAjax
{
    public function __construct()
    {
        add_action('wp_ajax_tdlw_add_new_todo', array($this, 'add_new_todo'));
        add_action('wp_ajax_nopriv_tdlw_add_new_todo', array($this, 'add_new_todo'));

        add_action('wp_ajax_tdlw_update_todo', array($this, 'tdlw_update_todo'));
        add_action('wp_ajax_nopriv_tdlw_update_todo', array($this, 'tdlw_update_todo'));
    }

    public function add_new_todo()
    {
        $all_todos   = [];
        $todos       = get_option('tdlw_todo_lists', true);

        if (get_option('tdlw_todo_lists')) {
            $all_todos = unserialize($todos);
        }
        $new_todo = [
            'name' => $_POST['todo'],
            'completed' => 0
        ];
        array_push($all_todos, $new_todo);
        update_option('tdlw_todo_lists', serialize($all_todos));

        ob_start();
        include TDLW_TEMPLATES_DIR . '/single_todo.php';
        $html = ob_get_clean();
        ob_get_clean();

        wp_send_json_success([
            'success' => true,
            'html' => $html
        ]);
    }

    public function tdlw_update_todo()
    {
        $todos       = get_option('tdlw_todo_lists', true);
        if (get_option('tdlw_todo_lists')) {
            $all_todos = unserialize($todos);
        }

        if (!empty($all_todos)) {
            foreach ($all_todos as $key => $value) {
                if ($key == $_POST['key']) {
                    $all_todos[$key]['completed'] = !$all_todos[$key]['completed'];
                }
            }
        }
        update_option("tdlw_todo_lists", serialize($all_todos));

        wp_send_json_success([
            'success' => true,
        ]);
    }
}
