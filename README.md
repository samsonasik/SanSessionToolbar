SanSessionToolbar
=================

[![Latest Version](https://img.shields.io/github/release/samsonasik/SanSessionToolbar.svg?style=flat-square)](https://github.com/samsonasik/SanSessionToolbar/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
 [![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![Build Status](https://travis-ci.org/samsonasik/SanSessionToolbar.svg?branch=master)](https://travis-ci.org/samsonasik/SanSessionToolbar)
[![Code Coverage](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/15956744-b35e-4504-ade8-14f46addcae9/mini.png)](https://insight.sensiolabs.com/projects/15956744-b35e-4504-ade8-14f46addcae9)
[![StyleCI](https://styleci.io/repos/21261604/shield)](https://styleci.io/repos/21261604)
[![PHP 7 ready](http://php7ready.timesplinter.ch/samsonasik/SanSessionToolbar/badge.svg)](https://travis-ci.org/samsonasik/SanSessionToolbar)
[![Dependency Status](https://www.versioneye.com/user/projects/54e421a6d1ec5734f4000242/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54e421a6d1ec5734f4000242)
[![Percentage of issues still open](http://isitmaintained.com/badge/open/samsonasik/SanSessionToolbar.svg)](http://isitmaintained.com/project/samsonasik/SanSessionToolbar "Percentage of issues still open")
[![Total Downloads](https://img.shields.io/packagist/dt/san/san-session-toolbar.svg?style=flat-square)](https://packagist.org/packages/san/san-session-toolbar)

What is it about ?
-----------------
It is a ZF2/ZF3 module as session toolbar for [ZendDeveloperTools](https://github.com/zendframework/ZendDeveloperTools). It shows you the ZF2/ZF3 session data you've been using like this :

![Fully Crud ZF2/ZF3 sessions data](https://cloud.githubusercontent.com/assets/459648/6867548/cad28e40-d4b5-11e4-911c-ffd8b88fd41f.png)

You can reload, clear, add, update, and remove your sessions data.

Installation
------------

Installation of this module uses composer.

```sh
$ composer require san/san-session-toolbar
```

For composer documentation, please refer to [getcomposer.org](https://getcomposer.org/).

Enable it :
```php
// config/application.config.php
return [
    'modules' => [
        // ...
        'ZendDeveloperTools',
        'SanSessionToolbar', // put at the end of modules list!
    ]
    // ...
],
```

> **Note** : 
- for better ouput format, you need to have Xdebug installed in your system.
- for zend-mvc v3 usage, if you want to get FlashMessenger data, you need to install zendframework/zend-mvc-plugin-flashmessenger

Contributing
------------
Contributions are very welcome. Please read [CONTRIBUTING.md](https://github.com/samsonasik/SanSessionToolbar/blob/master/CONTRIBUTING.md)

Credit
------

- [Abdul Malik Ikhsan](https://github.com/samsonasik)
- [All SanSessionToolbar contributors](https://github.com/samsonasik/SanSessionToolbar/contributors)
- Toolbar Session icon from : http://png-5.findicons.com/files/icons/728/database/512/database_2_512.png, encoded with base64_encode.
- Remove Session icon from http://icons.iconarchive.com/icons/oxygen-icons.org/oxygen/16/Actions-edit-delete-icon.png, encoded with base64_encode.
- Reload session icon from http://findicons.com/icon/261541/arrow_refresh, encoded with base64_encode.
- Edit Session icon from http://findicons.com/files/icons/140/toolbar_icons_3_by_ruby_softwar/128/edit.png, encoded with base64_encode.
- Clear session icon from http://findicons.com/icon/66997/gnome_edit_clear, encoded with base64_encode.
- Save Session icon from http://findicons.com/files/icons/980/yuuminco/48/3_disc.png, encoded with base64_encode.
- Cancel save session from http://findicons.com/files/icons/734/phuzion/128/stop.png, encoded with base64_encode.
- Add new session data from http://findicons.com/icon/248302/add?id=325782, encoded with base64_encode.
