--TEST--
lines with a high number, before and after clear
--SKIPIF--
<?php if (!extension_loaded("pcov")) print "skip"; ?>
--INI--
pcov.enabled = 1
pcov.directory = {PWD}/fixtures/src
--FILE--
<?php
require __DIR__ . '/fixtures/vendor/lib.php';

$file = __DIR__ . '/fixtures/src/far.php';
$code = "<?php\nfunction w_near(\$a) {\n\treturn \$a;\n}\n";
$code .= str_repeat("\n", 995) . "function w_mid(\$a) {\n\treturn \$a;\n}\n";
$code .= str_repeat("\n", 68997) . "function w_far(\$a) {\n\treturn \$a;\n}\n";
file_put_contents($file, $code);
require $file;

\pcov\start();
w_near(1);
w_far(1);
w_mid(1);
w_near(1);
\pcov\stop();
u_show('near, far, mid');

\pcov\clear();
\pcov\start();
w_far(1);
\pcov\stop();
u_show('far again after clear');

\pcov\clear();
\pcov\start();
w_mid(1);
\pcov\stop();
u_show('mid again after clear');
?>
--CLEAN--
<?php
@unlink(__DIR__ . '/fixtures/src/far.php');
?>
--EXPECT--
-- near, far, mid
far.php: 3,1001,70001
-- far again after clear
far.php: 70001
-- mid again after clear
far.php: 1001
