<?php

class OneDriveCurl
{
	protected $baseURL = null;

	protected $path    = null;

	protected $ssl     = true;

	protected $handler = null;

	protected $options = array();

	protected $headers = array('User-Agent' => 'All-in-One WP Migration');

	public function __construct() {
		if (!extension_loaded('curl')) {
			throw new Exception("OneDrive factory requires cURL extension");
		}

		// Default configuration
		$this->setOption(CURLOPT_HEADER, false);
		$this->setOption(CURLOPT_RETURNTRANSFER, true);
		$this->setOption(CURLOPT_FOLLOWLOCATION, true);
		$this->setOption(CURLOPT_CONNECTTIMEOUT, 30);

		// Enable SSL support
		$this->setOption(CURLOPT_SSL_VERIFYPEER, true);
		$this->setOption(CURLOPT_CAINFO, __DIR__ . '/../certs/cacert.pem');
		$this->setOption(CURLOPT_CAPATH, __DIR__ . '/../certs/');
	}

	/**
	 * Set access token
	 *
	 * @param  string       $value Access token
	 * @return OneDriveCurl
	 */
	public function setAccessToken($value) {
		$this->setHeader('Authorization', "Bearer $value");
		return $this;
	}

	/**
	 * Get access token
	 *
	 * @return string
	 */
	public function getAccessToken() {
		return $this->getHeader('Authorization');
	}

	/**
	 * Set SSL mode
	 *
	 * @param  boolean      $value SSL Mode
	 * @return OneDriveCurl
	 */
	public function setSSL($value) {
		$this->ssl = $value;
		return $this;
	}

	/**
	 * Get SSL Mode
	 *
	 * @return boolean
	 */
	public function getSSL() {
		return $this->ssl;
	}

	/**
	 * Set base URL
	 *
	 * @param  string       $value Base URL
	 * @return OneDriveCurl
	 */
	public function setBaseUrl($value) {
		$this->baseURL = $value;
		return $this;
	}

	/**
	 * Get base URL
	 *
	 * @return string
	 */
	public function getBaseUrl() {
		return $this->baseURL;
	}

	/**
	 * Set path
	 *
	 * @param  string       $value Path
	 * @return OneDriveCurl
	 */
	public function setPath($value) {
		$this->path = $value;
		return $this;
	}

	/**
	 * Get path
	 *
	 * @return OneDriveCurl
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * Set cURL option
	 *
	 * @param  mixed        $name  cURL option name
	 * @param  mixed        $value cURL option value
	 * @return OneDriveCurl
	 */
	public function setOption($name, $value){
		$this->options[$name] = $value;
		return $this;
	}

	/**
	 * Get cURL option
	 *
	 * @param  mixed $name cURL option name
	 * @return mixed
	 */
	public function getOption($name){
		return $this->options[$name];
	}

	/**
	 * Set cURL header
	 *
	 * @param  mixed        $name  cURL header name
	 * @param  mixed        $value cURL header value
	 * @return OneDriveCurl
	 */
	public function setHeader($name, $value){
		$this->headers[$name] = $value;
		return $this;
	}

	/**
	 * Get cURL header
	 *
	 * @param  mixed $name cURL header name
	 * @return mixed
	 */
	public function getHeader($name) {
		return $this->headers[$name];
	}

	/**
	 * Make cURL request
	 *
	 * @return array
	 */
	public function makeRequest() {

		// cURL handler
		$this->handler = curl_init($this->getBaseUrl() . $this->getPath());

		// Apply cURL headers
		$httpHeaders = array();
		foreach ($this->headers as $name => $value) {
			$httpHeaders[] = "$name: $value";
		}

		// Set headers
		$this->setOption(CURLOPT_HTTPHEADER, $httpHeaders);

		// SSL verify peer
		$this->setOption(CURLOPT_SSL_VERIFYPEER, $this->getSSL());

		// Apply cURL options
		foreach ($this->options as $name => $value) {
			curl_setopt($this->handler, $name, $value);
		}

		// HTTP request
		$response = curl_exec($this->handler);
		if ($response === false) {
			throw new Exception('Error executing HTTP request: ' . curl_error($this->handler));
		}

		return json_decode($response, true);
	}

	/**
	 * Destroy cURL handler
	 *
	 * @return void
	 */
	public function __destruct() {
		if ($this->handler !== null) {
			curl_close($this->handler);
		}
	}
}
