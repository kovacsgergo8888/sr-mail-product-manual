<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.20.
 * Time: 13:13
 */

use ProductManualMailer\Config;
use ProductManualMailer\Mailer;
use ProductManualMailer\Order;

require_once __DIR__ . "/../vendor/autoload.php";

$config = new Config();

$mailer = new Mailer($config);

$order = new Order(file_get_contents("php://input"));

$mailer->prepareMail($order);

$mailer->send();
