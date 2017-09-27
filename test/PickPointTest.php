<?php

	use PHPUnit\Framework\TestCase;
	use Higimo\PickPoint\PickPoint;

	/**
	 * @covers PickPoint
	 */
	final class PickPointTest extends TestCase {

		public function testInstance(): void {
			$this->assertInstanceOf(
				PickPoint::class,
				new PickPoint()
			);
		}

		public function testGetUrl(): void {
			$index = new PickPoint();
			$this->assertRegExp('/https:\/\/.+.pickpoint.ru\/.+\//', $index->getUrl());
		}

		public function testGetLogin(): void {
			$index = new PickPoint();
			$this->assertEquals($index->getLogin(), 'apitest');
		}

		public function testGetPassword(): void {
			$index = new PickPoint();
			$this->assertEquals($index->getPassword(), 'apitest');
		}

		public function testGetIkn(): void {
			$index = new PickPoint();
			$this->assertEquals($index->getIkn(), '9990003041');
		}

		// TODO: Не умею это тестировать
		public function testLogin(): void {
			$index = new PickPoint();
			$index->login();
			$this->assertTrue(true);
		}

		// TODO: Не умею это тестировать
		public function testLogout(): void {
			$index = new PickPoint();
			$index->logout();
			$this->assertTrue(true);
		}

		// TODO: Не умею это тестировать
		public function testGetZoneByCityName(): void {
			$index = new PickPoint();
			$index->getZoneByCityName('Москва');
			$this->assertTrue(true);
		}

		// TODO: Не умею это тестировать
		public function testGetRatioByZoneId(): void {
			$index = new PickPoint();
			$index->getRatioByZoneId(3);
			$this->assertTrue(true);
		}

		// TODO: Не умею это тестировать
		public function testGetLagByZoneId(): void {
			$index = new PickPoint();
			$index->getLagByZoneId(5);
			$this->assertTrue(true);
		}

		// TODO: Не умею это тестировать
		public function testSend(): void {
			$index = new PickPoint();
			$index->send([
				'sendId'         => '301_pick',
				'orderNumber'    => 301,
				'userName'       => 'higimo',
				'pastamatNumber' => '5001-019',
				'userPhone'      => '+79079079090',
				'userEmail'      => 'higimo@gmail.com',
			]);
			$this->assertTrue(true);
		}

		// TODO: Не умею это тестировать
		public function testGetPrice(): void {
			$index = new PickPoint();
			try {
				$index->getPrice([
					'city'       => 'Воронеж',
					'region'     => 'Воронежская обл.',
					'postamatId' => '5001-019',
					'length'     => 10,
					'depth'      => 10,
					'width'      => 10,
				]);
			} catch (Exception $error) {
				if ($error->getMessage() === 'Ошибка при запросе к пикпоинту') {
					$this->assertTrue(true);
				} else {
					$this->assertTrue(false);
				}
			}
		}

	}
