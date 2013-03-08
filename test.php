<?php
class IndexTest extends \PHPUnit_Framework_TestCase
{
	public function testHello()
	{
		$_GET['name'] = 'Quique';

		ob_start();
		include 'index.php';
		$content = ob_get_clean();
		$this->assertEquals('Hello Quique', $content);
	}
}

$testClass = new IndexTest();

$testClass()->testHello();