<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.22.
 * Time: 20:00
 */

namespace ProductManualMailer;


class Product
{
    private $sku;
    private $name;

    public function __construct($product)
    {
        foreach ($product as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


}