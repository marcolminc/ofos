<?php
function filterInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return ($data);
}

function checkName($inpt) {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $inpt)) {
        return (false);
    }
    return (true);
}
function checkEmail($inpt) {
    if (!filter_var($inpt, FILTER_VALIDATE_EMAIL)) {
        return (false);
    }
    return (true);
}

function validatePass($inpt) {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*.,;:\/\'`~\-_<>(){}\[\]])[a-zA-Z\d!@#$%^&*.,;:\/\'`~\-_<>(){}\[\]]{8,15}$/';
    if (!preg_match($pattern, $inpt)) {
        return (false);
    }
    return (true);
}
function validateContact($inpt) {
    $pattern = '/^(?:\+\d{12}|\d{10})$/';
    if (!preg_match($pattern, $inpt)) {
        return (false);
    }
    return (true);
}

function generateName($fnameOg) {
    $uniqueId = uniqid();
    $fileExt = pathinfo($fnameOg, PATHINFO_EXTENSION);
    return ($uniqueId. '.' . $fileExt);
}

function validateBrand($brand) {
    $pattern = '/^[a-zA-Z0-9\-_ .:&\'@#]+$/';
    if(!preg_match($pattern, $brand)) {
        return (false);
    }
    return (true);
}

function validateLocation($addr) {
    $pattern = '/^[a-zA-Z0-9\-_ .:\'#]+$/';
    if (!preg_match($pattern, $addr)) {
        return (false);
    }
    return (true);

}

function validateTime ($time) {
    $pattern = '/^(?:[01]\d|2[0-3]):(?:[0-5]\d)$/';
    if (!preg_match($pattern, $time)) {
        return (false);
    }
    return (true);
}
