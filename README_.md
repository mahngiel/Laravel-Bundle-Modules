Laravel-Modules
===============

Partial controller-view loader for the Laravel Framework.

The Modules Bundle handles loading module controllers and their views for seamless integration of 
partial logical views into your application.  No difficult namespacing or path variables are 
required, you simply develop controllers, models, and views directly in your application!


#Installation#
*application/bundles.php*

`'modules' => array('auto' =>true);`

*application/start.php*

Autoloader::map(array(
`'Module_Area' => path('app') . 'models/module_area.php`

*application/migrations*

Use artisan or the included sql file to prepare your database with the easy-to-use table structure.

#Directory Setup#
*application/Modules*

> This folder houses the controllers that contain the front-end logic for your partials

*application/views/modules*

> This folder contains your module views

#Usage#
Create entire areas useful for sidebars or individual modules, it's flexible!

Call module areas within your views
`{{ Modules::getModuleArea( 'sidebar') }}`

Call an individual module
`{{ Modules::getModule( 'userbar') }}`

#Examples#
This package contains an example controller, action forms, and a view to get you started.
