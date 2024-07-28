<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    /*
     * --------------------------------------------------------------------------
     * Templates
     * --------------------------------------------------------------------------
     * The templates for rendering pagination links.
     */
    public $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',
        'default_head'   => 'CodeIgniter\Pager\Views\default_head',
        'bootstrap_pagination' => 'App\Views\Pagers\bootstrap_pagination',
    ];

    // Default options for the Pager.
    public $perPage = 20;
}
