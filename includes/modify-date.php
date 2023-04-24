<?php
function modify($date)
{
    if ($date) {
        $datetime = new DateTime($date);
        echo $datetime->format("j F, Y");
    }
}
