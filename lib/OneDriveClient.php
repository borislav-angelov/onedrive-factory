<?php

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'OneDriveCurl.php';

class OneDriveClient
{
	const API_URL    = "https://api.onedrive.com/v1.0";

	const CHUNK_SIZE = 4194304; // 4 MB

	/**
	 * OAuth Refresh Token
	 *
	 * @var string
	 */
	protected $refreshToken = null;

	/**
	 * SSL Mode
	 *
	 * @var boolean
	 */
	protected $ssl = null;

	/**
	 * File out stream
	 *
	 * @var resource
	 */
	protected $outStream = null;

	public function __construct($accessToken, $ssl = true) {
		$this->accessToken = $accessToken;
		$this->ssl = $ssl;
	}

	/**
	 * List root drive
	 *
	 * @return array
	 */
	public function listDrive() {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL(self::API_URL);
		$api->setPath('/drive/root/children');

		return $api->makeRequest();
	}

	/**
	 * List specific folder
	 *
	 * @param  string $path Path
	 * @return array
	 */
	public function listFolder($path) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/{$path}");

		return $api->makeRequest();
	}

	/**
	 * Create folder (in root)
	 *
	 * @param  string $name Name
	 * @return array
	 */
	public function createFolder($name) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
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

	/**
	 * Download file
	 *
	 * @param  resource $outStream File stream
	 * @param  string   $pathname  File path
	 * @return array
	 */
	public function downloadFile($outStream, $pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL(self::API_URL);
		$api->setOption(CURLOPT_FILE, $outStream);
		$api->setPath("/drive/root:/{$pathname}:/content");

		return $api->makeRequest();
	}

	/**
	 * Download file chunk
	 *
	 * @param  string   $pathname  File path
	 * @param  resource $outStream File stream
	 * @param  array    $params    File parameters
	 * @return array
	 */
	public function downloadFileChunk($pathname, $outStream, $params = array()) {
		$this->outStream = $outStream;

		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/{$pathname}:/content");
		$api->setOption(CURLOPT_WRITEFUNCTION, array($this, 'curlWriteFunction'));

		// Partial download
		if (isset($params['size']) && isset($params['startBytes']) && isset($params['endBytes'])) {
			$api->setHeader('Content-Range', "bytes={$params['startBytes']}-{$params['endBytes']}");

			if ($params['size'] < ($params['startBytes'] + self::CHUNK_SIZE)) {
				$params['startBytes'] = $params['size'];
			} else {
				$params['startBytes'] = $params['endBytes'] + 1;
			}

			if ($params['size'] < ($params['endBytes'] + self::CHUNK_SIZE)) {
				$params['endBytes'] = $params['size'];
			} else {
				$params['endBytes'] += self::CHUNK_SIZE;
			}
		}

		return $api->makeRequest();
	}

	/**
	 * Curl write function callback
	 *
	 * @param  resource $ch   Curl handler
	 * @param  string   $data Curl data
	 * @return integer
	 */
	public function curlWriteFunction($ch, $data) {
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($status !== 200 && ($response = json_decode($data, true))) {
			throw new Exception($response['error'], $status);
		}

		// Write data to stream
		fwrite($this->outStream, $data);

		return strlen($data);
	}

	/**
	 * Upload file
	 *
	 * @param  resource $inStream File stream
	 * @param  integer  $inSize   File size
	 * @param  string   $pathname Path name
	 * @return array
	 */
	public function uploadFile($inStream, $inSize, $pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL(self::API_URL);
		$api->setOption(CURLOPT_PUT, true);
		$api->setOption(CURLOPT_INFILE, $inStream);
		$api->setOption(CURLOPT_INFILESIZE, $inSize);
		$api->setPath("/drive/root:/{$pathname}:/content");

		return $api->makeRequest();
	}

	/**
	 * Create upload session
	 *
	 * @param  string $pathname Path name
	 * @return array
	 */
	public function uploadResumable($pathname) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL(self::API_URL);
		$api->setPath("/drive/root:/{$pathname}:/upload.createSession");
		$api->setHeader('Content-Length', 0);
		$api->setOption(CURLOPT_POST, true);

		return $api->makeRequest();
	}


	/**
	 * Upload file chunk
	 *
	 * @param  string $chunk  File data
	 * @param  array  $params File parameters
	 * @return array
	 */
	public function uploadFileChunk($chunk, $params = array()) {
		$api = new OneDriveCurl;
		$api->setAccessToken($this->accessToken);
		$api->setSSL($this->ssl);
		$api->setBaseURL($params['uploadUrl']);
		$api->setOption(CURLOPT_CUSTOMREQUEST, 'PUT');

		// Upload file chunk
		$api->setHeader('Content-Length', $params['endBytes'] - $params['startBytes'] + 1);
		$api->setHeader('Content-Range', "bytes {$params['startBytes']}-{$params['endBytes']}/{$params['totalBytes']}");
		$api->setOption(CURLOPT_POSTFIELDS, $chunk);

		return $api->makeRequest();
	}
}
