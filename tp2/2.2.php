<?php
function my_strrev(string $s): string {
    $len = strlen($s);
    $rev = '';

    for ($i = $len - 1; $i >= 0; $i--) {
        if (!isset($s[$i])) {
            break;
        }
        $rev .= $s[$i];
    }

    return $rev;

}
echo my_strrev("Coucou");
?>