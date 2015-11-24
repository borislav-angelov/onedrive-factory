<?php

class OneDriveCurl
{
	protected $baseURL = null;

	protected $path    = null;

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
		$this->setOption(CURLOPT_SSL_VERIFYPEER, false);
	}

	public function setAccessToken($value) {
		$this->setHeader('Authorization', "Bearer $value");
		return $this;
	}

	public function getAccessToken() {
		return $this->getHeader('Authorization');
	}

	public function setBaseUrl($value) {
		$this->baseURL = $value;
		return $this;
	}

	public function getBaseUrl() {
		return $this->baseURL;
	}

	public function setPath($value) {
		$this->path = $value;
		return $this;
	}

	public function getPath() {
		return $this->path;
	}

	public function setOption($name, $value){
		$this->options[$name] = $value;
	}

	public function getOption($name){
		return $this->options[$name];
	}

	public function setHeader($name, $value){
		$this->headers[$name] = $value;
		return $this;
	}

	public function getHeader($name) {
		return $this->headers[$name];
	}

	public function makeRequest() {
		$this->handler = curl_init($this->getBaseUrl() . $this->getPath());
		$httpHeaders = array();

		foreach ($this->headers as $name => $value) {
			$httpHeaders[] = "$name: $value";
		}

		// Apply cURL headers

		$this->setOption(CURLOPT_HTTPHEADER, $httpHeaders);

		// Apply cURL options

		foreach ($this->options as $name => $value) {
			curl_setopt($this->handler, $name, $value);
		}

		$response = curl_exec($this->handler);

		var_dump($response);

		if ($response === false) {
			throw new Exception('Error executing HTTP request: ' . curl_error($this->handler));
		}

		return json_decode($response, true);
	}

	public function __destruct() {
		if ($this->handler !== null) {
			curl_close($this->handler);
		}
	}
}