<?php


class Pages {
    public function __construct(){

    }

    public function index(){

        $data = [
            'title' => 'laporkan orang hilang',
            'description' => 'tolong masukan data sesuai apa yang terjadi.'
        ];


        $this->loadView('pages/index', $data);
    }


    public function loadView($view, $data = []){
        if(file_exists('../app/views/' . $view . '.php')){
            require_once '../app/views/' . $view . '.php';
        } else {
            die('View does not exist');
        }
    }
}