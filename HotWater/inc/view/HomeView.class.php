<?php

namespace view;

use model\HomeModel;

class HomeView
{

    private $model;

    public function __construct(HomeModel $model)
    {
        $this->model = $model;
    }
    
    public function getText() {
        return $this->model->getTesto();
    }
}
?>