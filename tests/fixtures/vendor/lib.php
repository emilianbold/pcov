<?php
function u_twice($x) {
	return w_add($x, $x);
}

function u_calls_wanted_thrower() {
	w_throws();
}

function u_gen($n) {
	for ($i = 0; $i < $n; $i++) {
		yield w_add($i, 1);
	}
}

function u_start() {
	\pcov\start();
}

function u_stop() {
	\pcov\stop();
}

function u_clear() {
	\pcov\clear();
	return 0;
}

function u_recurse($n) {
	return $n ? u_recurse($n - 1) + 1 : w_add(0, 0);
}

/* Prints the executed lines of each file that pcov reports, in a stable order. */
function u_show($label) {
	$data = \pcov\collect();
	ksort($data);
	echo "-- $label\n";
	foreach ($data as $file => $lines) {
		ksort($lines);
		echo basename($file), ': ', implode(',', array_keys(array_filter($lines, function ($v) { return $v === 1; }))), "\n";
	}
}
