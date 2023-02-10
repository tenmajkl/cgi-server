<?php

if (file_exists('server')) {
    unlink('server');
}

$phar = new Phar('server.phar');
$phar->startBuffering();
$stub = "#!/usr/bin/env php \n".$phar->createDefaultStub('server.php');
$phar->buildFromDirectory(__DIR__);

$phar->setStub($stub);

$phar->stopBuffering();

$phar->compressFiles(Phar::GZ);

chmod('server.phar', 0770);
