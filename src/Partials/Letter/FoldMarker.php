<?php


namespace PrettyPdf\Partials\Letter;


use PrettyPdf\Partials\Drawable;

class FoldMarker extends Drawable
{
    public function draw(): void
    {
        $this->Rect(-10, 106, 15, 0.5, 'F');
    }
}