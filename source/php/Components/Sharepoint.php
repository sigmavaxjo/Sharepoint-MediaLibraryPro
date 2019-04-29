<?php
declare(strict_types=1);

namespace SharepointMediaLibrary;

use Thybag\SharePointAPI;
use Office365\PHP\Client\Runtime\Auth\AuthenticationContext;
use Office365\PHP\Client\SharePoint\ClientContext;

class Sharepoint extends Helpers\Helper
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $list;

    public function __construct()
    {
        if (!$this->isAdminPage()) {
            return;
        }

        $this->connect();
    }

    /**
     * Make connection to Sharepoint Online
     *
     * TODO: Use OAuth instead?
     *
     * @return void
     */
    private function connect() : void
    {
        $this->username = $_ENV['SHAREPOINT_USERNAME'];
        $this->password = $_ENV['SHAREPOINT_PASSWORD'];
        $this->url      = $_ENV['SHAREPOINT_URL'];
        $this->subsite  = $_ENV['SHAREPOINT_SUBSITE'];
        $this->list     = $_ENV['SHAREPOINT_LIST'];

        // Set the url in AuthContext
        $authContext = new AuthenticationContext($this->url . '/' . $this->subsite);

        // Aquire token
        $authContext->acquireTokenForUser($this->username, $this->password);

        // Auth user
        $clientContext = new ClientContext($this->url . '/' . $this->subsite, $authContext);

        // Initiate web
        $web = $clientContext->getWeb();

        // Get list by title
        $list = $web->getLists()->getByTitle($this->list);

        // Get all items in list
        $items = $list->getItems()->select('Id,Title');

        // Query Sharepoint for items
        $clientContext->load($items);
        $clientContext->executeQuery();

        // Get the data
        $data = $items->getData();

        foreach ($data as $i => $item) {
            $this->data[$i] = new \stdClass;

            $this->data[$i]->id = $item->Id;
            $this->data[$i]->title = $item->Title;
            $this->data[$i]->attachments = $item->AttachmentFiles;

            ++$i;
        }
    }

    /**
     * Media library view
     *
     * @return void
     */
    public function mediaLibrary() : void
    {
        if (!$this->isAdminPage()) {
            return;
        }

        require_once SML_TEMPLATE_PATH . 'media-library.php';
    }

    /**
     * Returns filetype
     *
     * @param object $attachment File object
     *
     * @return string The HTML
     */
    public function displayAttachment(object $attachment)
    {
        $type = $this->getFileType($this->url, $attachment);

        // Is an image
        if (in_array(strtolower($type), self::IMAGETYPES)) {
            return '<img src="' . $this->url . $attachment->ServerRelativePath->DecodedUrl . '" alt="' . $attachment->FileName . '">';
        }

        // Is not an image
        return '<div class="' . SML_NAME . '-document" data-type="' . $type . '"><span class="dashicons dashicons-media-document"></span></div>';
    }
}
