--TEST--
directory: fibers that cross pcov.directory
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip"; if (PHP_VERSION_ID < 80100) print "skip only for PHP >= 8.1"; ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';
require __DIR__ . '/fixtures/src/lib.php';

\pcov\start();
$fiber = new Fiber(function () {
	$x = w_with_callback(function () {
		Fiber::suspend(1);
	});
	return w_add($x, Fiber::suspend(2));
});
var_dump($fiber->start());
var_dump(w_loop(2));
var_dump($fiber->resume());
$fiber->resume(10);
var_dump($fiber->getReturn());
\pcov\stop();
u_show('fiber');
?>
--EXPECT--
int(1)
int(1)
int(2)
int(13)
-- fiber
lib.php: 3,19,20,21,22,45,46,47,49
