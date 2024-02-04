<?php

namespace Controllers;

use Lib\Pages;

class DashBoardController
{
    private Pages $pages;
    function __construct(){
        $this->pages= new Pages();
    }
    public function  index():void{
        $this->pages->render('dashboard/index');
    }
}