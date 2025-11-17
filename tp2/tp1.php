<?php
function calcMoy($notes){
    return array_sum($notes) / count($notes);
}

$notes = [10, 15, 12, 18, 14];
echo calcMoy($notes);
?>