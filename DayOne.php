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
    preg_match_all('#\d|(?=(one|two|three|four|five|six|seven|eight|nine))#', $puzzlePiece, $matches);

    for ($i = 0; $i < count($matches[0]); $i++) {
        $matches[0][$i] = !empty($matches[0][$i]) ? $matches[0][$i] : $matches[1][$i];
    }

    $firstNumber = $matches[0][0];
    $lastNumber = end($matches[0]);

    if (!is_numeric($firstNumber)) {
        $firstNumber = $digits[$firstNumber];
    }

    if (!is_numeric($lastNumber)) {
        $lastNumber = $digits[$lastNumber];
    }

    $number = $firstNumber . $lastNumber;
    $result += $number;
}

var_dump('finalResult : ' . $result);
