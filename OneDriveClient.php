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

    public function listDrive() {
      $api = new OneDriveCurl;
      $api->setAccessToken($this->accessToken);
      $api->setBaseURL(self::API_URL);
      $api->setPath('/drive/root/children');

      return $api->makeRequest();
    }

    public function listFolder($path) {
      $api = new OneDriveCurl;
      $api->setAccessToken($this->accessToken);
      $api->setBaseURL(self::API_URL);
      $api->setPath("/drive/root:/$path");

      return $api->makeRequest();
    }

    public function createFolder($path) {
      $api = new OneDriveCurl;
      $api->setAccessToken($this->accessToken);
      $api->setBaseURL(self::API_URL);
      $api->setOption(CURLOPT_POST, true);
      $api->setPath("/drive/items/root:/new_folder");
      $api->setOption(CURLOPT_POSTFIELDS, array(
        'root' => 'root',
        'path' => $path,
        ));

      return $api->makeRequest();
    }

    public function uploadFile($path, $filename) {

       $my_file = fopen($filename, 'r');

       $api = new OneDriveCurl;
       $api->setAccessToken($this->accessToken);
       $api->setBaseURL(self::API_URL);
       $api->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
       $api->setOption(CURLOPT_INFILE, $my_file);
       $api->setOption(CURLOPT_PUT, true);
       $api->setOption(CURLOPT_INFILESIZE, filesize($filename));
       $api->setPath('/drive/root:/$path/$my_file:/content');

       return $api->makeRequest();
  }

   public function downloadFile($filename) {
      $file_path = fopen($filename, "w+");
      
      $api = new OneDriveCurl;
      $api->setAccessToken($this->accessToken);
      $api->setBaseURL(self::API_URL);
      $api->setOption(CURLOPT_FILE, $file_path);
      $api->setPath("/drive/items/$filename/content");

      return $api->makeRequest();      
   }
}
?>