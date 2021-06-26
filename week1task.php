<?php

function getrange($start, $end)
{
    return range($start, $end);

    // OR
    
    // $allnums = [];

    // for ($i = $start; $i <= $end; $i++) {
    //     array_push($allnums, $i);
    // }
    // return $allnums;
   
}

function sum(array $num)
{
    return array_sum($num);
}

print_r(getrange(1, 10));

echo "<h3>Sum of all number is: ". sum([4,5,-2,6,8,4])."</h3>";

?>