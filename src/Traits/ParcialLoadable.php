<?php

namespace BeautyBill\Traits;

trait ParcialLoadable
{
    private $methods = [];

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

    private function addBasicParcials()
    {
        $basic_parcials = [];
        foreach (glob(__DIR__ . '/../Parcials/*.php') as $file) {
            if (basename($file, '.php') == 'ParcialInterface') {
                continue;
            }

            $basic_parcials[] = 'BeautyBill\\Parcials\\' . basename($file, '.php');
        }

        $this->load($basic_parcials);
    }

    private function load($classes)
    {
        if (empty($classes)) {
            return;
        }

        $local_class = new \ReflectionClass($this);
        $local_methods = $local_class->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($classes as $class) {
            $methodname = $this->getMethodName($class);

            if (!is_subclass_of($class, '\BeautyBill\Parcials\ParcialInterface')) {
                throw new \Exception('Class is not implementing \BeautyBill\Parcials\ParcialInterface.', 1);
            }

            if (in_array($methodname, $local_methods)) {
                throw new \Exception('Method is unreachable because its already definied in BeautyBill. Change method name.', 1);
            }
            
            $this->methods[$methodname] = $class;
        }
    }

    private function getMethodName($string)
    {
        return lcfirst(preg_replace('/^.*\\\\/', '', $string));
    }
}
