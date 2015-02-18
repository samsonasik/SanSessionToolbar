SanSessionToolbar
=================

[![Build Status](https://secure.travis-ci.org/samsonasik/SanSessionToolbar.svg?branch=master)](http://travis-ci.org/samsonasik/SanSessionToolbar)
[![Coverage Status](https://coveralls.io/repos/samsonasik/SanSessionToolbar/badge.png?branch=develop)](https://coveralls.io/r/samsonasik/SanSessionToolbar)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/san/san-session-toolbar.svg?style=flat-square)](https://packagist.org/packages/san/san-session-toolbar)

What is it about ?
-----------------
It is a ZF2 module as session toolbar for [ZendDeveloperTools](https://github.com/zendframework/ZendDeveloperTools). It shows you the ZF2 session data you've been using like this :

![Show ZF2 sessions data](https://cloud.githubusercontent.com/assets/459648/5303224/ff3553e2-7c19-11e4-8c20-b9eebbf559d2.png)

Installation
------------

Installation of this module uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

```sh
$ composer require san/san-session-toolbar 0.*
```

Enable this : 
```php
// config/application.config.php
return [
    'modules' => [
        // ...
        'ZendDeveloperTools',
        'SanSessionToolbar',
    ]
    // ...
],
```
Credit
------
Current Image session icon originally from : http://png-5.findicons.com/files/icons/728/database/512/database_2_512.png, encoded with base64_encode.
