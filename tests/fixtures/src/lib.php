<?php
function w_add($a, $b) {
	return $a + $b;
}

function w_calls_unwanted($x) {
	$y = u_twice($x);
	return $y + 1;
}

function w_gen($n) {
	for ($i = 0; $i < $n; $i++) {
		yield $i;
	}
	return 'done';
}

function w_with_callback(callable $cb) {
	$before = 1;
	$cb();
	$after = 2;
	return $before + $after;
}

function w_throws() {
	throw new RuntimeException('w');
}

function w_finally() {
	try {
		u_calls_wanted_thrower();
	} catch (RuntimeException $e) {
		return 'caught';
	} finally {
		$f = 1;
	}
}

function w_same_line_clear() {
	$a = 1; $b = u_clear(); $c = 3;
	return $a + $b + $c;
}

function w_loop($n) {
	$s = 0;
	for ($i = 0; $i < $n; $i++) {
		$s += $i;
	}
	return $s;
}

class WMagic {
	public function __call($name, $args) {
		return $name;
	}

	public static function __callStatic($name, $args) {
		return strtoupper($name);
	}

	public function __destruct() {
		echo "destructed\n";
	}
}

function w_eval() {
	return eval('return w_add(1, 2);');
}
