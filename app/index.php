<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

$dispatcher = new Foo\Core\Dispatcher();
$dispatcher->dispatch();
?>
