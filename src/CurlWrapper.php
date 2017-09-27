<?php

	class CurlWrapper {

		private $url      = '';
		private $method   = 'POST';
		private $timeout  = 30;
		private $options  = [];
		private $response = null;
		private $status   = null;
		private $error    = null;

		function __construct($url, $options = []) {
			if (strlen($url) < 5) {
				throw new \InvalidArgumentException('Не указан URL', 1);
			}
			$this->url = $url;
			$this->options = $options;
		}

		public function setResponse($response) {
			$this->response = $response;
		}
		public function setStatus($status) {
			$this->status = $status;
		}
		public function setError($error) {
			$this->error = $error;
		}

		public function getResponse() {
			return $this->response;
		}
		public function getStatus() {
			return $this->status;
		}
		public function getError() {
			return $this->error;
		}

		public function send() {
			$curl = curl_init($this->url);
			$jsonData = json_encode($this->options);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST,  $this->method);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
			curl_setopt($curl, CURLOPT_HEADER,         0);
			curl_setopt($curl, CURLOPT_POSTFIELDS,     $jsonData);
			curl_setopt($curl, CURLOPT_HTTPHEADER,     [
				'Content-Type:application/json',
				'Content-Length:' . strlen($jsonData)
			]);

			$this->setResponse(curl_exec($curl));
			$this->setStatus(curl_getinfo($curl, CURLINFO_HTTP_CODE));
			$this->setError(curl_errno($curl));

			return $this;
		}

	}
