--TEST--
start, stop and clear while a function inside pcov.directory runs
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip";  ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';
require __DIR__ . '/fixtures/src/lib.php';

var_dump(w_with_callback('u_start'));
\pcov\stop();
u_show('start in the callback');

\pcov\clear();
\pcov\start();
var_dump(w_with_callback('u_stop'));
u_show('stop in the callback');

\pcov\clear();
\pcov\start();
var_dump(w_with_callback('u_clear'));
\pcov\stop();
u_show('clear in the callback');

\pcov\clear();
\pcov\start();
var_dump(w_same_line_clear());
\pcov\stop();
u_show('clear in the middle of a line');

\pcov\clear();
\pcov\start();
w_loop(2);
\pcov\clear();
w_loop(2);
\pcov\stop();
u_show('the same lines again after clear');

\pcov\clear();
\pcov\start();
w_loop(2);
\pcov\stop();
w_add(1, 2);
\pcov\start();
w_loop(2);
\pcov\stop();
u_show('stop and start without clear');
?>
--EXPECT--
int(3)
-- start in the callback
lib.php: 21,22
int(3)
-- stop in the callback
lib.php: 19,20
int(3)
-- clear in the callback
lib.php: 21,22
int(4)
-- clear in the middle of a line
lib.php: 40,41
-- the same lines again after clear
lib.php: 45,46,47,49
-- stop and start without clear
lib.php: 45,46,47,49
