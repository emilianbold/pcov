--TEST--
directory: nested calls between code inside and outside pcov.directory
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
var_dump(w_calls_unwanted(1));
var_dump(u_recurse(3));
var_dump(array_map('w_add', [1, 2], [3, 4]));
var_dump(w_loop(3));
\pcov\stop();
u_show('nested');
foreach (\pcov\waiting() as $file) {
	echo basename($file), "\n";
}
?>
--EXPECT--
int(3)
int(3)
array(2) {
  [0]=>
  int(4)
  [1]=>
  int(6)
}
int(3)
-- nested
lib.php: 3,7,8,45,46,47,49
lib.php
