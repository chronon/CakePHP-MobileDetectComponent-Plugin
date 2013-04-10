<?php
App::uses('Controller', 'Controller');
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
		unset($this->Controller);
	}

	public function testDetect() {
		$result = $this->MobileDetect->detect();
		$this->assertFalse($result);

		$result = $this->MobileDetect->detect('isTablet');
		$this->assertFalse($result);
	}

}