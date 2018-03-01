<?php
if (preg_match('/\/api\/.*/', $_SERVER["REQUEST_URI"])){
    include __DIR__ . '/api'. DIRECTORY_SEPARATOR . 'wpos.php';
} else if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico|woff|tff|html)/', $_SERVER["REQUEST_URI"])) {
    return false;
} else if ($_SERVER["REQUEST_URI"] == '/admin/' || $_SERVER["REQUEST_URI"] == '/admin/?' || $_SERVER["REQUEST_URI"] == '/admin') {
    include __DIR__ . '/admin'. DIRECTORY_SEPARATOR . 'index.html';
} else if (preg_match('/\/admin\/content\/.*/', $_SERVER['REQUEST_URI'])) {
    $file = substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/')+1);
    include __DIR__ . '/admin'. DIRECTORY_SEPARATOR . 'content' . DIRECTORY_SEPARATOR . $file;
}else {
    include __DIR__ . '/index.html';
}