<?php

/**
 * Class Posts_Icons
 */
class Posts_Icons {

  const POSTS_ICONS_ENABLED = 'posts_icons_enabled';
  const POSTS_ICONS_IDS = 'posts_icons_ids';
  const POSTS_ICONS_CLASSES = 'posts_icons_classes';
  const POSTS_ICONS_POSITION = 'posts_icons_position';

	private static $initiated = false;
  private static $instance;

  public $enabled;
	public $position;
	public $posts;
	public $icons;

  /**
   * Posts_Icons constructor.
   */
	private function __construct() {
    $this->enabled = get_option(self::POSTS_ICONS_ENABLED);
    $this->position = get_option(self::POSTS_ICONS_POSITION);
    $this->posts = explode(',', get_option(self::POSTS_ICONS_IDS));
    if(!$this->posts) {
      $this->posts = array();
    }
    else {
      foreach($this->posts as &$value) {
        $value = trim($value);
      }
    }
    $this->icons = explode(',', get_option(self::POSTS_ICONS_CLASSES));
    if(!$this->icons) {
      $this->icons = array();
    }
    else {
      foreach($this->icons as &$value) {
        $value = trim($value);
      }
    }
	}

  /**
   * Singleton constructor.
   */
	public static function instance() {
	  if(!self::$instance) {
	    self::$instance = new Posts_Icons();
    }
    return self::$instance;
  }

  /**
   * Initializer.
   */
	public static function init() {
		if ( ! self::$initiated ) {
			self::init_hooks();
		}
	}

	/**
	 * Initializes WordPress hooks
	 */
	private static function init_hooks() {
		self::$initiated = true;
		add_filter( 'the_title', array( 'Posts_Icons', 'the_title' ), 10, 2 );
	}

  /**
   * Implements plugin logic : posts title alteration.
   * @param string $title
   * @param int | string $id
   * @return string
   */
	public static function the_title($title, $id) {
    //var_dump($id);
    if(self::instance()->enabled) {
      if (in_array($id, self::instance()->posts) && self::instance()->icons) {
        $key = array_search($id, self::instance()->posts);
        if (key_exists($key, self::instance()->icons)) {
          $class = self::instance()->icons[$key];
        }
        else {
          $class = self::instance()->icons[0];
        }
        $html = "<span class='dashicons {$class}'></span>";
        if(self::instance()->position == 'Left') {
          return $html . ' '. $title;
        }
        return $title . ' ' .$html;
      }
    }
    return $title;
  }
}
