<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.20.
 * Time: 13:13
 */

if(empty($_POST["data"])) {
    exit("no data");
}

$data = json_decode($_POST["data"], true);

use ProductManualMailer\Config;
use ProductManualMailer\Logger;
use ProductManualMailer\Mailer;
use ProductManualMailer\Order;

require_once __DIR__ . "/../vendor/autoload.php";

$logger = new Logger();
$logger->writeWithTime(json_encode($data), date("Y-m-d") . ".log");

$config = new Config();

$mailer = new Mailer($config);

$order = new Order($data);

$mailer->prepareMail($order);
$logger->writeWithTime("sending {$mailer->getAttachmentNumber()} ({$mailer->getAttachementList()}) manual to {$mailer->getRecepientMail()}", date("Y-m-d") . ".log");
$mailer->send();
