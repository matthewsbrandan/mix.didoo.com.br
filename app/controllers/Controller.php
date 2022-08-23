<?php

class Controller{
  protected $cms;
  protected $theme_slug;

  public function __construct($cms, $theme_slug){
    $this->cms = $cms;
    $this->theme_slug = $theme_slug;
  }
}