<?php
/**
 * Created by PhpStorm.
 * User: ginn
 * Date: 04/02/2019
 * Time: 10:47
 */
class Calculator extends Controller{
    function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $this->view->render('index');
    }
}