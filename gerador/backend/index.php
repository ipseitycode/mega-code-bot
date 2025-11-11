<?php
header("Content-Type: application/json; charset=UTF-8");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// VALIDATOR
require 'validator/GeradorBackendHomeValidator.php';

// EXCEPTION
require 'exception/GeradorBackendHomeException.php';

// VIEW
require 'view/GeradorBackendHomeView.php';

// CONFIGURATION
require 'configuration/GeradorBackendHomeConfiguration.php';

// TRANSFER
require 'transfer/GeradorBackendHomeTransfer.php';

// SERVICE
require 'service/GeradorBackendHomeService.php';

// CONTROLLER
require 'controller/GeradorBackendHomeController.php';

$controller = new GeradorBackendHomeController();
$controller->obterGerador(); 