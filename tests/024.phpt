--TEST--
code that runs after request shutdown, coverage not started
--SKIPIF--
<?php
if (!extension_loaded("pcov")) print "skip";
if (!extension_loaded("session")) print "skip needs the session extension";
?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}
session.save_path = {TMP}
session.use_cookies = 0
session.cache_limiter =
--FILE--
<?php
/*
 The session module calls the write handler in its RSHUTDOWN, which is after the RSHUTDOWN of pcov:
 the tables that tell if a file is inside pcov.directory do not exist at that point.
 A wrong read shows under valgrind (run-tests.php -m) or with a debug build of PHP.
*/
class Handler implements SessionHandlerInterface {
	#[\ReturnTypeWillChange]
	public function open($path, $name) { return true; }
	#[\ReturnTypeWillChange]
	public function close() { echo "close\n"; return true; }
	#[\ReturnTypeWillChange]
	public function read($id) { return ''; }
	#[\ReturnTypeWillChange]
	public function write($id, $data) {
		$sum = 0;
		for ($i = 0; $i < 3; $i++) {
			$sum += $i;
		}
		echo "write $sum\n";
		return true;
	}
	#[\ReturnTypeWillChange]
	public function destroy($id) { return true; }
	#[\ReturnTypeWillChange]
	public function gc($max) { return 0; }
}

session_set_save_handler(new Handler(), false);
session_start();
$_SESSION['key'] = 1;

echo "end of script\n";
?>
--EXPECT--
end of script
write 3
close
