ZF2 module as session toolbar for ZendDeveloperTools

What it's about ?
-----------------
It shows you the ZF2 session data you've been using like this :
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
