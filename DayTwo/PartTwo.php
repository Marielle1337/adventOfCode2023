<?php

$gamesInput = trim(file_get_contents(__DIR__ . '/DayTwoGames.txt'));
$gamesArray = explode(PHP_EOL, $gamesInput);

function resolveGame(array $gamesArray): int {
    $result = 0;

    foreach ($gamesArray as $game) {
        preg_match_all('/Game (\d+):|(.*)/', $game, $matches);
        preg_match_all('#(\d+) (blue|red|green)#', $matches[0][1], $gameCombinations);

        $redIterationKeys = array_keys($gameCombinations[2], 'red', true);
        $blueIterationKeys = array_keys($gameCombinations[2], 'blue', true);
        $greenIterationKeys = array_keys($gameCombinations[2], 'green', true);

        $redCubesMinimum = 0;
        $blueCubesMinimum = 0;
        $greenCubesMinimum = 0;

        foreach ($redIterationKeys as $index) {
            if ($gameCombinations[1][$index] > $redCubesMinimum) {
                $redCubesMinimum = (int) $gameCombinations[1][$index];
            }
        }

        foreach ($blueIterationKeys as $index) {
            if ($gameCombinations[1][$index] > $blueCubesMinimum) {
                $blueCubesMinimum = (int) $gameCombinations[1][$index];
            }
        }

        foreach ($greenIterationKeys as $index) {
            if ($gameCombinations[1][$index] > $greenCubesMinimum) {
                $greenCubesMinimum = (int) $gameCombinations[1][$index];
            }
        }

        $result += $redCubesMinimum * $blueCubesMinimum * $greenCubesMinimum;
    }

    return $result;
}

function testResults($testsArray): void
{
    foreach ($testsArray as $name => $test) {
        $result = resolveGame($test['gamesArray']);

        var_dump($name . ' : ' .
            ($test['expectedResult'] === $result ? 'OK, ' : 'KO, ')
            . 'result ' . $result
        );
    }
}

$testsArray = [
    '1st Test' => [
        'gamesArray' => [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
            'Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red',
            'Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red',
            'Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green',
        ],
        'expectedResult' => 2286,
    ],
    '2nd Test' => [
        'gamesArray' => [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
        ],
        'expectedResult' => 48,
    ],
    '3rd Test' => [
        'gamesArray' => [
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
        ],
        'expectedResult' => 12,
    ],
    '4th Test' => [
        'gamesArray' => [
            'Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red',
        ],
        'expectedResult' => 1560,
    ],
    '5th Test' => [
        'gamesArray' => [
            'Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red',
        ],
        'expectedResult' => 630,
    ],
    '6th Test' => [
        'gamesArray' => [
            'Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green',
        ],
        'expectedResult' => 36,
    ],
];

var_dump('<-------- TESTS -------->');
testResults($testsArray);
var_dump('>-------- TESTS --------<');


var_dump(PHP_EOL,'Game Result : ' . resolveGame($gamesArray));
