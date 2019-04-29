<?php
declare(strict_types=1);

namespace SharepointMediaLibrary;

final class App
{
    public function __construct()
    {
        new General();
        new Sharepoint();
    }
}
