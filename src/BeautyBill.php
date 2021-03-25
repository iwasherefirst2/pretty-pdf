<?php

namespace BeautyBill;

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/Partials/Header.php';

class BeautyBill
{
    private $allowOverwrite;

    /**
     * @var array
     */
    private $methods;
    
    /**
     * @var PDF
     */
    private $pdf;

    public function __construct()
    {
        $this->allowOverwrite = false;
        
        $this->methods = [];

        $this->pdf = new PDF();

        $this->addBasicPartials();
    }

    public function output()
    {
        $this->drawHeaderLine();
        $this->invoiceHeadline();

        return call_user_func_array([$this->pdf, 'output'], func_get_args());
    }

    /**
     * Add methods defined in parcials to
     * object with this trait
     * @param  string $name
     * @param  array $arguments
     * @return this
     */
    public function __call($name, $arguments)
    {
        if ($name == 'output') {
            return call_user_func_array([$this->pdf, $name], $arguments);
        }
       
        if (array_key_exists($name, $this->methods)) {
            $class    = $this->methods[$name];

            $instance = new $class();

            $instance->setPdf($this->pdf);
            
            if (method_exists($instance, 'set')) {
                call_user_func_array([$instance, 'set'], $arguments);
            }

            $instance->draw();
          
            return $this;
        }

        call_user_func_array([$this->pdf, $name], $arguments);

        return $this;
    }

    /**
     * Allow uses to overwrite existing methods
     */
    public function allowOverwriting(): void
    {
        $this->allowOverwrite = true;
    }

    public function addCustomPartials(array $parcials): void
    {
        $this->load($parcials);
    }

    public function addFinisherPartials(array $parcials): void
    {
    }

    /**
     * Add all methods definied in the classes
     * in folder `Parcials`
     */
    private function addBasicPartials(): void
    {
        $basic_partials = [];

        $iterator = new \RecursiveDirectoryIterator(__DIR__ . '/Partials');

        foreach (new \RecursiveIteratorIterator($iterator) as $directoryIterator) {
            if ($directoryIterator->getExtension() == 'php') {
                if (basename($directoryIterator->getFilename(), '.php') == 'Drawable') {
                    continue;
                }

                $basic_partials[] = $this->getBeautyBillNamespace($directoryIterator->getPathName());
            }
        }

        $this->load($basic_partials);
    }

    /**
     * Convert absolute pth to namespace
     * @param  string $string
     * @return string
     */
    private function getBeautyBillNamespace(string $string): string
    {
      
        // Replace absolute path (coming from __DIR__)
        $string = preg_replace('#.*src#', 'BeautyBill', $string);
        
        // Remove extensions
        $string =  preg_replace('#\.php$#', '', $string);

        return strtr($string, DIRECTORY_SEPARATOR, '\\');
    }

    private function getMethodName($string)
    {
        return lcfirst(preg_replace('/^.*\\\\/', '', $string));
    }

    /**
     * Add methods of $classes
     * @param  array $classes
     */
    private function load(array $classes): void
    {
        if (empty($classes)) {
            return;
        }

        $localClass = new \ReflectionClass($this);
        $localMethods = $localClass->getMethods(\ReflectionMethod::IS_PUBLIC);
       
        foreach ($classes as $class) {
            $this->addMethodFromClass($class, $localMethods);
        }
    }

    /**
     * @param $class
     * @param array $localMethods
     * @throws \Exception
     */
    private function addMethodFromClass($class, array $localMethods): void
    {
        $methodname = $this->getMethodName($class);
   
        $this->validateClassIsDrawable($class);

        if (!$this->allowOverwrite && array_key_exists($methodname, $this->methods)) {
            throw new \Exception('You are overwriting an exiting methods. Please change method name or allow overwriting in BeautyBill.', 1);
        }

        if (in_array($methodname, $localMethods)) {
            throw new \Exception('Method is unreachable because its already definied in BeautyBill. Change method name.', 1);
        }

        $this->methods[$methodname] = $class;
    }

    /**
     * Check if class extends abstract class drawable.
     * The native function is_subclass_of does not work for abstract classes
     */
    private function validateClassIsDrawable($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        
        if ($reflectionClass->getParentClass()->name !=  'BeautyBill\Partials\Drawable') {
            throw new \Exception('Class ' . $class . ' is not extending \BeautyBill\Partials\Drawable.', 1);
        }
    }
}
