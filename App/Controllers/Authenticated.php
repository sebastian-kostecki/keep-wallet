<?php

namespace App\Controllers;

class Authenticated extends \Core\Controller
{
    protected function before()
    {
        $this->requireLogin();
    }
}
