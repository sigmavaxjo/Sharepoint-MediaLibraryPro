<?php
declare(strict_types=1);

namespace SharepointMediaLibrary;

class Settings extends Helpers\Helper
{
    /**
     * Settings view
     *
     * @return void
     */
    public function pluginSettings() : void
    {
        if (!$this->isAdminPage()) {
            return;
        }

        require_once SML_TEMPLATE_PATH . 'settings.php';
    }
}
