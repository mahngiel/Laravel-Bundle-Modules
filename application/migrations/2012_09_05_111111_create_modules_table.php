<?php

class Create_Module_Areas_Table {
     
     public function up()
     {
          Schema::create('modules', function($table){
               $table->increments('id');
               $table->integer('area_id')->references('id')->on('module_areas');
               $table->string('module_name', 50);
               $table->string('module_slug', 50)->unique();
               $table->text('module_settings');
               $table->integer('module_priority', 3);
               $table->timestamps();
          } );
     }
     
     public function down()
     {
          Schema::drop('modules');
     }
     
}
