--TEST--
directory: generators that cross pcov.directory
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
$gen = w_gen(2);
foreach ($gen as $v) {
	echo $v, "\n";
}
var_dump($gen->getReturn());
\pcov\stop();
u_show('generator inside the directory, resumed from outside');

\pcov\clear();
\pcov\start();
foreach (u_gen(2) as $v) {
	echo $v, "\n";
}
\pcov\stop();
u_show('generator outside the directory that calls inside');

\pcov\clear();
$gen = w_gen(3);
$gen->current();
\pcov\start();
$gen->next();
\pcov\stop();
$gen->next();
u_show('generator that ran before start and after stop');
?>
--EXPECT--
0
1
string(4) "done"
-- generator inside the directory, resumed from outside
lib.php: 11,12,13,15
1
2
-- generator outside the directory that calls inside
lib.php: 3
-- generator that ran before start and after stop
lib.php: 12,13
