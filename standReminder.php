#!/usr/bin/env php
<?php

$tillTime = null;
$standOnTime = null;

$standForTime = '20 min';
$standEvery = '1 hour';

$standSmiley = '/usr/share/icons/gnome/32x32/emotes/face-sad.png';
$doneSmiley = '/usr/share/icons/gnome/32x32/emotes/stock_smiley-15.png';
$startSmiley = '/usr/share/icons/gnome/32x32/emotes/face-smile-big.png';
$playSound = 'pacmd play-file \'/usr/share/sounds/ubuntu/notifications/Positive.ogg\' 1';

echo exec('notify-send -a "Stand reminder" -i ' . $startSmiley . ' -u critical -t 0 "Stand program started"');

while (true) {
    echo '$tillTime: ' . date('H:i:s', $tillTime) . PHP_EOL;
    echo '$standOnTime: ' . date('H:i:s', $standOnTime) . PHP_EOL;

    if ($tillTime !== null) {
        if ($tillTime < time()) {
            echo 'You may sit now' . PHP_EOL;

            echo exec('notify-send -a "Stand reminder" -i ' . $doneSmiley . ' -u critical -t 0 "You may sit now" && ' . $playSound);
            $tillTime = null;
            $standOnTime = null;
        }
    } elseif ($standOnTime === null) {
        $standOnTime = strtotime('+' . $standEvery);
        echo 'Stand on time: ' . date('H:i:s', $standOnTime) . PHP_EOL;
        echo exec('notify-send -a "Stand reminder" -i ' . $startSmiley . ' -u critical -t 0 "Stand on time: ' . date('H:i:s',
                $standOnTime) . '"  && ' . $playSound);
    } elseif ($standOnTime < time()) {
        $tillTime = strtotime('+' . $standForTime);

        echo exec('notify-send -a "Stand reminder" -i ' . $standSmiley . ' -u critical -t 0 "Time to stand for ' . $standForTime . ' till ' . date('H:i',
                $tillTime) . '"  && ' . $playSound);
        echo 'Time to stand for ' . $standForTime . '  till ' . date('H:i:s', $tillTime) . PHP_EOL;
    }
    sleep(1);
}

