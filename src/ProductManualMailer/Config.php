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

    public function parseYml($ymlFilePath)
    {
        $conf = yaml_parse_file($ymlFilePath);
        foreach ($conf as $key => $item) {
            $this->$key = $item;
        }
    }
}