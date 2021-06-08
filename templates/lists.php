<?php if (is_user_logged_in()) { ?>
    <div>
        <ul class="todo-wrapper">
            <?php include TDLW_TEMPLATES_DIR . '/single_todo.php'; ?>
        </ul>

        <?php if ($option == "on") { ?>
            <div style="display:flex; margin-top: 10px;">
                <input type="text" class="tdlw_submit_button" id="tdlw_todo_field" name="todo" />
                <button id="tdlw_submit_btn" type="submit"><?php _e("Add", "todo-lists-for-wordpress") ?></button>
            </div>
        <?php } ?>

    </div>
<?php } else { ?>
    <h3><?php _e('Please log in to set the todo.', 'todo-lists-for-wordpress') ?></h3>
<?php } ?>