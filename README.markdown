CakePHP Mobile-Detect Component
===============================

CakePHP's built-in CakeRequest object can easily determine if a request is from a mobile device:

	$this->request->is('mobile');

However, sometimes an application needs finer control over what to serve certain devices, such as a 
mobile layout to smartphones and a desktop layout to tablets. The [MobileDetect](http://mobiledetect.net/)
project is a "lightweight PHP class for detecting mobile devices". This component, packaged as
a plugin, makes MobileDetect available in a CakePHP controller. 

Compatibility:
--------------

Tested with CakePHP 2.3.x, but should work fine with any CakePHP 2.x version.

Installation:
-------------

You will need the component (packaged as a plugin), and the MobileDetect PHP library (not included). The
MobileDetect library needs to be in this plugin's Vendor directory and must be named 'MobileDetect'. 
Using git, something like this:

``` sh
git clone git@github.com:chronon/CakePHP-MobileDetectComponent-Plugin.git APP/Plugin/MobileDetect  
git clone git@github.com:serbanghita/Mobile-Detect.git APP/Plugin/MobileDetect/Vendor/MobileDetect
```

The MobileDetect library could also be added as a git submodule...

Usage:
------

The component has only one method, named `detect`. It accepts two arguments: the method to pass to
the MobileDetect library, and any arguments for the passed method.

Example: check if a request is from a tablet:

	$result = $this->MobileDetect->detect('isTablet');

Example: check if a request is from an iOS device :

	$result = $this->MobileDetect->detect('isiOS');

Example: get version number of an Android device:
	
	$result = $this->MobileDetect->detect('version', 'Android');

See the demo at [mobiledetect.net](http://mobiledetect.net/) for a list of all available methods.

Example:
--------

Let's say we want to serve a mobile layout to smartphones and a desktop layout to
tablets. Instead of loading the component on every request (by adding it to your controller's
`$components` array), we'll load the component on the fly when needed. This example set's a session
variable `tablet` if the request is from a tablet, calling the component only once.

In `Controller/AppController.php`:

``` php
<?php
public function beforeFilter() {
	// check if the request is 'mobile', includes phones, tablets, etc.
	if ($this->request->is('mobile')) {
		if (!$this->_isTablet()) {
			// if the request is mobile, but not a tablet, activate the mobile layout
			$this->_setMobile();
		}
	}
}

protected function _setMobile() {
	$this->theme = 'Mobile';
	// etc...
}

protected function _isTablet() {
	if ($this->Session->check('tablet')) {
		if ($this->Session->read('tablet') == true) {
			return true;
		}
		return false;
	}
	// load the component
	$this->MobileDetect = $this->Components->load('MobileDetect.MobileDetect');
	// pass the component the 'isTablet' method
	$result = $this->MobileDetect->detect('isTablet');
	$this->Session->write('tablet', $result);
	return $result;
}
```
