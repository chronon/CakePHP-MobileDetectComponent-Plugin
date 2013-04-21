<?php
App::uses('ComponentCollection', 'Controller');
App::uses('MobileDetectComponent', 'MobileDetect.Controller/Component');

class MobileDetectComponentTest extends CakeTestCase {

	public $MobileDetectComponent = null;
	// public $Controller = null;

	public function setUp() {
		parent::setUp();
		$Collection = new ComponentCollection();
		$this->MobileDetect = new MobileDetectComponent($Collection);
	}

	public function tearDown() {
		parent::tearDown();
		unset($this->MobileDetectComponent);
	}

	public function testDetect() {
		$result = $this->MobileDetect->detect();
		$this->assertFalse($result);

		$result = $this->MobileDetect->detect('isTablet');
		$this->assertFalse($result);

		$result = $this->MobileDetect->detect('version', 'iPad');
		$this->assertFalse($result);

		$userAgent = 'Mozilla/5.0 (Linux; Android 4.0.4; Desire HD Build/IMM76D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19';
		$this->MobileDetect->detect('setUserAgent', $userAgent);

		$result = $this->MobileDetect->detect('isAndroidOS');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('isMobile');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('isTablet');
		$this->assertFalse($result);

		$result = $this->MobileDetect->detect('version', 'Android');
		$this->assertEquals('4.0.4', $result);

		$userAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0_1 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A523 Safari/8536.25';
		$this->MobileDetect->detect('setUserAgent', $userAgent);

		$result = $this->MobileDetect->detect('isIos');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('isMobile');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('isTablet');
		$this->assertFalse($result);

		$result = $this->MobileDetect->detect('version', 'iPhone');
		$this->assertEquals('6_0_1', $result);

		$userAgent = 'Mozilla/5.0 (iPad; CPU OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25';
		$this->MobileDetect->detect('setUserAgent', $userAgent);

		$result = $this->MobileDetect->detect('isIos');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('isMobile');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('isTablet');
		$this->assertTrue($result);

		$result = $this->MobileDetect->detect('version', 'iPad');
		$this->assertEquals('6_0', $result);
	}

}