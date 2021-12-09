<?php

namespace PrettyPdf\Partials\Invoice\Data;

class Item
{
    public string $title;
    public string $description;
    public string $unitPrice;
    public string $quantity;
    
    public function getPrice(): string
    {
        return $this->unitPrice;
    }
}
