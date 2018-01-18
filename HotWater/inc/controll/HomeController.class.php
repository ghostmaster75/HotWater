<?php

namespace controll;

use model\HomeModel;


class HomeController
{

    private $model;

    public function __construct(HomeModel $model) {
        $this->model = $model;
    }

    public function textClicked() {
        $this->model->setTesto('Text Updated');
    }
}
?>