<?php

$gamesInput = trim(file_get_contents(__DIR__ . '/DayTwoGames.txt'));
$gamesArray = explode(PHP_EOL, $gamesInput);

$cubesNumber = [
    'red' => 12,
    'blue' => 14,
    'green' => 13,
];

function resolveGame(array $gamesArray, array $cubesNumber): int {
    $result = 0;

    foreach ($gamesArray as $game) {
        preg_match_all('/Game (\d+):|(.*)/', $game, $matches);
        $gameId = $matches[1][0];

        preg_match_all('#(\d+) (blue|red|green)#', $matches[0][1], $gameCombinations);

        $redIterationKeys = array_keys($gameCombinations[2], 'red', true);
        $blueIterationKeys = array_keys($gameCombinations[2], 'blue', true);
        $greenIterationKeys = array_keys($gameCombinations[2], 'green', true);

        $gameOk = true;

        foreach ($redIterationKeys as $index) {
            if ($gameOk === true && $gameCombinations[1][$index] > $cubesNumber['red']) {
                $gameOk = false;
            }
        }

        foreach ($blueIterationKeys as $index) {
            if ($gameOk === true && $gameCombinations[1][$index] > $cubesNumber['blue']) {
                $gameOk = false;
            }
        }

        foreach ($greenIterationKeys as $index) {
            if ($gameOk === true && $gameCombinations[1][$index] > $cubesNumber['green']) {
                $gameOk = false;
            }
        }

        if ($gameOk === true) {
            $result += (int) $gameId;
        }

        //var_dump($matches[0][1], $matches[0][0] . ($gameOk ? ' OK' : ' XX'));
    }

    return $result;
}

function testResults($testsArray): void
{
    foreach ($testsArray as $name => $test) {
        $result = resolveGame(
            $test['gamesArray'],
            $test['cubesNumber']
        );

        var_dump($name . ' : ' .
            ($test['expectedResult'] === $result ? 'OK, ' : 'KO, ')
            . 'result ' . $result
        );
    }
}

$testsArray = [
    'First Test' => [
        'gamesArray' => [
            'Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green',
            'Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue',
            'Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red',
            'Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red',
            'Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green',
        ],
        'cubesNumber' => $cubesNumber,
        'expectedResult' => 8,
    ]
];

var_dump('<-------- TESTS -------->');
testResults($testsArray);
var_dump('>-------- TESTS --------<');


var_dump(PHP_EOL,'Game Result : ' . resolveGame($gamesArray, $cubesNumber));
