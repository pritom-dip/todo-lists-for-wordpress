<?php

class TodoWidget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'TodoWidget',
            __('Todo list', 'todo-lists-for-wordpress'),
            array('description' => __('Todo List Widget', 'todo-lists-for-wordpress'))
        );
    }
}
