<?php

	namespace Higimo\PickPoint;

	use InvalidArgumentException;
	use Exception;

	/**
	 * Помогает работать с Пикпоинтом
	 */
	class PickPoint {

		/**
		 * Максимальный вес посылки вместе с коробкой
		 */
		const MAX_BRUTTO = 15000;

		/**
		 * Флаг тестового режима
		 *
		 * @var boolean Флаг тестового режима
		 */
		private $isTest = true;

		/**
		 * Текущая сессия
		 *
		 * @var null Текущая сессия
		 */
		private $session = null;

		/**
		 * Создает экземпляр класса PickPoint
		 *
		 * @param boolean $isTest Флаг тестового режима
		 */
		public function __construct($isTest = true) {
			$this->isTest = $isTest;
		}

		/**
		 * Возвращает URL API
		 *
		 * @return string URL API
		 */
		public function getUrl() {
			if ($this->isTest) {
				return 'https://e-solution.pickpoint.ru/apitest/';
			} else {
				return 'https://e-solution.pickpoint.ru/api/';
			}
		}

		/**
		 * Возвращает логин
		 *
		 * @return string Логин
		 */
		public function getLogin() {
			return 'apitest';
		}

		/**
		 * Возвращает пароль
		 *
		 * @return string Пароль
		 */
		public function getPassword() {
			return 'apitest';
		}

		/**
		 * Возвращает номер ИКН
		 *
		 * @return string Номер ИКН
		 */
		public function getIkn() {
			return '9990003041';
		}

		/**
		 * Возвращает сессию
		 *
		 * @return string Сессию
		 */
		public function getSession() {
			return $this->session;
		}

		/**
		 * Производит авторизацию, используя API
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @return PickPoint Указатель на этот экземляр объекта
		 */
		public function login() {
			$curl = new CurlWrapper($this->getUrl() . 'login', [
				'Login'    => $this->getLogin(),
				'Password' => $this->getPassword(),
			]);
			$curl->send();
			if ($curl->getStatus() === 200 && $curl->getError() === 0) {
				$response = $curl->getResponse();
				$this->session = $response['SessionId'];
			}
			return $this;
		}

		/**
		 * Завершает сессию, используя API
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @return PickPoint Указатель на этот экземляр объекта
		 */
		public function logout() {
			$curl = new CurlWrapper($this->getUrl() . 'logout', [
				'SessionId' => $this->getSession(),
			]);
			$curl->send();
			if ($curl->getStatus() === 200 && $curl->getError() === 0) {
				$response = $curl->getResponse();
				$this->session = $response['SessionId'];
			}
			return $this;
		}

		/**
		 * Возвращает идентификатор зоны доставки по названию города
		 *
		 * @param  string  $cityName Название города
		 * @return integer           Идентификатор зоны доставки
		 */
		public function getZoneByCityName($cityName = '') {
		}

		/**
		 * Возвращает множитель зоны доставки по её идентификатору
		 *
		 * @param  integer $zoneId Идентификатор зоны доставки
		 * @return integer         Множитель зоны доставки по её идентификатору
		 */
		public function getRatioByZoneId($zoneId = 0) {
			// TODO: Обернуть в .ini
			$ratio = [
				-1 => 1,
				1 => 8,
				2 => 11.7,
				3 => 19.5,
				4 => 34.2,
				5 => 46.8,
				6 => 87.1,
				7 => 162,
				8 => 185,
				9 => 270,
			];
			return $ratio[$zoneId];
		}

		/**
		 * Возвращает диапозон времени доставки по идентификатору зоны
		 *
		 * @param  integer $zoneId Идентификатор зоны доставки
		 * @return string          Диапозон времени доставки по идентификатору зоны
		 */
		public function getLagByZoneId($zoneId = 0) {
			// TODO: Обернуть в .ini
			$deliveryLag = [
				-1 => '1 день',
				0  => '1&#150;2 дня',
				1  => '2&#150;3 дня',
				2  => '2&#150;4 дня',
				3  => '3&#150;5 дней',
				4  => '3&#150;6 дней',
				5  => '3&#150;7 дней',
				6  => '3&#150;8 дней',
				7  => '3&#150;9 дней',
				8  => '4&#150;11 дней',
			];

			return $deliveryLag[$zoneId];
		}

		/**
		 * Производит регистрацию отправления, используя API
		 *
		 * — sendId — уникальный номер заказа. Можно с постфиксом номер заказа указать
		 * — orderNumber — номер заказа
		 * — userName — имя покупателя
		 * — pastamatNumber — номер постамата, например, 5001-019
		 * — userPhone — номер телефона покупателя '+79019019090'
		 * — userEmail — адрес электронной почты покупателя
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @param  array     $packageParam Параметры посылки
		 * @return PickPoint               Указатель на этот экземляр объекта
		 */
		public function send($packageParam = []) {
			if (empty($packageParam)) {
				throw new InvalidArgumentException('Параметры посылки не переданы', 1);
			}

			$packageParam = [
				'SessionId'              => $this->getSession(),
				'Sendings'               => [
					[
						'EDTN'                   => $packageParam['sendId'],
						'IKN'                    => $this->getIkn(),
						'Invoice'                => [
							'SenderCode'             => $packageParam['orderNumber'],
							'BarCode'                => '',
							'Description'            => '',
							'RecipientName'          => $packageParam['userName'],
							'PostamatNumber'         => $packageParam['pastamatNumber'],
							'MobilePhone'            => $packageParam['userPhone'],
							'Email'                  => $packageParam['userEmail'],
							'PostageType'            => '10001',
							'GettingType'            => '102',
							'PayType'                => '1',
							'Sum'                    => '0.00',
							'InsuareValue'           => '1.00',
							'Width'                  => '0',
							'Height'                 => '0',
							'Depth'                  => '0',
						]
					]
				]
			];

			$curl = new CurlWrapper($this->getUrl() . 'createsending', $packageParam);
			$curl->send();
			if ($curl->getStatus() === 200 && $curl->getError() === 0) {
				$response = $curl->getResponse();
				if (empty($response['RejectedSendings'])) {
					$result = current($response['CreatedSendings']);
					return [
						'edtn'    => $result['EDTN'],
						'invoice' => $result['InvoiceNumber'],
						'barcode' => $result['Barcode'],
						'places'  => $result['Places'],
					];
				} else {
					$result = current($response['RejectedSendings']);
					throw new Exception('Ошибка в ответе пикпоинта: ' . $result['ErrorMessage'], 1);
				}
			}
			return $this;
		}

		/**
		 * Возвращает стоимость доставки, используя API
		 *
		 * — city — название города отправления
		 * — region — область отправления (Воронежская, Нижегородская)
		 * — postamatId — номер постамата, например, 5001-019
		 * — length — длина посылки
		 * — depth — высота посылки
		 * — width — ширина посылки
		 *
		 * Возвращает указатель на этот же объект, для создания цепочек вызова
		 *
		 * @param  array     $packageParam Параметры посылки
		 * @return PickPoint               Указатель на этот экземляр объекта
		 */
		public function getPrice($packageParam = []) {
			$packageParam = [
				'SessionId'     => $this->getSession(),
				'IKN'           => $this->getIkn(),
				'FromCity'      => ($packageParam['city']       ? $packageParam['city']       : 'Воронеж'),
				'FromRegion'    => ($packageParam['region']     ? $packageParam['region']     : 'Воронежская обл.'),
				'PTNumber'      => ($packageParam['postamatId'] ? $packageParam['postamatId'] : '5001-019'),
				'Length'        => ($packageParam['length']     ? $packageParam['length']     : 10),
				'Depth'         => ($packageParam['depth']      ? $packageParam['depth']      : 10),
				'Width'         => ($packageParam['width']      ? $packageParam['width']      : 10),
			];
			$curl = new CurlWrapper($this->getUrl() . 'calctariff', $packageParam);
			$curl->send();

			if ($curl->getStatus() === 200 && $curl->getError() === 0) {
				$response = $curl->getResponse();
				return $response;
			} else {
				throw new Exception('Ошибка при запросе к пикпоинту', 1);
			}
			return $this;
		}
	}
