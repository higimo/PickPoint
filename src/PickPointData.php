<?php

	namespace Higimo\PickPoint;

	use SimpleXMLElement;

	class PickPointData {

		private static $ptData = null;

		function __construct() {
			self::$ptData = $this->getData();
		}

		function getData() {
			$strXml = file_get_contents('https://pickpoint.ru/postamats.xml');
			$objXml = new SimpleXMLElement($strXml);
			$arData = json_decode(json_encode($objXml), true)['pt'];
			return $arData;
		}

		function getPostamatByCityName($name) {
			$found = array_filter(self::$ptData, function($postamat) use ($name) {
				return $postamat['City'] == $name;
			});
			return $found;
		}
	}
