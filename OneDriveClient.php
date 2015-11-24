<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveCurl.php';

class OneDriveClient
{
	const API_URL 		= "https://api.onedrive.com/v1.0";

	const CHUNK_SIZE 	= 4194304; // 4 MB

	protected $accessToken = null;

	public function __construct($accessToken) {
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
		$api->setPath("/drive/root:/{$path}");

		return $api->makeRequest();
	}

	public function createFolder($name) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath('/drive/root/children');
		$api->setHeader('Content-Type', 'application/json');
		$api->setOption(CURLOPT_POST, true);
		$api->setOption(CURLOPT_POSTFIELDS, json_encode(array(
			'name'   => $name,
			'folder' => (object) array(),
		)));

		return $api->makeRequest();
	}

	public function uploadFile($inStream, $inSize, $pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setHeader('Content-Type', 'text/plain');
		$api->setOption(CURLOPT_PUT, true);
		$api->setOption(CURLOPT_INFILE, $inStream);
		$api->setOption(CURLOPT_INFILESIZE, $inSize);
		$api->setPath("/drive/root:/{$pathname}:/content");

		return $api->makeRequest();
	}

	public function downloadFile($outStream, $pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setOption(CURLOPT_FILE, $outStream);
		$api->setPath("/drive/root:/{$pathname}:/content");

		return $api->makeRequest();
	}

	public function downloadFileChunks($path, $fileStream, $params = array()) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/$path:/content");
		$api->setOption(CURLOPT_WRITEFUNCTION, function($ch, $data) use ($fileStream) {
			$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($status !== 200 && ($response = json_decode($data, true))) {
				throw new Exception($response['error'], $status);
			}

		fwrite($fileStream, $data);

		return strlen($data);
	});

		if(isset($params['size']) && isset($params['startBytes']) && isset($params['endBytes'])) {
			$api->setHeader('Content-Range', "bytes={$params['startBytes']}-{$params['endBytes']}");

			if($params['size'] < ($params['startBytes'] + self::CHUNK_SIZE)) {
				$params['startBytes'] = $params['size'];
			} else {
				$params['startBytes'] = $params['endBytes'] + 1;
			}

			if($params['size'] < ($params['endBytes'] + self::CHUNK_SIZE)) {
				$params['endBytes'] = $params['size'];
			} else {
				$params['endBytes'] += self::CHUNK_SIZE;
			}
		}

		return $api->makeRequest();

		return $params;
	}

	public function uploadFileChunk($path, $data, $params = array()) {
		$splittedPath = explode('/', $path);
		$splittedParams = count($splittedPath);
		$itemName = $splittedPath[$splittedParams - 1];

		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/$path:/upload.createSession");
		$api->setHeader('Content-Type', 'application/json');
		$api->setOption(CURLOPT_POST, true);
		$api->setOption(CURLOPT_POSTFIELDS, json_encode(array(
			'item' => array(
				'name' => $itemName
				))));

		$result = $api->makeRequest();
		$uploadUrl = $result['uploadUrl'];

		$api->setPath($uploadUrl);
		$api->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');
		$api->setHeader('Content-Length', $params['size']);
		$api->setHeader('Content-Range', 'bytes 0-' . self::CHUNK_SIZE . '/' . $params['size']);
		$api->setOption(CURLOPT_FILE, $fileToStore);

		$api->makeRequest();
	}

}
