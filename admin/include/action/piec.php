<?php

$homiq->send('PA','O.7','1','0K');

sleep(2);
readfile('http://10.10.20.99/piec.jpg');

$homiq->send('PA','O.7','0','0K');
die();
