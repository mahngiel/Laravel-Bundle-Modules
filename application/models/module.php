<?php

class Module extends Eloquent {
    public static $table = 'modules';
    public static $timestamps = false;

    /*
     * Relationships
     */
    public function area()
    {
        return $this->has_one('Module_Area');
    }
}