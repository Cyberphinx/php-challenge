<?php

$versionInstalled = phpversion();
if (version_compare($versionInstalled, '8.1', '<')) {
    echo "You have PHP {$versionInstalled} and this project requires PHP 8.1 or greater.\n";
    echo "Please review the setup guide or phone Gloversure for help.";
    exit();
}

if (!extension_loaded('xml')) {
    echo "The XML extension for PHP has not been installed.\n";
    echo "Please review the setup guide or phone Gloversure for help.";
    exit();
}

$output = false;
exec('composer --version', $output);

if (!is_array($output) || !isset($output[0]) || !$output[0]) {
    echo "We couldn't find composer in your path.\n";
    echo "You can run composer via `php composer.phar` or you can move it to a directory in your path to just run `composer` instead.\n";
    echo "If you can run `php composer.phar --version` successfully you are ready to run the challenge.\n";
    echo "Otherwise, please view the setup guide or phone Gloversure for help."; 
    exit();
}

echo "You are are ready to run the challenge.";