<?php

namespace SharepointMediaLibrary;

class Settings
{

    public function __construct()
    {

        add_action('admin_menu', [$this, 'adminMenu']);

    }

    public function adminMenu()
    {

        add_options_page('Sharepoint Media Library', 'Sharepoint Media Library', 'manage_options', 'sharepoint-media-library-pro', [$this, 'pluginSettings']);

    }

    public function pluginSettings()
    {



    }
    
}
