<?php
namespace LC;

class PodObject {
  public $page_title;
  public $page_section;
  private $pod;
  
  function __construct($pod, $page_section) {
    self::$pod = $pod;
    self::$page_title = $pod->get_field('name');
    self::$page_section = $page_section;
  }
}
