<?php

class Module_Area extends Eloquent {
    public static $table = 'module_areas';
    public static $timestamps = false;

    public function modules()
    {
        return $this->has_many('Module', 'area_id');
    }
}