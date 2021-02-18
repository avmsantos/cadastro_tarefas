<?php

function converterDataEmFormatoDB($data) {
    return implode("-", array_reverse(explode("/", $data)));
}

function converterDataEmFormatoBR($data) {
    return implode("/", array_reverse(explode("-", $data)));
}
