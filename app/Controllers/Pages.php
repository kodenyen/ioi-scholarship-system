<?php

class Pages extends Controller {
    public function __construct() {
    }

    public function index() {
        $data = [
            'title' => 'Welcome to IOI Scholarship'
        ];
        $this->view('pages/index', $data);
    }
}
