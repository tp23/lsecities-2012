<?php
namespace LC;

class PodObject {
  public static $page_title;
  public static $page_section;
  private static $pod;
  
  function __construct($pod, $page_section) {
    self::$pod = $pod;
    self::$page_title = $pod->get_field('name');
    self::$page_section = $page_section;
  }
}
