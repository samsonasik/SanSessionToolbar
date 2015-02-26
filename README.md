SanSessionToolbar
=================

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://secure.travis-ci.org/samsonasik/SanSessionToolbar.svg?branch=master)](http://travis-ci.org/samsonasik/SanSessionToolbar)
[![Coverage Status](https://coveralls.io/repos/samsonasik/SanSessionToolbar/badge.svg?branch=master)](https://coveralls.io/r/samsonasik/SanSessionToolbar)
[![Total Downloads](https://img.shields.io/packagist/dt/san/san-session-toolbar.svg?style=flat-square)](https://packagist.org/packages/san/san-session-toolbar)
[![Dependency Status](https://www.versioneye.com/php/san:san-session-toolbar/badge.svg)](https://www.versioneye.com/php/san:san-session-toolbar/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/15956744-b35e-4504-ade8-14f46addcae9/mini.png)](https://insight.sensiolabs.com/projects/15956744-b35e-4504-ade8-14f46addcae9)

What is it about ?
-----------------
It is a ZF2 module as session toolbar for [ZendDeveloperTools](https://github.com/zendframework/ZendDeveloperTools). It shows you the ZF2 session data you've been using like this :

![Show ZF2 sessions data](https://cloud.githubusercontent.com/assets/459648/6378361/756ec5c8-bd5d-11e4-8c32-497a12806db2.png)

You can remove your sessions data by click remove icons.

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

- Current Image session icon originally from : http://png-5.findicons.com/files/icons/728/database/512/database_2_512.png, encoded with base64_encode.
- Remove Icon originally from http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/16/Actions-edit-delete-icon.png, encoded with base64_encode.
