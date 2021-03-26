<?php

namespace PrettyPdf;

use Exception;
use PrettyPdf\Builder\Cell;

/**
 * Class Loader
 * @package BeautyBill
 *
 * This class helps to
 */
class Loader
{
    /**
     * @var bool
     */
    public $allowOverwrite;

    /**
     * @var array
     */
    private $methods;

    /**
     * @var array
     */
    private $blockedMethods;

    /**
     * @var PDF
     */
    private $pdf;

    /**
     * Loader constructor.
     * @param $localMethods
     * @param PDF $pdf
     */
    public function __construct($localMethods, PDF $pdf)
    {
        $this->pdf = $pdf;

        $this->allowOverwrite = false;

        $this->methods = [];
        
        $this->blockedMethods = $localMethods;
        
        $this->addBasicPartials($localMethods);
    }
    
    public function hasClass($name)
    {
        return array_key_exists($name, $this->methods);
    }
    
    public function getClassInstance($name)
    {
        if (!$this->hasClass($name)) {
            return null;
        }

        $class    = $this->methods[$name];

        $cellBuilder = new Cell($this->pdf);

        return new $class($cellBuilder);
    }

    /**
     * Add all methods definied in the classes
     * in folder `Parcials`
     */
    private function addBasicPartials(): void
    {
        $classes = [];

        $iterator = new \RecursiveDirectoryIterator(__DIR__ . '/Partials');

        foreach (new \RecursiveIteratorIterator($iterator) as $directoryIterator) {
            if (!$directoryIterator->getExtension() == 'php') {
                continue;
            }
            
            if (basename($directoryIterator->getFilename(), '.php') == 'Drawable') {
                continue;
            }

            $classes[] = $this->getBeautyBillNamespace($directoryIterator->getPathName());
        }
        
        $this->addMethodFromClasses($classes);
    }
    
    /**
     * Convert absolute pth to namespace
     * @param  string $string
     * @return string
     */
    private function getBeautyBillNamespace(string $string): string
    {
        // Replace absolute path from outside with Beautybill
        $string = preg_replace('#.*src#', 'PrettyPdf', $string);

        // Remove extensions
        $string =  preg_replace('#\.php$#', '', $string);

        // Replace directoy seperator with backslash
        return strtr($string, DIRECTORY_SEPARATOR, '\\');
    }

    private function getMethodName($string): string
    {
        return lcfirst(preg_replace('/^.*\\\\/', '', $string));
    }

    /**
     * @param array $classes
     * @throws Exception
     */
    public function addMethodFromClasses(array $classes): void
    {
        if (empty($classes)) {
            return;
        }

        foreach ($classes as $class) {
            $this->addMethodFromClass($class);
        }
    }

    /**
     * @param $class
     * @throws Exception
     */
    private function addMethodFromClass($class): void
    {
        $methodname = $this->getMethodName($class);
       
        if (!$this->isDrawable($class)) {
            return;
        }
    
        $this->validateNoOverwrite($methodname);

        $this->methods[$methodname] = $class;
    }

    /**
     * Check if class extends abstract class drawable.
     * The native function is_subclass_of does not work for abstract classes
     */
    private function isDrawable($class): bool
    {
        $reflectionClass = new \ReflectionClass($class);

        return $reflectionClass->getParentClass()->name ==  'PrettyPdf\Partials\Drawable';
    }

    /**
     * @param $methodname
     * @throws Exception
     */
    private function validateNoOverwrite($methodname): void
    {
        if (!$this->allowOverwrite && array_key_exists($methodname, $this->methods)) {
            throw new Exception('You are overwriting an exiting methods. Please change method name or allow overwriting in BeautyBill.', 1);
        }

        if (in_array($methodname, $this->blockedMethods)) {
            throw new Exception('Method is unreachable because its already definied in BeautyBill. Change method name.', 1);
        }
    }
}
