<?php

class Modules_Controller extends Base_Controller {

       // Create restful controller 
	public $restful = true;

    /**
     * Index
     *
     * Admin module index controller.  Lists all modules with option to install or update settings
     *
     * @access  admin
     */
	public function get_index()
	{
		// retrieve modules and areas
		$modules = Modules::getModules();
		$areas = Modules::getModuleAreas();

		// load view
		return View::make('admin.modules')
			->with('modules', $modules)
			->with('areas', $areas);
	}

    /**
     * Areas
     *
     * Shows created module areas and its installed modules
     *
     * @access  admin
     */
	public function get_areas()
	{
		return View::make('admin.module_areas')
			->with('areas', Modules::getModuleAreas());
	}
	
    /**
     * Settings
     *
     * Reads a module and permits editing of default settings
     *
     * @param string
     * @access  admin
     */
	public function get_settings( $module_slug )
	{
		// retrieve requested module
		$module = Modules::read_module( $module_slug );

		// module fail to load?
		if( $module == '' || empty($module) || !is_object($module) )
			return Redirect::back()->with('alert', 'The module you requested is invalid or not found!');
		else
		{
			return View::make('admin.module')
				->with('module', $module)
				->with('areas', Modules::getModuleAreas());
		}
	}

    /**
     * New Area
     *
     * Registers form to create new module area
     *
     * @access  admin
     */
	public function get_newarea()
	{
		return View::make('forms.module_area');
	}

    /**
     * Create Area (POST)
     *
     * POST receiver for created module area
     *
     * @access  POST
     */
	public function post_cratearea()
	{
		$data = Module_Area::create(array(
			'area_name'	=> Input::get('name'),
			'area_slug' => str_replace(' ', '_', Input::get('name')),
			));		

		if( !(bool)$data )
			return Redirect::back()->with('alert', 'Module Area creation failed!');
		else
			return Redirect::to_route('modules')->with('message', 'Module Area ' . ucfirst(Input::get('name') . ' was successfully created'));
	}

    /**
     * Install (PUT)
     *
     * Installs a module into the database
     *
     * @access  PUT
     */
	public function put_install()
	{
		// Module needs to be installed
		if( !(bool)Modules::isInstalled(Input::get('slug')) )
		{
			$data = Module::create(array(
				'area_id'	=> Input::get('module_area'),
				'module_name' => Input::get('module_name'),
				'module_slug' => Input::get('slug'),
				'module_settings' => serialize(Input::get('settings')),
				));

			if( !(bool)$data )
				return Redirect::back()->with('alert', 'Module installation failed!');
			else
				return Redirect::to_route('module_areas')->with('message', 'Module ' . ucfirst(Input::get('slug') . ' was successfully installed'));
		}
	}

    /**
     * Upate (PUT)
     *
     * Updates an installed module's settings
     *
     * @access  PUT
     */
	public function put_update()
	{
		$module = Module::where_module_slug(Input::get('slug'))->first();

		$module->area_id = Input::get('module_area');
		$module->module_name = Input::get('module_name');
		$module->module_settings = serialize(Input::get('settings'));

		$module->save();
		
		return Redirect::to_route('modules')->with('message', 'Module ' . ucfirst(Input::get('slug') . ' was successfully updated'));		
	}

    /**
     * Uninstall
     *
     * Removes the database entry for an installed module
     *
     * @access  DELETE
     */
	public function delete_uninstall()
	{ 
		Module::where_module_slug( Input::get('slug'))->delete();
		return Redirect::back()->with('message', ucfirst(Input::get('slug')) . ' Module Successfully Uninstalled');
	}

}