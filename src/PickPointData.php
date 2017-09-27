<?php

	namespace Higimo\PickPoint;

	class PickPointData {
		private $ptData = null;
		function __construct() {
			// TODO: cache
			self::$ptData = file_get_contents('https://pickpoint.ru/postamats.xml');
			return self::$ptData;
		}
		function getPostamatByCityName($name) {
			echo '<pre>', var_dump($name), '</pre>';
		}
	}
