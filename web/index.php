<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.20.
 * Time: 13:13
 */

use ProductManualMailer\Config;
use ProductManualMailer\Logger;
use ProductManualMailer\Mailer;
use ProductManualMailer\Order;

$requestBody = file_get_contents("php://input");

require_once __DIR__ . "/../vendor/autoload.php";

$logger = new Logger();
$logger->writeWithTime(json_encode($requestBody), date("Y-m-d") . ".log");

$config = new Config();

$mailer = new Mailer($config);

$order = new Order($requestBody);

$mailer->prepareMail($order);

$mailer->send();
