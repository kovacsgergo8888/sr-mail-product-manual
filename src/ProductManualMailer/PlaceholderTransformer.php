<?php
/**
 * Created by PhpStorm.
 * User: kovacsgergely
 * Date: 2018.01.28.
 * Time: 15:42
 */

namespace ProductManualMailer;

class PlaceholderTransformer
{
    private $search = array(
        "[ORDER_ID]",
        "[FIRST_NAME]",
        "[LAST_NAME]",
        "[PRODUCT_LIST_HTML]",
        "[PRODUCT_LIST_TEXT]",
    );

    private $replace = array();

    public function __construct(Order $order)
    {
        $this->setReplace($order);
    }

    public function setReplace(Order $order)
    {
        $this->replace = array(
            $order->getInnerId(),
            $order->getFirstName(),
            $order->getLastName(),
            $this->getOrderListHtml($order),
            $this->getOrderListText($order),
        );
    }

    public function replace($string)
    {
        return str_replace(
            $this->search,
            $this->replace,
            $string
        );
    }

    /**
     * @param Order $order
     * @return string
     */
    public function getOrderListHtml(Order $order)
    {
        $html = "<ul>";
        foreach ($order->getOrderProducts() as $orderProduct) {
            if ($orderProduct->hasManual()) {
                $html .= "<li>" . $orderProduct->getName() . "</li>";
            }
        }
        $html .= "</ul>";

        return $html;
    }

    /**
     * @param Order $order
     * @return string
     */
    public function getOrderListText(Order $order)
    {
        $text = "\n";
        foreach ($order->getOrderProducts() as $orderProduct) {
            if ($orderProduct->hasManual()) {
                $text .= $orderProduct->getName() . "\n";
            }
        }

        return $text . "\n";
    }
}