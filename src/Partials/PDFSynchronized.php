<?php

namespace PrettyPdf\Partials;

use PrettyPdf\PDF;

trait PDFSynchronized
{
    /**
     * @var PDF
     */
    protected $pdf;

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdf, $name], $arguments);
    }

    public function __get(string $name)
    {
        return $this->pdf->{$name};
    }
}
