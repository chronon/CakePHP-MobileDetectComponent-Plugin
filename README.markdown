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

Tested with CakePHP 2.6.x, but should work fine with any CakePHP 2.x version.

**NOTE:** This plugin is not CakePHP 3.x compatible, but the `Mobile_Detect` lib is included with the CakePHP 3 [app skeleton](https://github.com/cakephp/app) and can be used and extended as needed making this plugin unnecessary.

* <https://github.com/cakephp/app/pull/38/>
* <https://github.com/cakephp/cakephp/pull/3031>

Installation:
-------------

**Using [Composer](http://getcomposer.org/)/[Packagist](https://packagist.org):**

In your project `composer.json` file:

```
{
	"require": {
		"chronon/mobile_detect": "*"
	},
	"config": {
        "vendor-dir": "Vendor"
    }
}
```

This will install the plugin into `Plugin/MobileDetect`, and install the Mobile_Detect lib 
(from Packagist) into your `Vendor` directory.

In your app's `Config/bootstrap.php`, import composer's autoload file:

```php
<?php
App::import('Vendor', array('file' => 'autoload'));
```

**Using git:**

You will need the component (packaged as a plugin), and the MobileDetect PHP library (not included). The
MobileDetect library needs to be in this plugin's Vendor directory and must be named 'MobileDetect'. 
Using git, something like this:

``` sh
git clone git@github.com:chronon/CakePHP-MobileDetectComponent-Plugin.git app/Plugin/MobileDetect  
git clone git@github.com:serbanghita/Mobile-Detect.git app/Plugin/MobileDetect/Vendor/MobileDetect
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
`$components` array), we'll load the component on the fly when needed. This example sets a session
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
		return $this->Session->read('tablet');
	}
	// load the component
	$this->MobileDetect = $this->Components->load('MobileDetect.MobileDetect');
	// pass the component the 'isTablet' method
	$result = $this->MobileDetect->detect('isTablet');
	$this->Session->write('tablet', $result);
	return $result;
}
```
