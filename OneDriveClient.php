<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveCurl.php';

class OneDriveClient
{
    const API_URL = "https://api.onedrive.com/v1.0";

    /**
     * OAuth Access Token
     *
     * @var string
     */
    protected $accessToken = null;

    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function listDrive()
    {
        $api = new OneDriveCurl;
        $api->setAccessToken($this->accessToken);
        $api->setBaseUrl(self::API_URL);
        $api->setPath('/drive/root/children');

        return $api->makeRequest();        
    }

    public function listFolder($path){
        $api = new OneDriveCurl;
        $api->setAccessToken($this->accessToken);
        $api->setBaseUrl(self::API_URL);
        $api->setPath("/drive/root:/$path");

        return $api->makeRequest();
    }

}
?>