<?php
$current_url = $_SERVER['REQUEST_URI'];


$todos = get_posts(array(
  'post_type' => 'admin-todo',
  'posts_per_page' => -1,
  'meta_query' => array(
    array(
      'key' => 'url_todo',
      'value' => home_url($current_url),
      'compare' => '=', // İsteğe bağlı: Eşitlik, büyüktür/küçüktür gibi diğer karşılaştırma operatörleri de kullanılabilir
    ),
  ),
  'meta_key' => 'priority_todo',
  'orderby' => 'meta_value_num',
  'order' => 'DESC',
));

?>
<div id="todoModal" class="modal">
  <div class="close_modal overlay_todo"></div>
  <div class="modal-content">
    <span class="todo-list-menu close">&times;</span>
    <h2 class="modal-title"> Todos</h2>
    <div class="todo container">

      <form class="form_todo" id="form_todo">
        <div class="">
          <label for="title_todo">Title</label>
          <input required type="text" class="input_todo" id="title_todo" name="title" placeholder="title">
        </div>
        <div class="">
          <label for="url_todo">Url</label>
          <input type="text" class="input_todo" id="url_todo" name="url" placeholder="Url">
        </div>
        <div class="">
          <label for="priority_todo">Priorty</label>
          <input type="range" class="input_todo" id="priority_todo" name="priority" placeholder="Priority">
        </div>
        <div class="">
          <label for="content_todo">Content</label>
          <textarea class="input_todo" id="content_todo" name="content" cols="30" rows="10"></textarea>
        </div>
        <div class="todo_button">
          <button class=" button">Save</button>
        </div>
      </form>
      <div class="content_todo">
        <table id="todoTable">
          <thead>
            <tr>
              <th>Title</th>
              <th>Content</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($todos as  $todo) : ?>
            <tr data-priority="<?= get_post_meta($todo->ID, 'priority_todo', 1) ?>">
              <td><?= $todo->post_title ?></td>
              <td><?= $todo->post_content ?></td>
              <td>
                <form id="deleteTodo<?= $todo->ID ?>">
                  <input type="hidden" name="todo_id" value="<?= $todo->ID ?>">
                  <button type="submit">

                    <span class="delete">&times;</span>
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>

          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>