<?php
for ($i = 1; $i <= 100; $i++) {
    if ($i % 3 == 0 && $i % 5 == 0) {
        echo "FooBar\n";
    } elseif ($i % 3 == 0) {
        echo "Foo\n";
    } elseif ($i % 5 == 0) {
        echo "Bar\n";
    } else {
        echo $i . "\n";
    }       
}
?>