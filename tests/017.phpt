--TEST--
directory: include and eval that cross pcov.directory
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip";  ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';
require __DIR__ . '/fixtures/src/lib.php';

\pcov\start();
var_dump(require __DIR__ . '/fixtures/src/included.php');
var_dump(w_with_callback(function () {
	return require __DIR__ . '/fixtures/vendor/included.php';
}));
var_dump(w_eval());
var_dump(eval('return w_add(3, 4);'));
\pcov\stop();
u_show('include and eval');
foreach (\pcov\waiting() as $file) {
	echo basename($file), "\n";
}
?>
--EXPECT--
int(4)
int(3)
int(3)
int(7)
-- include and eval
included.php: 2,3,4,6
lib.php: 3,19,20,21,22,67
included.php
lib.php
lib.php(67) : eval()'d code
