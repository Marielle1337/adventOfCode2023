<?php
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
