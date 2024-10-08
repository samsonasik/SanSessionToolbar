SanSessionToolbar
=================

[![Latest Version](https://img.shields.io/github/release/samsonasik/SanSessionToolbar.svg?style=flat-square)](https://github.com/samsonasik/SanSessionToolbar/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com)
[![Build Status](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/badges/build.png?b=master)](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/samsonasik/SanSessionToolbar/?branch=master)
[![StyleCI](https://styleci.io/repos/21261604/shield)](https://styleci.io/repos/21261604)
[![Total Downloads](https://poser.pugx.org/san/san-session-toolbar/downloads)](https://packagist.org/packages/san/san-session-toolbar)

What is it about ?
-----------------
It is a Laminas module as session toolbar for [LaminasDeveloperTools](https://github.com/laminas/laminas-developer-tools). It shows you the Laminas session data you've been using like this :

![Fully Crud Laminas sessions data](https://cloud.githubusercontent.com/assets/459648/6867548/cad28e40-d4b5-11e4-911c-ffd8b88fd41f.png)

You can reload, clear, add, update, and remove your sessions data.

> This is README for version ^5.0 which only support Laminas 3 with php ^8.1

> For version ^4.0, you can read at [version 4.x.x readme](https://github.com/samsonasik/SanSessionToolbar/blob/4.x.x/README.md) which support Laminas 3 and php ^7.3|~8.0.

> For version ^3.0, you can read at [version 3.x.x readme](https://github.com/samsonasik/SanSessionToolbar/blob/3.x.x/README.md) which support Laminas 3 and php ^7.2.

> For version 2.1.*, you can read at [version 2.1.* readme](https://github.com/samsonasik/SanSessionToolbar/blob/2.1.x/README.md) which support ZF3 and php ^7.2.

> For version 2.0.*, you can read at [version 2.0.* readme](https://github.com/samsonasik/SanSessionToolbar/blob/2.0.x/README.md) which support ZF3 and php ^7.1.

> For version 1, you can read at [version 1 readme](https://github.com/samsonasik/SanSessionToolbar/tree/1.x.x) which still support ZF2 with php ^5.6|^7.0 support.

Installation
------------

Installation of this module uses composer.

```sh
composer require san/san-session-toolbar
```

For composer documentation, please refer to [getcomposer.org](https://getcomposer.org/).

Enable it :
```php
// config/application.config.php
return [
    'modules' => [
        // ...
        'Laminas\DeveloperTools',
        'SanSessionToolbar', // put at the end of modules list!
    ]
    // ...
],
```

> **Note** :
- for better ouput format, you need to have Xdebug installed in your system.
- for laminas-mvc v3 usage, if you want to get FlashMessenger data, you need to install laminas/laminas-mvc-plugin-flashmessenger

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
