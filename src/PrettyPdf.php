<?php

namespace PrettyPdf;

use ReflectionClass;
use ReflectionMethod;

/**
 * Class PrettyPdf
 * @package PrettyPdf
 *
 * @method TableBox(string $title, array $rows)
 */
class PrettyPdf
{
    private PDF $pdf;
    private Loader $loader;

    public function __construct()
    {
        $this->pdf = new PDF();

        $localClass = new ReflectionClass($this);
        $localMethods = $localClass->getMethods(ReflectionMethod::IS_PUBLIC);
        
        $this->loader = new Loader($localMethods, $this->pdf);
    }
    
    public function output()
    {
        return call_user_func_array([$this->pdf, 'output'], func_get_args());
    }

    public function __call(string $name, array $arguments): PrettyPdf
    {
        if (!$this->loader->hasClass($name)) {
            call_user_func_array([$this->pdf, $name], $arguments);

            return $this;
        }

        $instance = $this->loader->getClassInstance($name);
        $instance->setPdf($this->pdf);

        if (method_exists($instance, 'set')) {
            call_user_func_array([$instance, 'set'], $arguments);
        }

        $instance->draw();

        return $this;
    }

    // Allow uses to overwrite existing methods
    public function allowOverwriting(): void
    {
        $this->loader->allowOverwrite = true;
    }

    public function addCustomPartials(array $partials): void
    {
        $this->loader->addMethodFromClasses($partials);
    }
}
