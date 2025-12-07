<?php
if (extension_loaded('pdo_mysql')) {
    echo "pdo_mysql LOADED\n";
    exit(0);
} else {
    echo "pdo_mysql NOT LOADED\n";
    exit(1);
}
