<?php

$puzzleInput = trim(file_get_contents(__DIR__ . '/DayOnePuzzle.txt'));

$puzzleArray = explode(PHP_EOL, $puzzleInput);
$result = 0;

$digits = [
    'one' => 1,
    'two' => 2,
    'three' => 3,
    'four' => 4,
    'five' => 5,
    'six' => 6,
    'seven' => 7,
    'eight' => 8,
    'nine' => 9
];

foreach ($puzzleArray as $puzzlePiece) {
    preg_match_all('#(?=(\d|one|two|three|four|five|six|seven|eight|nine))#', $puzzlePiece, $matches);

    $firstNumber = $matches[1][0];
    $lastNumber = end($matches[1]);

    if (!is_numeric($firstNumber)) {
        $firstNumber = $digits[$firstNumber];
    }

    if (!is_numeric($lastNumber)) {
        $lastNumber = $digits[$lastNumber];
    }

    $number = $firstNumber . $lastNumber;
    $result += (int) $number;
}

var_dump('finalResult : ' . $result);
