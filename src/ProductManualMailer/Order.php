<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.22.
 * Time: 19:49
 */

namespace ProductManualMailer;


class Order
{
    private $email;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var integer
     */
    private $innerId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    public function __construct($data)
    {
        foreach ($data["orders"]["order"][0] as $key => $value) {
            $this->$key = $value;
            if ($key == "orderProducts") {
                foreach ($value as $item) {
                    $this->products[] = new Product($item[0]);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getInnerId()
    {
        return $this->innerId;
    }



    /**
     * @return Product[]
     */
    public function getOrderProducts()
    {
        return $this->products;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}