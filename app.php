<?php

require('functions/NumbersToWords.php');

$class = new NumbersToWords();

if( isset($_POST['number']) ){
    $number = $_POST['number'];
    echo $class->convert($number);
}