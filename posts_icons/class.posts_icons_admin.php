<?php

/**
 * Class Posts_Icons_Admin
 */
class Posts_Icons_Admin {

  private static $initiated;

  /**
   * Initializer.
   */
  public static function init() {
    if (!self::$initiated) {
      self::init_hooks();
    }
  }

  /**
   * Callback for init().
   */
  private static function init_hooks() {
    self::$initiated = true;
    add_action( 'admin_menu', array('Posts_Icons_Admin', 'options_page_init') );
    add_action( 'admin_init', array('Posts_Icons_Admin', 'settings_init') );
  }

  /**
   * Action callback.
   */
  public static function options_page_init(){
    add_options_page( 'Posts icons', 'Posts icons', 'manage_options', 'posts_icons_settings', array('Posts_Icons_Admin','render_post_icons_settings_page'));
  }

  /**
   * Action callback.
   */
  public static function settings_init() {
    add_settings_section( 'posts_icons_section', '',null, 'posts_icons_settings' );
    add_settings_field( Posts_Icons::POSTS_ICONS_ENABLED, 'Plugin enabled', array('Posts_Icons_Admin', 'render_posts_icons_enabled'), 'posts_icons_settings', 'posts_icons_section' );
    add_settings_field( Posts_Icons::POSTS_ICONS_IDS, 'Posts ids (comma separated)', array('Posts_Icons_Admin', 'render_posts_icons_ids'), 'posts_icons_settings', 'posts_icons_section' );
    add_settings_field( Posts_Icons::POSTS_ICONS_CLASSES, 'Icon classes (comma separated)', array('Posts_Icons_Admin', 'render_posts_icons_classes'), 'posts_icons_settings', 'posts_icons_section' );
    add_settings_field( Posts_Icons::POSTS_ICONS_POSITION, 'Posts icons position', array('Posts_Icons_Admin', 'render_posts_icons_position'), 'posts_icons_settings', 'posts_icons_section' );

    register_setting('posts_icons_section', 'posts_icons_enabled', array('Posts_Icons_Admin', 'boolean_sanitize'));
    register_setting('posts_icons_section', 'posts_icons_ids');
    register_setting('posts_icons_section', 'posts_icons_classes');
    register_setting('posts_icons_section', 'posts_icons_position');
  }

  public static function render_post_icons_settings_page() {
    ?>
    <div class="wrap">
      <h1>Posts icons settings</h1>
      <form method="post" action="options.php">
        <?php
          settings_fields( 'posts_icons_section' );
          do_settings_sections( 'posts_icons_settings' );
          self::helper();
          submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Helper sanitizes boolean value.
   * @param $input
   * @return bool
   */
  public static function boolean_sanitize($input) {
    return ($input)? true : false;
  }

  /**
   * Helper renders posts_icons_enabled.
   */
  public static function render_posts_icons_enabled() {
    self::render_element('checkbox', Posts_Icons::POSTS_ICONS_ENABLED);
  }

  /**
   * Helper renders posts_icons_ids.
   */
  public static function render_posts_icons_ids() {
    self::render_element('text', Posts_Icons::POSTS_ICONS_IDS);
  }

  /**
   * Helper renders posts_icons_classes.
   */
  public static function render_posts_icons_classes() {
    self::render_element('text', Posts_Icons::POSTS_ICONS_CLASSES);
  }

  /**
   * Helper renders posts_icons_position.
   */
  public static function render_posts_icons_position() {
    self::render_element('select', Posts_Icons::POSTS_ICONS_POSITION);
  }

  /**
   * Helper that prints html elements.
   * @param $type
   * @param $name
   */
  public static function render_element ($type, $name) {
    $value = get_option($name);
    if($type == 'text') {
      echo "<input type='text' name='{$name}' id='{$name}' value='{$value}' />";
    }
    else if($type == 'checkbox') {
      if($value) {
        echo "<input type='checkbox' name='{$name}' id='{$name}' value='1' checked>";
      }
      else {
        echo "<input type='checkbox' name='{$name}' id='{$name}' value='1' >";
      }
    }
    else if ($type == 'select') {
      $options = array('Left', 'Right');
      $html = "<select name='{$name}' id='{$name}'>";
      foreach ($options as $option) {
        if($value == $option) {
          $html .= "<option selected value='{$option}'>{$option}</option>";
        }
        else {
          $html .= "<option value='{$option}'>{$option}</option>";
        }
      }
      $html .= '</select>';
      echo $html;
    }
  }

  /**
   * Additional helper text on settings page.
   */
  public static function helper() {
    $html = "Details on dash-icons: <a href='https://developer.wordpress.org/resource/dashicons/#admin-appearance'> https://developer.wordpress.org/resource/dashicons/#admin-appearance </a>";
    echo $html;
  }

}