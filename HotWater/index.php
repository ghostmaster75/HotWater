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

$basePage->setPageTitle("Example of HotWater");
$basePage->addCss("css/normalize.min.css");
$basePage->addCss("css/main.css");
$basePage->addCss("https://fonts.googleapis.com/css?family=Oswald");
$basePage->addCss("https://use.fontawesome.com/releases/v5.0.2/css/all.css");

$basePage->addScript("js/plugins.js");
$basePage->addScript("js/main.js");


#load template object and set fields
$loginbox = new Template("login");
$loginbox->setField("title",_TITLE);

#add content from template
#$basePage->addContent("loginbox", $loginbox);


$menu = new Template("menu");

#add html element
$html = new HtmlElement(HtmlTags::LI);
for ($i = 0; $i < 10; $i++) {
    $html->setContent("Menu Voice $i" );
    $menu->addElementToField("menulist", $html->getHtmlTag());
}

$basePage->addContent("menu", $menu);

$basePage->showPage();



?>