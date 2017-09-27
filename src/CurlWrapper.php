<?php

	namespace Higimo\PickPoint;

	/**
	 * Обёртка над curl
	 *
	 * TODO: Вероятно, стоит воспользоваться php-curl-class/php-curl-class
	 */
	class CurlWrapper {

		/**
		 * URL назначения запроса
		 *
		 * @var string URL назначения запроса
		 */
		private $url = '';

		/**
		 * Используемый метод передачи данных
		 *
		 * @var string Используемый метод передачи данных
		 */
		private $method = 'POST';

		/**
		 * Таймаут запроса
		 *
		 * @var integer Таймаут запроса
		 */
		private $timeout = 30;

		/**
		 * Данные, которые передаются по URL
		 *
		 * @var array Данные, которые передаются по URL
		 */
		private $options = [];

		/**
		 * Результат запроса
		 *
		 * @var null Результат запроса
		 */
		private $response = null;

		/**
		 * Код статуса выполненного запроса
		 *
		 * @var null Код статуса выполненного запроса
		 */
		private $status = null;

		/**
		 * Код ошибки запроса
		 *
		 * @var null Код ошибки запроса
		 */
		private $error = null;

		/**
		 * Конструктор класса, выбрасывает исключение, если не указан URL
		 *
		 * @param string $url     description
		 * @param array  $options description
		 */
		function __construct($url, $options = []) {
			if (strlen($url) < 5) {
				throw new \InvalidArgumentException('Не указан URL', 1);
			}
			$this->url = $url;
			$this->options = $options;
		}

		/**
		 * Устанавливает результат запроса
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @param  string      $response Результат запроса
		 * @return CurlWrapper           Указатель на этот экземляр объекта
		 */
		public function setResponse($response) {
			$this->response = $response;
			return $this;
		}

		/**
		 * Устанавливает код статуса выполненного запроса
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @param  integer     $status Код статуса выполненного запроса
		 * @return CurlWrapper         Указатель на этот экземляр объекта
		 */
		public function setStatus($status) {
			$this->status = $status;
			return $this;
		}

		/**
		 * Устанавливает код ошибки запроса
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @param  integer     $error Код ошибки запроса
		 * @return CurlWrapper        Указатель на этот экземляр объекта
		 */
		public function setError($error) {
			$this->error = $error;
			return $this;
		}

		/**
		 * Возвращает результат запроса
		 *
		 * @return string Результат запроса
		 */
		public function getResponse() {
			return $this->response;
		}

		/**
		 * Возвращает код статуса выполненного запроса
		 *
		 * @return integer Код статуса выполненного запроса
		 */
		public function getStatus() {
			return $this->status;
		}

		/**
		 * Возвращает код ошибки запроса
		 *
		 * @return integer Код ошибки запроса
		 */
		public function getError() {
			return $this->error;
		}

		/**
		 * Выполняет запрос на URL, хранимый в объекте
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @return CurlWrapper Указатель на этот экземляр объекта
		 */
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
