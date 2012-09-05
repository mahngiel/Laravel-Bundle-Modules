<?php

class Userbar_Module {
    public $name = 'Userbar Module';
    public $desc = 'Example module for a userbar';
    public $author = 'Codezyne Development';
    public $link = 'http://codezyne.me';
    public $settings = array();


    public function index()
    {
          $username = Auth::user()->username;

            // return view
            echo View::make('modules.userbar')->with('username', $username);
        }
    }
}