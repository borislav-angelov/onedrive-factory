<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveCurl.php';

class OneDriveClient
{
    const API_URL = "https://api.onedrive.com/v1.0";

    protected $accessToken = null;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }
}
?>