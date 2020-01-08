<?php

namespace Ajthinking\PHPFileManipulator\Resources;

use Ajthinking\PHPFileManipulator\Support\ArrayPropertyResource;

class FillableResource extends ArrayPropertyResource
{
    public function get()
    {
        return $this->items('fillable');
    }

    public function set($values)
    {
        return $this->setItems('fillable', $values);
    }
}