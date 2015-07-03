<?php

require 'vendor/autoload.php';

$indexController = new Sainsburys\IndexController();
echo $indexController->run();

?>
