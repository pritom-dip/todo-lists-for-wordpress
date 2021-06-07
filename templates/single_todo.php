<?php
if (!empty($all_todos)) {
    foreach ($all_todos as $key => $single_todo) {
        ?>
        <li class="<?php echo $single_todo['completed'] == 1 ? 'line' : ''; ?>">
            <input <?php echo  $single_todo['completed'] == 1 ? 'checked' : ''; ?> id="singleTodo-<?php echo $key; ?>" class="single_todo_input" type="checkbox" value=<?php echo $key; ?> />
            <span><?php echo esc_attr($single_todo['name']); ?></span>
        </li>
    <?php
    }
}
?>