<?php

	namespace Higimo\PickPoint;

	/**
	 * Статический класс для работы с доставкой через Пикпоинт
	 */
	class PickPoint {

		private $test = false;

		function __construct($test = false) {
			$this->test = $test;
		}

		/**
		 * Возвращает зону для указанного города
		 *
		 * @api
		 * @param  string  $cityname Название города
		 * @return integer           Зона доставки для указанного города
		 */
		public function getZone($cityname = '') {
			require __DIR__ . '/../vendor/autoload.php';

			$data = new PickPointData();

			$postamatData = $data->getPostamatByCityName($cityname);

			return $filtredCity[0]['zone'];
		}

		/**
		 * Адрес тестового API сервиса
		//  */
		// const TEST_URL        = 'https://e-solution.pickpoint.ru/apitest/';

		// /**
		//  * Адрес боевого API сервиса
		//  */
		// const WORK_URL        = 'https://e-solution.pickpoint.ru/api/';

		// /**
		//  * Время ожидания отклика от сервиса
		//  */
		// const CONNECT_TIMEOUT = 60;

		// /**
		//  * Метод для запросов к API
		//  */
		// const METHOD          = 'POST';

		// /**
		//  * Максимальный брутто (грязный) вес посылки
		//  */
		// const MAX_BRUTTO      = 15000;

		// /**
		//  * Текущая сессия
		//  *
		//  * @var null
		//  */
		// public static $session = null;

		// /**
		//  * Указывает используется ли тестовая версия API
		//  *
		//  * @api
		//  * @static
		//  * @return boolean Используется ли тестовая версия API
		//  */
		// public static function isTest() {
		// 	return defined('ALS_TEST_PICKPOINT') && ALS_TEST_PICKPOINT === true;
		// }

		// /**
		//  * Возвращает ссылку на обработчик
		//  *
		//  * @api
		//  * @static
		//  * @return string Ссылка на обработчик
		//  */
		// public static function getApiUri() {
		// 	if (self::isTest()) {
		// 		return self::TEST_URL;
		// 	} else {
		// 		return self::WORK_URL;
		// 	}
		// }

		// /**
		//  * Возвращает используемые логин, учитывает тест-режим
		//  *
		//  * @api
		//  * @static
		//  * @return string Используемый логин для текущего режима
		//  */
		// public static function getLogin() {
		// 	return self::isTest()
		// 		? (defined('ALS_PICKPOINT_LOGIN_TEST') ? ALS_PICKPOINT_LOGIN_TEST : '')
		// 		: (defined('ALS_PICKPOINT_LOGIN')      ? ALS_PICKPOINT_LOGIN      : '');
		// }

		// /**
		//  * Возвращает используемый пароль, учитывает тест-режим
		//  *
		//  * @api
		//  * @static
		//  * @return string Используемый пароль для текущего режима
		//  */
		// public static function getPassword() {
		// 	return self::isTest()
		// 		? (defined('ALS_PICKPOINT_PASSWORD_TEST') ? ALS_PICKPOINT_PASSWORD_TEST : '')
		// 		: (defined('ALS_PICKPOINT_PASSWORD')      ? ALS_PICKPOINT_PASSWORD      : '');
		// }

		// /**
		//  * Возвращает используемый ИКН, учитывает тест-режим
		//  *
		//  * @api
		//  * @static
		//  * @return string Используемый ИКН для текущего режима
		//  */
		// public static function getIkn() {
		// 	return self::isTest()
		// 		? (defined('ALS_PICKPOINT_IKN_TEST') ? ALS_PICKPOINT_IKN_TEST : '')
		// 		: (defined('ALS_PICKPOINT_IKN')      ? ALS_PICKPOINT_IKN      : '');
		// }

		// /**
		//  * Возвращает коэффициент, согласно идентификатору зоны
		//  *
		//  * @api
		//  * @static
		//  * @param  integer $zone Идентификатор зоны
		//  * @return float         Используемый, для этой зоны, коэффициент
		//  */
		// public static function getRationPerZone($zone = 0) {
		// 	$ratio = [
		// 		-1 => 1,
		// 		1 => 8,
		// 		2 => 11.7,
		// 		3 => 19.5,
		// 		4 => 34.2,
		// 		5 => 46.8,
		// 		6 => 87.1,
		// 		7 => 162,
		// 		8 => 185,
		// 		9 => 270,
		// 	];
		// 	return $ratio[$zone];
		// }

		// /**
		//  * Возвращает задержку в доставке, согласно зоне
		//  *
		//  * @api
		//  * @static
		//  * @param  integer $zone Зона доставки
		//  * @return string        Задержка для указанной зоны
		//  */
		// public static function getDeliveryLagPerZone($zone = 0) {
		// 	$deliveryLag = [
		// 		-1 => '1 день',
		// 		0  => '1&#150;2 дня',
		// 		1  => '2&#150;3 дня',
		// 		2  => '2&#150;4 дня',
		// 		3  => '3&#150;5 дней',
		// 		4  => '3&#150;6 дней',
		// 		5  => '3&#150;7 дней',
		// 		6  => '3&#150;8 дней',
		// 		7  => '3&#150;9 дней',
		// 		8  => '4&#150;11 дней',
		// 	];

		// 	return $deliveryLag[$zone];
		// }

		// /**
		//  * Высчитает общую массу товара
		//  *
		//  * @api
		//  * @static
		//  * @param  array      $productList Список товаров
		//  * @return integer                 Общий вес товара
		//  * @throws \Exception
		//  */
		// public static function calculateWeightByProductList($productList = []) {
		// 	$result = 0;

		// 	foreach ($productList as $product) {
		// 		$result += $product['count'] * $product['brutto'];

		// 	}

		// 	if ($result >= self::MAX_BRUTTO) {
		// 		throw new \Exception('Слишком тяжёлая покупка', 1);
		// 	}

		// 	if ($result < 1000) {
		// 		$result = 1000;
		// 	}

		// 	return $result;
		// }

		// /**
		//  * Возвращает точное количество банок в списке
		//  *
		//  * @api
		//  * @static
		//  * @param  array   $productList Список товаров
		//  * @return integer              Количество банок в списке
		//  */
		// public static function getProductCount($productList) {
		// 	$result = 0;

		// 	foreach ($productList as $product) {
		// 		if ($product['coverCode'] === 'JAR') {
		// 			$result += $product['count'];
		// 		}
		// 		if ($product['coverCode'] === 'BOX') {
		// 			$result += $product['count'] * 6;
		// 		}
		// 	}

		// 	return $result;
		// }

		// /**
		//  * Вычисляет тариф через формулу, без запросов к API
		//  *
		//  * @api
		//  * @static
		//  * @param  string     $cityName    Название города, в который необходимо доставить
		//  * @param  array      $productList Список товаров
		//  * @return float                   Стоимость доставки
		//  * @throws \Exception
		//  */
		// public static function calculate($cityName, $productList) {
		// 	if (is_numeric($cityName)) {
		// 		$cityName = City::getNameById(intval($cityName));
		// 	}

		// 	$containerPrice = self::getProductCount($productList) <= 12 ? 184 : 213; // S || XS контейнер
		// 	$zonePrice      = self::getRationPerZone(self::getZone($cityName));
		// 	$weight         = self::calculateWeightByProductList($productList);

		// 	return round((($zonePrice * ceil($weight / 1000)) + $containerPrice) * 1.18);
		// }

		// /**
		//  * Делает запрос к API
		//  *
		//  * @api
		//  * @static
		//  * @param  string   $url      URI на который будет послан запрос
		//  * @param  array    $data     Массив данных, которые будут посланы в запросе
		//  * @param  callback $callback Функция-обработчик, работающая с ответом на запрос
		//  * @return array              Массив [ответ на запрос; код статуса ответа (int 200 при удаче); код ошибки (int 0 при удаче)]
		//  */
		// public static function post($url, $data, $callback) {
		// 	$curl = curl_init(self::getApiUri() . $url);

		// 	$jsonData = json_encode($data);

		// 	curl_setopt($curl , CURLOPT_CUSTOMREQUEST  , self::METHOD);
		// 	curl_setopt($curl , CURLOPT_RETURNTRANSFER , true);
		// 	curl_setopt($curl , CURLOPT_CONNECTTIMEOUT , self::CONNECT_TIMEOUT);
		// 	curl_setopt($curl , CURLOPT_HEADER         , 0);
		// 	curl_setopt($curl , CURLOPT_POSTFIELDS     , $jsonData);
		// 	curl_setopt($curl , CURLOPT_HTTPHEADER     , [
		// 		'Content-Type:application/json',
		// 		'Content-Length:' . strlen($jsonData)
		// 	]);

		// 	$response = json_decode(curl_exec($curl), true);
		// 	$error    = curl_errno($curl);
		// 	$status   = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		// 	if (!is_null($callback)) {
		// 		$callback($response, $status, $error);
		// 	}

		// 	curl_close($curl);

		// 	return [$response, $status, $error];
		// }

		// /**
		//  * Авторизуется
		//  *
		//  * @api
		//  * @static
		//  * @throws \Exception Ошибка в ответе пикпоинта
		//  * @throws \Exception Ошибка при запросе к пикпоинту
		//  */
		// public static function login() {
		// 	list($response, $status, $error) = self::post(
		// 		'/login',
		// 		[
		// 			'Login'    => self::getLogin(),
		// 			'Password' => self::getPassword(),
		// 		],
		// 		null
		// 	);

		// 	if ($status === 200 && $error === 0) {
		// 		if (is_null($response['ErrorMessage'])) {
		// 			self::$session = $response['SessionId'];
		// 		} else {
		// 			throw new \Exception('Ошибка в ответе пикпоинта: ' . $response['ErrorMessage'], 1);
		// 		}
		// 	} else {
		// 		$errorText = sprintf('Status: %s; Error: %s', $status, $error);
		// 		throw new \Exception('Ошибка при запросе к пикпоинту: ' . $errorText, 1);
		// 	}
		// }

		// /**
		//  * Выходит из авторизации
		//  *
		//  * @api
		//  * @static
		//  * @throws \Exception Ошибка в ответе пикпоинта
		//  * @throws \Exception Ошибка при запросе к пикпоинту
		//  */
		// public static function logout() {
		// 	list($response, $status, $error) = self::post(
		// 		'/logout',
		// 		[
		// 			'SessionId' => self::$session,
		// 		],
		// 		null
		// 	);

		// 	if ($status === 200 && $error === 0) {
		// 		if (is_null($response['ErrorMessage'])) {
		// 			self::$session = null;
		// 		} else {
		// 			throw new \Exception('Ошибка в ответе пикпоинта: ' . $response['ErrorMessage'], 1);
		// 		}
		// 	} else {
		// 		$errorText = sprintf('Status: %s; Error: %s', $status, $error);
		// 		throw new \Exception('Ошибка при запросе к пикпоинту: ' . $errorText, 1);
		// 	}
		// }

		// /**
		//  * Создает отправление
		//  *
		//  * @api
		//  * @static
		//  * @global array      $_SERVER
		//  * @param  array      $param Параметры отправления
		//  * @return array|null        Параметры не переданы
		//  * @throws \Exception
		//  */
		// public static function createSending($param = []) {
		// 	if (empty($param)) {
		// 		throw new \Exception('Параметры не переданы', 1);
		// 	}

		// 	$data = [
		// 		'SessionId'              => self::$session,
		// 		'Sendings'               => [
		// 			[
		// 				'EDTN'                   => $param['requesUnicNumeric'],
		// 				'IKN'                    => self::getIkn(),
		// 				'Invoice'                => [
		// 					'SenderCode'             => $param['orderNumber'],
		// 					'BarCode'                => '',
		// 					'Description'            => 'Мед в стеклянной таре',
		// 					'RecipientName'          => $param['username'],
		// 					'PostamatNumber'         => $param['pastamatNumber'],
		// 					'MobilePhone'            => $param['userPhone'],
		// 					'Email'                  => $param['userEmail'],
		// 					'PostageType'            => '10001',
		// 					'GettingType'            => '102',
		// 					'PayType'                => '1',
		// 					'Sum'                    => '0.00',
		// 					'InsuareValue'           => '1.00',
		// 					'Width'                  => '0',
		// 					'Height'                 => '0',
		// 					'Depth'                  => '0',
		// 				]
		// 			]
		// 		]
		// 	];

		// 	list($response, $status, $error) = self::post(
		// 		'/createsending',
		// 		$data,
		// 		null
		// 	);

		// 	if ($status === 200 && $error === 0) {
		// 		if (empty($response['RejectedSendings'])) {
		// 			$result = current($response['CreatedSendings']);
		// 			return [
		// 				'edtn'    => $result['EDTN'],
		// 				'invoice' => $result['InvoiceNumber'],
		// 				'barcode' => $result['Barcode'],
		// 				'places'  => $result['Places'],
		// 			];
		// 		} else {
		// 			$result = current($response['RejectedSendings']);
		// 			throw new \Exception('Ошибка в ответе пикпоинта: ' . $result['ErrorMessage'], 1);
		// 		}
		// 	} else {
		// 		$errorText = sprintf('Status: %s; Error: %s', $status, $error);
		// 		throw new \Exception('Ошибка при запросе к пикпоинту: ' . $errorText, 1);
		// 	}
		// }

		// /**
		//  * Вычисляет тарификацию
		//  *
		//  * @api
		//  * @static
		//  * @return mixed        Стоимость доставки
		//  * @throws \Exception
		//  */
		// public static function calcTariff() {
		// 	$data = [
		// 		'SessionId'     => self::$session,
		// 		'IKN'           => self::getIkn(),
		// 		'FromCity'      => 'Воронеж',
		// 		'FromRegion'    => 'Воронежская обл.',
		// 		'PTNumber'      => '5001-019',
		// 		'Length'        => 10,
		// 		'Depth'         => 10,
		// 		'Width'         => 10,
		// 		// 'Weight'        => 1,
		// 	];

		// 	list($response, $status, $error) = self::post(
		// 		'/calctariff',
		// 		$data,
		// 		null
		// 	);

		// 	if ($status === 200 && $error === 0) {
		// 		if (empty($response['ErrorMessage'])) {
		// 			return $response;
		// 		} else {
		// 			throw new \Exception('Ошибка в ответе пикпоинта: ' . $response['ErrorMessage'], 1);
		// 		}
		// 	} else {
		// 		$errorText = sprintf('Status: %s; Error: %s', $status, $error);
		// 		throw new \Exception('Ошибка при запросе к пикпоинту: ' . $errorText, 1);
		// 	}
		// }
	}
