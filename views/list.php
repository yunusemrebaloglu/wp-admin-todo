<?php
$paged = isset($_GET['paged']) ? absint($_GET['paged']) : 1;

$args = array(
  'post_type'      => 'wp-admin-todo',
  'meta_key'       => 'priority_todo',
  'orderby'        => 'meta_value_num',
  'order'          => 'DESC',
  'paged'          => $paged
);

$todos = new WP_Query($args);
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
        <tr data-todo-id="<?= esc_attr(get_the_ID()) ?>" data-priority="<?= esc_attr(get_post_meta(get_the_ID(), 'priority_todo', true)) ?>">
          <td><?= esc_html(get_the_title()) ?></td>
          <td><?= esc_html(get_the_content()) ?></td>
          <td>
            <?php
            $url_todo = unserialize(get_post_meta(get_the_ID(), 'url_todo', true));
            if (is_array($url_todo) && !empty($url_todo)) {
              $url = esc_url($url_todo[0]);
              echo '<a href="' . $url . '">' . $url . '</a>';
            }
            ?>
          </td>
          <td><?= esc_html(get_post_meta(get_the_ID(), 'priority_todo', true)) ?></td>
          <td>
            <form id="deleteTodo<?= esc_attr(get_the_ID()) ?>">
              <?php wp_nonce_field('delete_form_todo_action', 'delete_form_todo_nonce_field'); ?>
              <input type="hidden" name="todo_id" id="todo_id" value="<?= esc_attr(get_the_ID()) ?>">
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
  'base'      => esc_url(add_query_arg('paged', '%#%')),
  'format'    => '',
  'total'     => $todos->max_num_pages,
  'current'   => $paged,
  'show_all'  => false,
  'end_size'  => 1,
  'mid_size'  => 2,
  'prev_next' => true,
  'prev_text' => '&laquo; Previous',
  'next_text' => 'Next &raquo;',
  'type'      => 'plain',
);
echo paginate_links($pagination_args);
?>