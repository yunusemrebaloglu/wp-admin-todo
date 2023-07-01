<?php

namespace Plugin_ATD;


defined('ABSPATH') or die('No script kiddies please!');

class Todo
{

  public function __construct()
  {
    add_action('init', array($this,'create_admin_todo_post_type'));
    add_action('admin_menu', array($this, 'add_plugin_menu'));
    add_action('admin_bar_menu', array($this, 'add_plugin_menu_bar'), 999);
    add_action('admin_footer', array($this,'my_plugin_load_template'));
    add_action('wp_ajax_submit_form', array( $this,'wp_ajax_submit_form')); 
    add_action('wp_ajax_nopriv_submit_form', array( $this,'wp_ajax_submit_form'));
    add_action('wp_ajax_submit_form_delete', array( $this,'wp_ajax_submit_form_delete')); 
    add_action('wp_ajax_nopriv_submit_form_delete', array( $this,'wp_ajax_submit_form_delete'));
  }

  
  public function add_plugin_menu()
  {
    add_menu_page(
      'Todo List',
      'Todo List',
      'manage_options',
      'todo-list',
      array($this, 'render_todo_list_page'),
      'dashicons-list-view',
      20
    );
  }

  
  public function render_todo_list_page()
  {
    include(PLUGIN_DIR_ATD . 'views/list.php');
  }

  public function add_plugin_menu_bar($wp_admin_bar)
  {
    if(isset($_GET['page']) && $_GET['page'] == 'todo-list') return;
    $wp_admin_bar->add_menu(
      array(
        'id'    => 'todo-list',
        'title' => 'Todo List',
        'meta'  => array(
          'class' => 'todo-list-menu',
          'title' => 'Todo List',
        ),
      )
    );

    
  }

  public function my_plugin_load_template()
  {
    include(PLUGIN_DIR_ATD . 'views/modal.php');
  }


  
  public function create_admin_todo_post_type()
  {
    $args = array(
      'public' => false, // Post type'un genel erişime açık olmadığını belirtir
      'exclude_from_search' => true, // Arama sonuçlarından çıkarılmasını sağlar
      'show_ui' => false, // Admin panelinde gösterilmez
      'show_in_menu' => false, // Admin menüsünde gösterilmez
      'supports' => array('title', 'content'), // Başlık ve içerik desteği
    );
    register_post_type('admin-todo', $args);
  }
  public function wp_ajax_submit_form() {
    
    if (current_user_can('administrator')) {

      $post_data = array(
        'post_title'    => $_POST['title_todo'],
        'post_content'  => $_POST['content_todo'] ? $_POST['content_todo'] : null,
        'post_type' => 'admin-todo',
        'post_status'   => 'publish'
      );

      // Yeni yazıyı eklemek için wp_insert_post() işlevini kullan
      $new_post_id = wp_insert_post($post_data);
      
      if(isset($_POST['url_todo']));
      update_post_meta($new_post_id, 'url_todo' , $_POST['url_todo']);
      if(isset($_POST['priority_todo']));
      update_post_meta($new_post_id, 'priority_todo' , $_POST['priority_todo']);
      echo $new_post_id;
    }
    wp_die(); 

    
    }


  public function wp_ajax_submit_form_delete()
  {

    if (current_user_can('administrator')) {

     wp_delete_post($_POST['todo_id']);

     echo "ok";
    }
    wp_die();
  }


}