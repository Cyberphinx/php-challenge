# Installing PHP

## MAC
1. Install homebrew
    1. https://brew.sh/
    2. Homebrew is a package manager, which helps install and manage packages
2. Install php
    1. https://formulae.brew.sh/formula/php
    2. brew install php

## Windows
1. Install chocolatey
    1. https://chocolatey.org/install
    2. Chocolatey is a package manager, which helps install and manage packages
2. Install php
    1. https://community.chocolatey.org/packages/php
    2. choco install php

## Linux

### Debian
1. Add ondrej's package list to your repository
    1. sudo add-apt-repository ppa:ondrej/php && sudo apt update
    2. You can read more about this repository here https://launchpad.net/~ondrej/+archive/ubuntu/php 
2. Install php 8.1 and the xml extension
    1. sudo apt install php8.1 php8.1-xml

### CentOS
1. Run the install command
    1. sudo yum -y install php php-xml

### Arch
1. Run the install command
    1. sudo pacman -S php


## Installing Composer
Must be done after installing PHP.
Composer is a package manager for PHP, it helps keep packages up to date and makes sure package requirements
don't conflict.
Follow these instructions https://getcomposer.org/download/


After installing php and composer run `php check.php` to make sure all the required softwares are installed