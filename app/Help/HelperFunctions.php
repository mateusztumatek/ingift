<?php

function price($price){
    if(!is_numeric($price)){
        return number_format(0, 2);
    }
    return number_format($price, 2);
}
