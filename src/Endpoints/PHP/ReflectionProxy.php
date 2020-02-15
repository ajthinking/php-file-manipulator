<?php

namespace PHPFileManipulator\Endpoints\PHP;

use PHPFileManipulator\Support\EndpointProvider;
use ReflectionClass;
use Exception;

class ReflectionProxy extends EndpointProvider
{
    public function __call($method, $args)
    {
        $reflection = $this->getReflection();
        return $reflection->$method(...$args);
    }

    public function getReflection()
    {
        $class = "\\" . $this->file->namespace() ."\\" . $this->file->className();

        return new ReflectionClass($class);
    }

    /**
     * Undocumented function
     *
     * @param [type] $signature
     * @param [type] $args
     * @return void
     */
    public function getHandlerMethod($signature, $args)
    {
        return $this->supportedReflectionMethods()
            ->pluck('name')->filter()->values()
            ->push('getReflection')
            ->first(function($name) use($signature) {
                return $name == $signature;
            });
    }

    private function supportedReflectionMethods()
    {
        return collect(
            (new ReflectionClass(
                ReflectionClass::class
            ))->getMethods()
        )->filter(function($method) {
            if($method->isPrivate()) return false;

            if(collect([
                "__construct",
                "__toString",
            ])->contains($method->name)) return false;

            return true;
        })->values();        
    }

    public function getEndpoints()
    {
        $endpoints = $this->supportedReflectionMethods()
            ->map(function($endpoint) {
                $args = collect($endpoint->getParameters())->map(function($parameter) {
                    return '$' . $parameter->getName();
                })->join(', ');

                return $endpoint->name . "($args)";
        });

        return $endpoints->unique()->toArray();
    }
}