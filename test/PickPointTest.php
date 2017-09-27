<?php

	use PHPUnit\Framework\TestCase;
	use Higimo\PickPoint\PickPoint;

	/**
	 * @covers PickPoint
	 */
	final class PickPointTest extends TestCase {

		// /**
		//  * @expectedException ArgumentCountError
		//  */
		// public function testArgumentEmpty(): void {
		// 	// $this->expectException(new CurlWrapper());
		// }

		// *
		//  * @expectedException InvalidArgumentException
		//  * @expectedExceptionMessage Не указан URL

		// public function testEmptyUrl(): void {
		// 	$this->expectException(new CurlWrapper(''));
		// }

		// public function testFullUrl(): void {
		// 	$this->assertInstanceOf(
		// 		CurlWrapper::class,
		// 		new CurlWrapper('http://higimo.ru/index.php')
		// 	);
		// }

		public function testPostWithParam(): void {
			$index = new PickPoint();
			$index->getZone('Люберцы');

			$this->assertTrue(true);
		}

		public function testPostWithParam2(): void {
			$index = new PickPoint();
			$index->login();

			$this->assertTrue(true);
		}

	}
