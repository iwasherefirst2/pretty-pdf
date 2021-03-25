<?php

namespace BeautyBill\Traits;

trait PartialLoadable
{
    protected $allowOverwrite;

    private $methods = [];

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
            $class = $this->methods[$name];
            $closure = $class::getFunction();
            $closure = \Closure::bind($closure, $this->pdf, $this->pdf);
            call_user_func_array($closure, $arguments);

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

        $iterator = new \RecursiveDirectoryIterator(__DIR__ . '/../Partials');

        foreach (new \RecursiveIteratorIterator($iterator) as $directoryIterator) {
            if ($directoryIterator->getExtension() == 'php') {
                if (basename($directoryIterator->getFilename(), '.php') == 'PartialInterface') {
                    continue;
                }

                $basic_partials[] = $this->getBeautyBillNamespace($directoryIterator->getPathName());
            }
        }

        $this->load($basic_partials);
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

        $local_class = new \ReflectionClass($this);
        $local_methods = $local_class->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($classes as $class) {
            $this->addMethodFromClass($class, $local_methods);
        }
    }
    
    /**
     * @param $class
     * @param array $local_methods
     * @throws \Exception
     */
    private function addMethodFromClass($class, array $local_methods): void
    {
        $methodname = $this->getMethodName($class);

        if (!is_subclass_of($class, '\BeautyBill\Partials\PartialInterface')) {
            throw new \Exception('Class ' . $class . ' is not implementing \BeautyBill\Partials\PartialInterface.', 1);
        }

        if (!$this->allowOverwrite && array_key_exists($methodname, $this->methods)) {
            throw new \Exception('You are overwriting an exiting methods. Please change method name or allow overwriting in BeautyBill constructor.', 1);
        }

        if (in_array($methodname, $local_methods)) {
            throw new \Exception('Method is unreachable because its already definied in BeautyBill. Change method name.', 1);
        }

        $this->methods[$methodname] = $class;
    }

    /**
     * Convert absolute pth to namespace
     * @param  string $string
     * @return string
     */
    private function getBeautyBillNamespace(string $string): string
    {
        // Replace absolute path (coming from __DIR__)
        $string = preg_replace('#^.*/\.\.#', 'BeautyBill', $string);

        // Remove extensions
        $string =  preg_replace('#\.php$#', '', $string);

        return strtr($string, DIRECTORY_SEPARATOR, '\\');
    }

    private function getMethodName($string)
    {
        return lcfirst(preg_replace('/^.*\\\\/', '', $string));
    }
}
