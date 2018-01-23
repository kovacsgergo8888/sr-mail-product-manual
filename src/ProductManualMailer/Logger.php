<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.23.
 * Time: 9:30
 */

namespace ProductManualMailer;


class Logger
{
    public function writeWithTime($data, $fileName)
    {
        $data = date("Y-m-d H:i:s") . " " . $data . "\n";
        file_put_contents(__DIR__ . "/../../log/$fileName", $data, FILE_APPEND);
    }

}