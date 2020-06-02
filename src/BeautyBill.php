<?php

namespace BeautyBill;

require_once __DIR__ . '/../vendor/autoload.php';
//require_once __DIR__ . '/Partials/Header.php';

class BeautyBill
{
    protected $infoText;

    protected $timestamp;

    protected $pdf;

    public function __construct(array $parcials = [])
    {
        $this->timestamp = time();

        $this->pdf = new PDF();

        $this->methods = [];

        if (empty($parcials)) {
            $parcials = [\BeautyBill\Parcials\HeaderLine::class,
                \BeautyBill\Parcials\Logo::class,
                \BeautyBill\Parcials\HeaderInfoBox::class,
            ];
        }

        $this->load($parcials);

        if (array_key_exists('drawHeaderLine', $this->methods)) {
            $this->drawHeaderLine();
        }
    }

    public function __call($name, $arguments)
    {
        if (array_key_exists($name, $this->methods)) {
            $class = $this->methods[$name];
            $closure = $class::getFunction();

            $closure = \Closure::bind($closure, $this->pdf, $this->pdf);

            call_user_func_array($closure, $arguments);

            return $this;
        }

        return call_user_func_array([$this->pdf, $name], $arguments);
    }

    public function load(array $classes)
    {
        $local_class = new \ReflectionClass($this);
        $local_methods = $local_class->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($classes as $class) {
            $methodname = $class::$functionname;

            if (!is_subclass_of($class, '\BeautyBill\Parcials\ParcialAbstract')) {
                throw new \Exception('Class is not extending from parcials.', 1);
            }

            if (in_array($methodname, $this->methods)) {
                throw new \Exception('Method has been defined before.', 1);
            }

            if (in_array($methodname, $local_methods)) {
                throw new \Exception('Method is unreachable because its already definied in BeautyBill. Change method name.', 1);
            }
            $this->methods[$methodname] = $class;
        }
    }
}
