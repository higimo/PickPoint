<?php
	use PHPUnit\Framework\TestCase;

	/**
	 * @covers CurlWrapper
	 */
	final class CurlWrapperTest extends TestCase {

		/**
		 * @expectedException ArgumentCountError
		 */
		public function testArgumentEmpty(): void {
			$this->expectException(new CurlWrapper());
		}

		/**
		 * @expectedException InvalidArgumentException
		 * @expectedExceptionMessage Не указан URL
		 */
		public function testEmptyUrl(): void {
			$this->expectException(new CurlWrapper(''));
		}

		public function testFullUrl(): void {
			$this->assertInstanceOf(
				CurlWrapper::class,
				new CurlWrapper('http://higimo.ru/index.php')
			);
		}

		public function testPostWithParam(): void {
			$index = new CurlWrapper(
				'http://higimo.ru/index.php',
				[
					'Login'    => 'login',
					'Password' => 'pass',
				]
			);

			$index->send();

			$this->assertTrue(strlen($index->getResponse()) > 1);
			$this->assertTrue($index->getStatus() > 3);
			$this->assertTrue($index->getError() === 0);
		}

	}
