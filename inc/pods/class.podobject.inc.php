<?php
/**
 * Pod object class
 * 
 * Accessory metadata for all Pods
 * 
 * @package lsecities-2012
 * @author Andrea Rota <a.rota@lse.ac.uk>
 * @copyright 2012 LSE Cities, London School of Economics and Political Science
 * @license AGPLv3
 */
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
