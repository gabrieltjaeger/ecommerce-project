<?php

namespace src\presentation;

use src\presentation\Page;

class AdminPage extends Page
{
  public function __construct($data = [], $template)
  {
    parent::__construct($data, $template, "/presentation/views/admin", "/assets/admin/");
  }
}

?>