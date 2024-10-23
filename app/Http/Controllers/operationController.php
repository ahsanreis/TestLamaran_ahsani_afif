<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class operationController extends Controller
{
    public function countPairs(array $arr, int $targetNumber) : JsonResponse {
        $pairs = 0;
        $samePairs = [];

        foreach ($arr as $baitNumber) {
            foreach ($arr as $fishNumber) {
                if ($baitNumber + $fishNumber == $targetNumber && !in_array([$baitNumber, $fishNumber], $samePairs)) {
                    $pairs++;
                    $samePairs[] = [$baitNumber, $fishNumber];
                }
            }
        }

        return response()->json([
            'pairs' => $pairs,
            'samePairs' => $samePairs
        ]);
    }
}
