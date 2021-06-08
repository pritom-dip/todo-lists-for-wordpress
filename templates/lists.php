<div>
    <ul class="todo-wrapper">
        <?php include TDLW_TEMPLATES_DIR . '/single_todo.php'; ?>
    </ul>

    <?php if ($option == "on") { ?>
        <div style="display:flex; margin-top: 10px;">
            <input type="text" class="tdlw_submit_button" id="tdlw_todo_field" name="todo" />
            <button id="tdlw_submit_btn" type="submit">Add</button>
        </div>
    <?php } ?>

</div>