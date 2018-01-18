<?php
require_once 'inc/config.inc.php';

use controll\HomeController;
use core\Template;
use model\HomeModel;
use view\HomeView;
use core\BasePage;
use core\HtmlElement;
use core\HtmlTags;

$model = new HomeModel();
$controller = new HomeController($model);
$view = new HomeView($model);

$basePage = new BasePage();

$basePage->addCss("css/normalize.min.css");
$basePage->addCss("css/main.css");
$basePage->addCss("https://fonts.googleapis.com/css?family=Oswald");
$basePage->addCss("https://use.fontawesome.com/releases/v5.0.2/css/all.css");

$basePage->addScript("js/plugins.js");
$basePage->addScript("js/main.js");



$loginbox = new Template("login");

$loginbox->setField("title",_TITLE);




if (isset($_GET['do']) && ! empty($_GET['do'])) {
    $controller->{$_GET['do']}();
}


$basePage->addContent("loginbox", $loginbox);
$html = new HtmlElement(HtmlTags::A);
$html->setContent("www.google.it");
$html->setAttribute("href", "https://www.google.com");

$basePage->addContent("googlelink", $html);

$basePage->showPage();



?>