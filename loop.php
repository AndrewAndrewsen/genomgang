<pre>
<?php

function hej() {
    
echo max(1,2);

}

hej();
    $array = [0, 1, 2, 3, 4, 5, 6];
    echo "For-loop: <br />";
    for($i = 0; $i < count($array); $i++) {
        echo $array[$i] . "<br />";
    }

    echo "Foreach-loop: <br />";

    foreach($array as $value) {
        echo $value . "<br />";

    }


?>
</pre>