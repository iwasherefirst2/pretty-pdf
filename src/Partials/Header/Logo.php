<?php

namespace PrettyPdf\Partials\Header;

use PrettyPdf\Partials\Drawable;

class Logo extends Drawable
{
    /**
     * @var string
     */
    private $path;

    public function set(string $path): void
    {
        $this->path = $path;
    }
    
    /**
     * Add logo to invoice
     */
    public function draw(): void
    {
        $this->image($this->path, $this->leftMargin, 10, 0, 25);
    }
}
