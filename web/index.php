<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.20.
 * Time: 13:13
 */

use ProductManualMailer\Config;
use ProductManualMailer\Mailer;

require_once __DIR__ . "/../vendor/autoload.php";

$config = new Config();
$config->parseYml(__DIR__ . "/../config/config.yml");
$mailer = new Mailer($config);
$mailer->prepareMail($_POST);
$mailer->send();
