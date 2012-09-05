<?php namespace Modules; use \DB;

class Modules {

    public static $installed = array();

    /**
     * Module Area
     *
     * Loads a module area
     *
     * @access  public
     * @param   string
     */
    public static function recheck()
    {
        // retrieve active modules
        $installed = DB::table('modules')->get();

        // build array of installed
        foreach( $installed as $module )
            self::$installed[$module->module_slug] = array('area'=>$module->area_id, 'name'=>$module->module_name, 'priority'=>$module->module_priority);
    }

    /**
     * Get Module Areas
     *
     * Returns all module areas and their installed children
     *
     * @access  public
     * @param   string
     * @return  array
     */
    public static function getModuleAreas()
    {
        // retrieve module areas
        $areas = DB::table('module_areas')->get();

        // populate installled module array
        if( empty(self::$installed) || !is_array(self::$installed) )
            self::recheck();
        
        // iterate through areas
        foreach( $areas as $area )
        {
            // iterate through installed modules
            foreach( self::$installed as $installed )
            {
                if( $area->id == $installed['area'] )
                    $area->modules[] = $installed;
            }
        }

        // return 
        return $areas;
    }

    /**
     * Get Modules
     *
     * Returns all modules from DB & DIR
     *
     * @access  public
     * @param   string
     * @return  array
     */
    public static function getModules()
    {
        // retrieve active & avail modules
       return $modules = self::scan_modules();
    }

    /**
     * Scan modules
     *
     * Scans the module directory
     *
     * @access  public
     * @param   string
     * @return  array
     */
    public static function scan_modules()
    {   
        // Assign available modules
        $available_modules = array();

        // Loop through the module files
        foreach(glob(path('app') . 'modules/' . '*_module.php') as $module_slug)
        {
            // Get the file name
            $module_slug = basename($module_slug, '_module.php');

            // Get the file name
            array_push($available_modules, self::read_module($module_slug) );
        }

        // Return the available modules
        return $available_modules;
    }

    /**
     * Read module
     *
     * Reads a module
     *
     * @access  public
     * @param   string
     * @return  array
     */
    public static function read_module($module_slug = '')
    {
        // Check if the module exists
        if(file_exists(path('app') . 'modules/' . $module_slug . '_module.php'))
        {
            // Include the module
            include_once(path('app') . 'modules/' . $module_slug . '_module.php');
        
            // Assign class name
            $class_name = ucfirst($module_slug . '_module');
            
            // Initiate the module
            $module = new $class_name;
            
            // Retrieve the module information
            $module = (object) get_object_vars($module);
            
            // Assign slug
            $module->slug = $module_slug;
            
            // check to see if module is installed
            $module->installed = self::isInstalled($module->slug);

            // Return the module
            return $module;
        }
        else
        {
            // File doesn't exist, return FALSE
            return FALSE;
        }
    }

    /**
     * Is Installed
     *
     * Checks if module is installed
     * this can really be done better with better queries
     *
     * @access  public
     * @param   string
     * @return  array
     */
    public static function isInstalled( $module_slug )
    {
        // populate installled module array
        if( empty(self::$installed) || !is_array(self::$installed) )
            self::recheck();

        // check if module is installed
        if( isset(self::$installed[$module_slug]) )
            return TRUE;
        else 
            return FALSE;
    }

    /**
     * Module
     *
     * Loads a module view
     *
     * @access  public
     * @param   string
     * @return  string
     */
    public static function getModule( $module_slug = '' )
    {
        // Check if data is valid
        if ($module_slug == '')
        {
            // Data is invalid, return FALSE;
            return FALSE;
        }
        
        // Create the module's path
        $module_path = path('app') . 'modules/' . $module_slug . '_module.php';

        // Check if the module file exists
        if( file_exists( $module_path ) && DB::table('modules')->where('module_slug', '=', $module_slug)->get() )
        {
            // Include the module
            include_once( $module_path );
            
            // Assign class name
            $class_name = ucfirst( basename( $module_slug . '_module') );
            
            // Initiate the module
            $module = new $class_name();
            
            // Return the module
            return $module->index();
        }
        else
        {
            // module doesn't exist, return FALSE
            return FALSE;
        }
    }

    /**
     * Module Area
     *
     * Loads a module area
     *
     * @access  public
     * @param   string
     */
    public static function getModuleArea( $area_slug = '')
    {
        // Check if data is valid
        if( !$area = DB::table('module_areas')->where('area_slug', '=', $area_slug)->first() )
        {
            // Data is invalid, return FALSE;
            return FALSE;
        }
        // Retrieve the modules
        if( $modules = DB::table('modules')->where('area_id', '=', $area->id)->get() )
        {
            // modules exist, loop through each module
            foreach( $modules as $module )
            {
                self::getModule( $module->module_slug );
            }
        }
    }
}