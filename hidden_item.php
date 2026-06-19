<?php

/*
|--------------------------------------------------------------------------
| Hidden Item Game
|--------------------------------------------------------------------------
|
| # = Obstacle
| . = Clear Path
| X = Start Position
|
| Player movement:
| 1. North (A steps)
| 2. East (B steps)
| 3. South (C steps)
|
| Find all possible item locations.
|
*/

$grid = [
    "########",
    "#......#",
    "#.###..#",
    "#...#.##",
    "#X#....#",
    "########"
];

$rows = count($grid);
$cols = strlen($grid[0]);

$startRow = -1;
$startCol = -1;

/*
|--------------------------------------------------------------------------
| Find Starting Position (X)
|--------------------------------------------------------------------------
*/

for ($r = 0; $r < $rows; $r++) {

    for ($c = 0; $c < $cols; $c++) {

        if ($grid[$r][$c] === 'X') {

            $startRow = $r;
            $startCol = $c;

            break 2;
        }
    }
}

if ($startRow === -1) {

    die("Starting position X not found");
}

$possibleLocations = [];

/*
|--------------------------------------------------------------------------
| Try All North -> East -> South Paths
|--------------------------------------------------------------------------
*/

for ($a = 1;; $a++) {

    $northRow = $startRow - $a;

    if (
        $northRow < 0 ||
        $grid[$northRow][$startCol] === '#'
    ) {
        break;
    }

    for ($b = 1;; $b++) {

        $eastCol = $startCol + $b;

        if (
            $eastCol >= $cols ||
            $grid[$northRow][$eastCol] === '#'
        ) {
            break;
        }

        for ($c = 1;; $c++) {

            $southRow = $northRow + $c;

            if (
                $southRow >= $rows ||
                $grid[$southRow][$eastCol] === '#'
            ) {
                break;
            }

            $key =
                $southRow .
                '-' .
                $eastCol;

            $possibleLocations[$key] = [
                'row' => $southRow,
                'col' => $eastCol
            ];
        }
    }
}

/*
|--------------------------------------------------------------------------
| Display Coordinates
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "START POSITION";
echo PHP_EOL;
echo "==============";
echo PHP_EOL;
echo "(" . $startRow . "," . $startCol . ")";
echo PHP_EOL;

echo PHP_EOL;
echo "POSSIBLE ITEM LOCATIONS";
echo PHP_EOL;
echo "=======================";
echo PHP_EOL;

foreach ($possibleLocations as $location) {

    echo "(" .
        $location['row'] .
        "," .
        $location['col'] .
        ")";
    echo PHP_EOL;
}

/*
|--------------------------------------------------------------------------
| Convert Grid To Mutable Array
|--------------------------------------------------------------------------
*/

$gridArray = [];

foreach ($grid as $row) {

    $gridArray[] = str_split($row);
}

/*
|--------------------------------------------------------------------------
| Mark Possible Locations With $
|--------------------------------------------------------------------------
*/

foreach ($possibleLocations as $location) {

    $r = $location['row'];
    $c = $location['col'];

    if ($gridArray[$r][$c] === '.') {

        $gridArray[$r][$c] = '$';
    }
}

/*
|--------------------------------------------------------------------------
| Display Grid
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "GRID";
echo PHP_EOL;
echo "====";
echo PHP_EOL;

foreach ($gridArray as $row) {

    echo implode('', $row);
    echo PHP_EOL;
}
