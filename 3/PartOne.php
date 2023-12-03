<?php

$puzzleInput = trim(file_get_contents(__DIR__ . '/DayThreePuzzle.txt'));
$puzzleArray = explode(PHP_EOL, $puzzleInput, 140);

function sumNumbersAdjacentToSymbols(array $puzzleArray): int
{
    $symbolCoordinates = [];
    $result = 0;

    for ($i = 0; $i < count($puzzleArray); $i++) {
        preg_match_all('#[^.0-9\n]+#', $puzzleArray[$i], $symbols, PREG_OFFSET_CAPTURE);

        foreach ($symbols[0] as $symbolInfos) {
            $symbolCoordinates[$i][] = $symbolInfos[1];
        }
    }

    for ($j = 0; $j < count($puzzleArray); $j++) {
        preg_match_all('#\d+#', $puzzleArray[$j], $digits, PREG_OFFSET_CAPTURE);

        foreach ($digits[0] as $digitInfos) {
            $digit = $digitInfos[0];
            $digitPosition = $digitInfos[1];
            $digitLength = strlen($digit);

            if ($digitLength > 1) {
                for ($k = 0; $k < $digitLength; $k++) {
                    if (
                        isset($symbolCoordinates[$j - 1])
                        && (in_array($digitPosition + $k - 1, $symbolCoordinates[$j - 1])
                        || in_array($digitPosition + $k, $symbolCoordinates[$j - 1])
                        || in_array($digitPosition + $k + 1, $symbolCoordinates[$j - 1]))
                        || isset($symbolCoordinates[$j])
                        && (in_array($digitPosition + $k - 1, $symbolCoordinates[$j])
                        || in_array($digitPosition + $k, $symbolCoordinates[$j])
                        || in_array($digitPosition + $k + 1, $symbolCoordinates[$j]))
                        || isset($symbolCoordinates[$j + 1])
                        && (in_array($digitPosition + $k - 1, $symbolCoordinates[$j + 1])
                        || in_array($digitPosition + $k, $symbolCoordinates[$j + 1])
                        || in_array($digitPosition + $k + 1, $symbolCoordinates[$j + 1]))
                    ) {
                        $result += (int)$digit;
                        break;
                    }
                }
            } else {
                if (
                    isset($symbolCoordinates[$j - 1])
                    && (in_array($digitPosition - 1, $symbolCoordinates[$j - 1])
                        || in_array($digitPosition, $symbolCoordinates[$j - 1])
                        || in_array($digitPosition + 1, $symbolCoordinates[$j - 1]))
                    || isset($symbolCoordinates[$j])
                    && (in_array($digitPosition - 1, $symbolCoordinates[$j])
                        || in_array($digitPosition, $symbolCoordinates[$j])
                        || in_array($digitPosition + 1, $symbolCoordinates[$j]))
                    || isset($symbolCoordinates[$j + 1])
                    && (in_array($digitPosition - 1, $symbolCoordinates[$j + 1])
                        || in_array($digitPosition, $symbolCoordinates[$j + 1])
                        || in_array($digitPosition + 1, $symbolCoordinates[$j + 1]))
                ) {
                    $result += (int)$digit;
                }
            }
        }
    }

    return $result;
}

function testResults($testsArray): void
{
    foreach ($testsArray as $name => $test) {
        $result = sumNumbersAdjacentToSymbols($test['gamesArray']);

        var_dump($name . ' : ' .
            ($test['expectedResult'] === $result ? 'OK, ' : 'KO, ')
            . 'expected ' . $test['expectedResult'] . ', '
            . 'result ' . $result
        );
    }
}

$testsArray = [
    '1st Test' => [
        'gamesArray' => [
            '467..114..',
            '...*......',
            '..35..633.',
            '......#...',
            '617*......',
            '.....+.58.',
            '..592.....',
            '......755.',
            '...$.*....',
            '.664.598..',
        ],
        'expectedResult' =>  4361,
    ],
];

var_dump('<-------- TESTS -------->');
testResults($testsArray);
var_dump('>-------- TESTS --------<');


var_dump(PHP_EOL,'Game Result : ' . sumNumbersAdjacentToSymbols($puzzleArray));
