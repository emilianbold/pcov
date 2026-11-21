--TEST--
exclude: a file that pcov.exclude matches is not reported
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip";  ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
pcov.exclude = "~excluded~"
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';
require __DIR__ . '/fixtures/src/lib.php';
require __DIR__ . '/fixtures/src/excluded.php';

\pcov\start();
var_dump(w_excluded());
var_dump(w_add(1, 1));
\pcov\stop();
u_show('exclude');
var_dump(count(\pcov\waiting()));
?>
--EXPECT--
int(1)
int(2)
-- exclude
lib.php: 3
int(1)
