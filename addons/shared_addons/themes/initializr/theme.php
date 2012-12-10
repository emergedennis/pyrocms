<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Initializr extends Theme {

    public $name = 'Initializr';
    public $author = 'eMerge';
    public $author_website = 'http://easyemerge.com/';
    public $website = 'http://initializr.com/';
    public $description = 'An HTML5 boilerplate with Twitter Bootstrap. A base theme for PyroCMS created by eMerge.';
    public $version = '1.0';
    public $options = array(
        'show_breadcrumbs' => array(
            'title' => 'Do you want to show breadcrumbs?',
            'description' => 'If selected it shows a string of breadcrumbs at the top of the page.',
            'default' => 'yes',
            'type' => 'radio',
            'options' => 'yes=Yes|no=No',
            'is_required' => TRUE
        ),
    );

}

/* End of file theme.php */