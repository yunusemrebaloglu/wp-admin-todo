<?php

namespace WPATDPlugin;

// Prevent direct access
defined('ABSPATH') || die('No script kiddies please!');

class Todo
{

  public function __construct()
  {
    // Add actions
    add_action('init', [$this, 'create_admin_todo_post_type']);
    add_action('admin_menu', [$this, 'add_plugin_menu']);
    add_action('admin_bar_menu', [$this, 'add_plugin_menu_bar'], 999);
    add_action('admin_footer', [$this, 'my_plugin_load_template']);
    add_action('wp_ajax_submit_form', [$this, 'wp_ajax_submit_form']);
    add_action('wp_ajax_nopriv_submit_form', [$this, 'wp_ajax_submit_form']);
    add_action('wp_ajax_submit_form_delete', [$this, 'wp_ajax_submit_form_delete']);
    add_action('wp_ajax_nopriv_submit_form_delete', [$this, 'wp_ajax_submit_form_delete']);
  }

  public function add_plugin_menu()
  {
    // Add the Todo List menu item
    add_menu_page(
      'WP Todo List',
      'WP Todo List',
      'manage_options',
      'wp-todo-list',
      [$this, 'render_todo_list_page'],
      'dashicons-list-view',
      20
    );
  }

  public function render_todo_list_page()
  {
    // Render the Todo List page
    include(PLUGIN_DIR_ATD . 'views/list.php');
  }

  public function add_plugin_menu_bar($wp_admin_bar)
  {
    // Add the Todo List menu item to the admin bar
    if (isset($_GET['page']) && sanitize_title($_GET['page']) == 'todo-list') return;
    $wp_admin_bar->add_menu(
      array(
        'id'    => 'wp-todo-list',
        'title' => 'WP Todo List',
        'meta'  => array(
          'class' => 'wp-todo-list-menu',
          'title' => 'WP Todo List',
        ),
      )
    );
  }

  public function my_plugin_load_template()
  {
    // Load the modal template
    include(PLUGIN_DIR_ATD . 'views/modal.php');
  }

  public function create_admin_todo_post_type()
  {
    // Create the wp-admin-todo post type
    $args = array(
      'public' => false, // Indicates the post type is not publicly accessible
      'exclude_from_search' => true, // Exclude from search results
      'show_ui' => false, // Do not display in the admin UI
      'show_in_menu' => false, // Do not display in admin menu
      'supports' => array('title', 'content'), // Support title and content
    );
    register_post_type('wp-admin-todo', $args);
  }

  public function wp_ajax_submit_form()
  {
    if (current_user_can('administrator') && wp_verify_nonce($_POST['form_todo_nonce_field'], 'form_todo_action')) {

      $post_data = array(
        'post_title'    => sanitize_title($_POST['title_todo']),
        'post_content'  => sanitize_title($_POST['content_todo']) ? sanitize_title($_POST['content_todo']) : null,
        'post_type' => 'wp-admin-todo',
        'post_status'   => 'publish',
      );

      // Insert a new post using wp_insert_post()
      $new_post_id = wp_insert_post($post_data);

      if (isset($_POST['url_todo'])) {

        update_post_meta($new_post_id, 'url_todo', serialize($_POST['url_todo']));
        update_post_meta($new_post_id, 'url_todo_hash', md5(serialize($_POST['url_todo'])));
      }
      if (isset($_POST['priority_todo']))
      update_post_meta($new_post_id, 'priority_todo', sanitize_title($_POST['priority_todo']));
      echo $new_post_id;
      echo '//';
      wp_nonce_field('delete_form_todo_action', 'delete_form_todo_nonce_field');
    }
    wp_die();
    }

  public function wp_ajax_submit_form_delete()
  {

    if (current_user_can('administrator') && wp_verify_nonce($_POST['delete_form_todo_nonce_field'], 'delete_form_todo_action')) {

      wp_delete_post(absint($_POST['todo_id']));

      echo "ok";
    }
    wp_die();
  }
  }
