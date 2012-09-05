<?php

class Create_Module_Areas_Table {
     
     public function up()
     {
          Schema::create('module_areas', function($table){
               $table->increments('id');
               $table->string('area_name');
               $table->string('area_slug');
               $table->timestamps();
          } );
     }
     
     public function down()
     {
          Schema::drop('module_areas');
     }
     
}