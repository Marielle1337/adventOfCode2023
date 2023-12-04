<?php

require_once(__DIR__ . '/../TestResults.php');

$cardsInput = trim(file_get_contents(__DIR__ . '/DayFourCards.txt'));
$cardsArray = explode(PHP_EOL, $cardsInput);

$testsArray = [
    '1st Test' => [
        'gamesArray' => [
            'Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53',
        ],
        'expectedResult' => 8,
    ],
    '2nd Test' => [
        'gamesArray' => [
            'Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19',
        ],
        'expectedResult' => 2,
    ],
    '3rd Test' => [
        'gamesArray' => [
            'Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1',
        ],
        'expectedResult' => 2,
    ],
    '4th Test' => [
        'gamesArray' => [
            'Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83',
        ],
        'expectedResult' => 1,
    ],
    '5th Test' => [
        'gamesArray' => [
            'Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36',
        ],
        'expectedResult' => 0,
    ],
    '6th Test' => [
        'gamesArray' => [
            'Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11',
        ],
        'expectedResult' => 0,
    ],
    '7th Test' => [
        'gamesArray' => [
            'Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53',
            'Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19',
            'Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1',
            'Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83',
            'Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36',
            'Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11',
        ],
        'expectedResult' => 13,
    ],
    '8th Test' => [
        'gamesArray' => [
            'Card   1: 33 34 29 52 91  7 31 42  2  6 | 53 52  6 96 42 91  2 23  7 38 90 28 31 51  1 26 33 22 95 34 29 77 32 86  3',
        ],
        'expectedResult' => 512,
    ],
    '9th Test' => [
        'gamesArray' => [
            'Card 209: 61  7  9 81 20 54 92 74 53 63 | 85  4 79 68 58 91 90 71 50 30 65 17 18 77 76 22 82 47 84 75 59 32 57 35 86',
        ],
        'expectedResult' => 0,
    ],
    '10th Test' => [
        'gamesArray' => [
            'Card 171: 25 53 36 62 75 45 87 41 61 78 | 28 10 52 59 98 38 79 77 53 31 63 90 58 16 42 21 83 92 46 44  8 43 97 34 41',
        ],
        'expectedResult' => 2,
    ]
];

function resolveGame(array $cardsArray): int
{
    $result = 0;

    foreach ($cardsArray as $card) {
        list($winningNumbers, $numbers) = explode('|', $card);
        preg_match_all('#\d+#', $winningNumbers, $winningNumbersMatched);
        preg_match_all('#\d+#', $numbers, $numbersMatched);
        unset($winningNumbersMatched[0][0]);

        $winningNumbers = $winningNumbersMatched[0];
        $numbers = $numbersMatched[0];
        $winningNumbersFound = 0;

        foreach ($numbers as $number) {
            if (in_array($number, $winningNumbers)) {
                $winningNumbersFound++;
            }
        }

        if ($winningNumbersFound > 0) {
            $result += pow( 2, $winningNumbersFound-1);
        }
    }

    return $result;
}

var_dump('<-------- TESTS -------->');
testResults($testsArray);
var_dump('>-------- TESTS --------<');


var_dump(PHP_EOL,'Game Result : ' . resolveGame($cardsArray));
