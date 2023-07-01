<?php
$paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

$todos = new WP_Query(array(
  'post_type' => 'admin-todo',
  'meta_key' => 'priority_todo',
  'orderby' => 'meta_value_num',
  'order' => 'DESC',
  'paged' => $paged
));
?>
<h2>Todos</h2>
<form class="search">
  <input type="text" placeholder="Search">
  <button type="submit" class="button">Search</button>
</form>
<div class="list_todo">

  <table id="todoTable" class="list_todo">
    <thead>
      <tr>
        <th>Title</th>
        <th>Content</th>
        <th>Link</th>
        <th>Priority</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php while ($todos->have_posts()) : $todos->the_post(); ?>
      <tr data-todo-id="<?= get_the_ID() ?>" data-priority="<?= get_post_meta(get_the_ID(), 'priority_todo', true) ?>">
        <td><?= get_the_title() ?></td>
        <td><?= get_the_content() ?></td>
        <td>
          <a href="<?= get_post_meta(get_the_ID(), 'url_todo', true) ?>">
            <?= get_post_meta(get_the_ID(), 'url_todo', true) ?>
          </a>
        </td>
        <td><?= get_post_meta(get_the_ID(), 'priority_todo', true) ?></td>
        <td>
          <form id="deleteTodo<?= get_the_ID() ?>">
            <input type="hidden" name="todo_id" value="<?= get_the_ID() ?>">
            <button type="submit">
              <span class="delete">&times;</span>
            </button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>

    </tbody>
  </table>
</div>

<!-- Pagination -->
<?php
$pagination_args = array(
  'base' => add_query_arg('paged', '%#%'),
  'format' => '',
  'total' => $todos->max_num_pages,
  'current' => $paged,
  'show_all' => false,
  'end_size' => 1,
  'mid_size' => 2,
  'prev_next' => true,
  'prev_text' => '&laquo; Previous',
  'next_text' => 'Next &raquo;',
  'type' => 'plain',
);
echo paginate_links($pagination_args);
?>