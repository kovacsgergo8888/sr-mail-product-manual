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

    const CONFIG_DIR = __DIR__ . "/../../config";

    public function __construct()
    {
        $conf = parse_ini_file(self::CONFIG_DIR . "/config.ini");

        foreach ($conf as $key => $item) {
            $this->$key = $item;
        }

    }

    public function getHtmlFileContent()
    {
        return file_get_contents(self::CONFIG_DIR . "/mail_body_html.html");
    }

    public function getTextFileContent()
    {
        return file_get_contents(self::CONFIG_DIR . "/mail_body_text.txt");
    }
}