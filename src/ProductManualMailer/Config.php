<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.20.
 * Time: 15:58
 */

namespace ProductManualMailer;


class Config
{
    public $isSMTP;
    public $SMTPDebug;
    public $Host;
    public $SMTPAuth;
    public $Username;
    public $Password;
    public $SMTPSecure;
    public $Port;
    public $BCCEmail;
    public $fileNamePattern;
    public $fromEmail;
    public $fromName;
    public $subject;

    private $configDir;

    public function __construct()
    {
        $this->configDir = __DIR__ . "/../../config";

        $conf = parse_ini_file($this->configDir . "/config.ini");

        foreach ($conf as $key => $item) {
            $this->$key = $item;
        }

    }

    public function getHtmlFileContent()
    {
        return file_get_contents($this->configDir . "/mail_body_html.html");
    }

    public function getTextFileContent()
    {
        return file_get_contents($this->configDir . "/mail_body_text.txt");
    }
}