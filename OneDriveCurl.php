<?php

class OneDriveCurl 
{

    protected $baseURL = null;

    protected $path    = null;

    protected $handler = null;

    protected $options = array();

    protected $headers = array('User-Agent' => 'All-in-One WP Migration');

    public function __construct()
    {
        if (!extension_loaded('curl')) {
            throw new Exception("OneDrive factory requires cURL extension");
        }

        // Default configuration
        $this->setOption(CURLOPT_RETURNTRANSFER, true);

        // Enable SSL support
        $this->setOption(CURLOPT_SSL_VERIFYPEER, false);
        //$this->setOption(CURLOPT_SSL_VERIFYHOST, 2);
        //$this->setOption(CURLOPT_SSLVERSION, 1);
        //$this->setOption(CURLOPT_CAINFO, __DIR__ . '/../certs/trusted-certs.crt');
        //$this->setOption(CURLOPT_CAPATH, __DIR__ . '/../certs/');
    }	

    /**
     * Set access token
     *
     * @param  string      $value Resouse path
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
     * Set cURL base URL
     *
     * @param string $value Base URL
     * @return OneDriveCurl
     */
    public function setBaseUrl($value) {
        $this->baseURL = $value;
        return $this;
    }

    /**
     * Get cURL base URL
     *
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseURL;
    }  

    /**
     * Set cURL path
     *
     * @param string $value Resource path
     * @return OneDriveCurl
     */
    public function setPath($value) {
        $this->path = $value;
        return $this;
    }

    /**
     * Get cURL path
     *
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * set cURL option
     *
     * @param int    $name  cURL option name
     * @param mixed  $value cURL option value
     * @return OneDriveCurl
     */
    public function setOption($name, $value){
        $this->options[$name] = $value;
    }

    /**
     * Get cURL option
     *
     * @param int  $name cURL option name
     * @return mixed
     */
    public function getOption($name){
        return $this->options[$name];
    }   
    
    /**
     * Set cURL header
     *
     * @param string  $name cURL header name
     * @param string  $value cURL header value
     * @return OneDriveCurl
     */
    public function setHeader($name, $value){
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Get cURL header
     *
     * @param string $name cURL header name
     * @return string
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
        $this->handler = curl_init($this->getBaseUrl() . $this->getPath());

		// Apply cURL headers
		$httpHeaders = array();
		foreach ($this->headers as $name => $value) {
			$httpHeaders[] = "$name: $value";
		}

		// Set headers
		$this->setOption(CURLOPT_HTTPHEADER, $httpHeaders);		

		// Apply cURL options
		foreach ($this->options as $name => $value) {
			curl_setopt($this->handler, $name, $value);
		}	

        $response = curl_exec($this->handler);
        if ($response === false) {
            throw new Exception('Error executing HTTP request: ' . curl_error($this->handle));
        }

        return json_decode($response, true);
    }

    /**
     * Destroy cURL handler
     *
     * @return void
     */

    public function __destruct()
    {
        if ($this->handler !== null) {
            curl_close($this->handler);
        }
    }                       
}