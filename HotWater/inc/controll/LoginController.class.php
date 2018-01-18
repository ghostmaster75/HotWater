<?php

namespace controll;

use model\LoginModel;


class LoginController {

    private $model;

    public function __construct(LoginModel $model) {
        $this->model = $model;
    }

    public function textClicked() {
        $this->model->setTesto('Text Updated');
    }
}
?>