### 1.0.0 - 2016-07-16

- support only php ^5.6 | ^7.0
- bring short array syntax
- support only zf ^2.5 components

### 0.6.3 - 2016-06-28

- zdt dependency in require-dev

### 0.6.2 - 2016-06-28

- Added zend-view dependency in require-dev to be able to run tests in travis and update tests with prophecy
- use ControllerManager check in SessionToolbarControllerFactory

### 0.6.1 - 2016-06-28

- Added zend-json dependency when only use new skeleton-app ( with zend-mvc v3 ) minimal

### 0.6.0 - 2016-05-05

- [Support to be used with zend-servicemanager v2 and v3](https://github.com/samsonasik/SanSessionToolbar/pull/53)
- [Fixes reload session should force start the session](https://github.com/samsonasik/SanSessionToolbar/pull/53)

### 0.5.0 - 2016-04-13

- [Do not start session when it not started yet in app](https://github.com/samsonasik/SanSessionToolbar/pull/51)

### 0.4.1 - 2016-02-14

- [Immediate release for remove manage button (add, remove) when session container name is "FlashMessenger"](https://github.com/samsonasik/SanSessionToolbar/pull/50)

### 0.4.0 - 2016-02-14

- [Added support show sessions of flashmessenger](https://github.com/samsonasik/SanSessionToolbar/pull/49)

### 0.3.3 - 2016-01-11

- [remove not needed session-data-reload.phtml view](https://github.com/samsonasik/SanSessionToolbar/pull/48)

### 0.3.2 - 2016-01-02

- refactor SessionManager::clearSession() to not return session data

### 0.3.1 - 2016-01-01

- update satooshi/php-coveralls to use ~1.0.0 to support php 5.3 usage
- update license
- update versioneye dependency status to rely on project id

### 0.3.0 -  2015-12-04

- update php requirement to allow php < 8

### 0.2.1 - 0.2.2 ( bug fix of 0.2.1 )- 2015-11-01

- Fixes base_path issue [#39](https://github.com/samsonasik/SanSessionToolbar/issues/39)

### 0.2.0 - 2015-07-22

-  use individual zf components to anticipate moving components of zf to suggest

### 0.1.9 - 2015-07-22

- Added space before data-container attribute ( #35 )

### 0.1.8 - 2015-06-23

- refactor js and html ( #33 )
- drop zf requirement to ~2.3
- add xdebug to suggested extension to be installed already for better output

### 0.1.7 - 2015-06-03

- remove hhvm-nightly as now ubuntu don't support it
- composer using prefer-source
- using {@inheritDoc} in Manager
- update badge for dependency status
- using https for composer url
- fixes docblock parameter and remove lazy load as latest ZDT master for serialize collector is updated

### 0.1.6 - 2015-05-06

- improvement on clear() method by container or all containers

### 0.1.5 - 2015-04-21

- update zf2 requirement to ~2.4
- update phpunit.xml blacklist
- update composer install command on .travis.yml to use --prefer-dist
- update composer timeout command in .travis.yml

### 0.1.4 - 2015-04-13

- Add more tests
- Add more badges
- Scrutinizer fixes
- Refactor Factory using ServiceLocatorAwareInterface


### 0.1.3 - 2015-03-27

- Add new feature Add New Session Data
- Remove redundance view
- Enhance composer autoload
- Update Travis config for composer self-update on before_install

### 0.1.2 - 2015-03-16

- Refactor Js to make it re-usable
- Make Controller slimmer, move logics to service
- Add CONTRIBUTING.md
- var_dump data presentation fix ( https://github.com/samsonasik/SanSessionToolbar/pull/21 )

### 0.1.1 - 2015-03-01

- Add feature Reload All session data
- Add feature Clear Session data by its Container
- Add feature Clear All Session data in All Container
- Add feature Update Session data

### 0.1.0 - 2015-02-26

- Add feature Grouping Session Container
- Add feature Remove Session by its key

### 0.0.8 - 2015-02-25

- hotfix : conditional empty data
- remove redundant label in view

### 0.0.7 - 2015-02-20

- Using scalar check for preview session

### 0.0.6 - 2015-02-20

- Add more widgets/badges
- Fixes newline in yml files (travis and coveralls)
- Update list of contributors
- more verbose preview

### 0.0.5 - 2015-02-17

- Fixes docblock
- Add tests
- Update installation and enable in ZF2 app
- Update use statement

### 0.0.4 - 2014-12-05

- Add detail what it is about
- Change session logo

## 0.0.3 - 2014-12-04

### Added

- Added readme for installation


## 0.0.2 - 2014-12-01

### Added

- Apply multi dimensional array support


## 0.0.1 - 2014-7-24

### Added

- Apply session key -> value show
