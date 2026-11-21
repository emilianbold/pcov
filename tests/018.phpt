--TEST--
directory: exceptions, finally, magic methods and destructors that cross pcov.directory
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip";  ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';
require __DIR__ . '/fixtures/src/lib.php';

register_shutdown_function(function () {
	var_dump(w_add(5, 5));
	u_show('shutdown function');
});

\pcov\start();
var_dump(w_finally());
try {
	u_calls_wanted_thrower();
} catch (RuntimeException $e) {
	echo $e->getMessage(), "\n";
}
$magic = new WMagic();
var_dump($magic->anything());
var_dump(WMagic::other());
unset($magic);
\pcov\stop();
u_show('exceptions and magic');

\pcov\clear();
\pcov\start();
$late = new WMagic();
?>
--EXPECT--
string(6) "caught"
w
string(8) "anything"
string(5) "OTHER"
destructed
-- exceptions and magic
lib.php: 26,31,32,33,35,54,58,62,63
int(10)
-- shutdown function
lib.php: 3
destructed
