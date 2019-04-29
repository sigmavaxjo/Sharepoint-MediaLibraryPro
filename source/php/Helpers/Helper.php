<?php
declare(strict_types=1);

namespace SharepointMediaLibrary\Helpers;

class Helper
{
    /**
     * @var array
     */
    const PAGENAMES = [
        'sharepoint-media-library',
        'sharepoint-media-library-settings'
    ];

    /**
     * @var array
     */
    const IMAGETYPES = [
        'jpg',
        'jpeg',
        'png',
        'tif',
        'tiff',
        'gif'
    ];

    /**
     * Check whether we are on an admin page or not
     *
     * @return bool
     */
    public function isAdminPage() : bool
    {
        $page = isset($_GET['page']) ? $_GET['page'] : '';

        if (in_array($page, self::PAGENAMES)) {
            return true;
        }

        return false;
    }

    /**
     * Outputs the plugin admin header
     *
     *  @return void
     */
    public function adminHeader() : void
    {
        if (!$this->isAdminPage()) {
            return;
        }

        echo '<div id="' . SML_NAME . '-header"><img src="' . SML_URL . '/assets/images/sharepoint.png" alt="Sharepoint"></div>';
    }

    /**
     * Remove all non-Sharepoint Media Library plugin notices from plugin pages
     *
     *  @return void
     */
    public function hideUnrelatedNotices() : void
    {
        if (empty($_REQUEST['page']) || !$this->isAdminPage()) {
            return;
        }

        global $wp_filter;

        if (!empty($wp_filter['user_admin_notices']->callbacks) && is_array($wp_filter['user_admin_notices']->callbacks)) {
            foreach ($wp_filter['user_admin_notices']->callbacks as $priority => $hooks) {
                foreach ($hooks as $name => $arr) {
                    if (is_object($arr['function']) && $arr['function'] instanceof \Closure) {
                        unset($wp_filter['user_admin_notices']->callbacks[$priority][$name]);
                        continue;
                    }

                    if (!empty($arr['function'][0]) && is_object($arr['function'][0]) && strpos(strtolower(get_class($arr['function'][0])), 'sharepointmedialibrary') !== false) {
                        continue;
                    }

                    if (!empty($name) && strpos(strtolower($name), 'sharepointmedialibrary') === false) {
                        unset($wp_filter['user_admin_notices']->callbacks[$priority][$name]);
                    }
                }
            }
        }

        if (!empty($wp_filter['admin_notices']->callbacks) && is_array($wp_filter['admin_notices']->callbacks)) {
            foreach ($wp_filter['admin_notices']->callbacks as $priority => $hooks) {
                foreach ($hooks as $name => $arr) {
                    if (is_object($arr['function']) && $arr['function'] instanceof \Closure) {
                        unset($wp_filter['admin_notices']->callbacks[$priority][$name]);
                        continue;
                    }

                    if (!empty($arr['function'][0]) && is_object($arr['function'][0]) && strpos(strtolower(get_class($arr['function'][0])), 'sharepointmedialibrary') !== false) {
                        continue;
                    }

                    if (!empty($name) && strpos(strtolower($name), 'sharepointmedialibrary') === false) {
                        unset($wp_filter['admin_notices']->callbacks[$priority][$name]);
                    }
                }
            }
        }

        if (!empty($wp_filter['all_admin_notices']->callbacks) && is_array($wp_filter['all_admin_notices']->callbacks)) {
            foreach ($wp_filter['all_admin_notices']->callbacks as $priority => $hooks) {
                foreach ($hooks as $name => $arr) {
                    if (is_object($arr['function']) && $arr['function'] instanceof \Closure) {
                        unset($wp_filter['all_admin_notices']->callbacks[$priority][$name]);
                        continue;
                    }

                    if (!empty($arr['function'][0]) && is_object($arr['function'][0]) && strpos(strtolower(get_class($arr['function'][0])), 'sharepointmedialibrary') !== false) {
                        continue;
                    }

                    if (!empty($name) && strpos(strtolower($name), 'sharepointmedialibrary') === false) {
                        unset($wp_filter['all_admin_notices']->callbacks[$priority][$name]);
                    }
                }
            }
        }
    }

    /**
     * Returns HTML markup for input field
     *
     * @param string $type Input type
     * @param string $name Input name & id
     * @param string $label Input label
     *
     * @return string The HTML
     */
    public function input(string $type, string $name, string $label) : string
    {
        $html = '';

        switch ($type) {
            case 'text':
            case 'password':
                $html .= '<label for="' . $name . '">' . $label . '</label>';
                $html .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . '">';
                break;

            case 'submit':
                $html .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="' . $label . '">';
                break;

            default:
                break;
        }

        return $html;
    }

    /**
     * Returns file extension
     *
     * @param string $url Sharepoint url
     * @param object $file File object
     *
     * @return string File extension
     */
    public function getFileType(string $url, object $file) : string
    {
        $path = $url . $file->ServerRelativePath->DecodedUrl;

        // Get the extension
        $type = pathinfo($path, PATHINFO_EXTENSION);

        return $type;
    }

    /**
     * Returns truncated string
     *
     * @param string $string String to be truncated
     * @param int $max Max amount of characters
     *
     * @return string Truncated string
     */
    public function truncate(string $string, int $max = 16) : string
    {
        $length = strlen($string);

        if ($length <= $max) {
            return $string;
        }

        return substr_replace($string, '...', $max/2, $length-$max);
    }
}
