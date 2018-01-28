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

    private $productManualsDir;

    public function __construct($product)
    {
        $this->productManualsDir = __DIR__ . "/../../product_manuals";

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

    public function hasManual()
    {
        return is_file($this->getManualFile());
    }

    /**
     * @return string
     */
    public function getManualFile()
    {
        return "$this->productManualsDir/{$this->getSku()}.pdf";
    }

}