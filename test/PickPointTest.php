<?php

	use PHPUnit\Framework\TestCase;

	/**
	 * @covers CurlWrapper
	 */
	final class CurlWrapperTest extends TestCase {

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
			$index->getZone('dwqd');

			$this->assertTrue(true);
		}

	}
