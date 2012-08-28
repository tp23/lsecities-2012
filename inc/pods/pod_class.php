<?php
namespace LC;

class PodObject {
  public $page_title;
  public $page_section;
  private $pod;
  
  function __construct($pod, $page_section) {
    $this->pod = $pod;
    $this->page_title = $this->pod->get_field('name');
    $this->page_section = $page_section;
  }
}
