<?php

class Issues_Module {
    public $name = 'Issues Module';
    public $desc = 'Displays example development issues';
    public $author = 'Codezyne Development';
    public $link = 'http://codezyne.me';
    public $settings = array(
        'count' => array(
            'type'      => 'input',
            'value'   => 10,
            'name'      => 'count',
            'desc'      => 'How many issues to show'
            ),
        );

    public function index()
    {
        $issues = Issue::order_by('priority')->take( $this->settings['count']['value'])->get();

        echo View::make('modules.issues')->with('issues', $issues);
            
    }
}