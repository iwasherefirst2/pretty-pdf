<?php

namespace BeautyBill\Partials\Body;

class ItemData
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $unitPrice;

    /**
     * @var string
     */
    public $quantity;
    
    public function getPrice()
    {
        return $this->unitPrice;
    }
}
