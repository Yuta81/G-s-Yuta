<?php

/*HTML XSS対策*/
function e($value) {
    return htmlspecialchars($value,ENT_QUOTES);
}

?>