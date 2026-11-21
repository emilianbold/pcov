--TEST--
directory: property hooks that are read from outside pcov.directory
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip"; if (PHP_VERSION_ID < 80400) print "skip only for PHP >= 8.4"; ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';
require __DIR__ . '/fixtures/src/lib.php';
require __DIR__ . '/fixtures/src/hooks.php';

\pcov\start();
$hooked = new WHooked();
$hooked->double = 21;
for ($i = 0; $i < 3; $i++) {
	var_dump($hooked->double, $hooked->one);
}
\pcov\stop();
u_show('hooks');
?>
--EXPECT--
int(42)
int(1)
int(42)
int(1)
int(42)
int(1)
-- hooks
hooks.php: 5,8,9,13
lib.php:
