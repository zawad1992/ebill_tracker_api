<?php
function pr($data=array(), $exit=false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if($exit) {
        exit;
    }
}