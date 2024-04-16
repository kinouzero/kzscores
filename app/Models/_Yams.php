<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class _Yams extends Model {

  const numbers = [1 => 'number-1', 2 => 'number-2', 3 => 'number-3', 4 => 'number-4', 5 => 'number-5', 6 => 'number-6'];
  const figures = [
    'brelan' => ['label' => 'Brelan<span class="ms-1" style="font-size:.8em">(somme des dés avec 3 identiques)</span>', 'min' => 0, 'max' => 30],
    'small-suite' => ['label' => 'Petite suite<span class="ms-1" style="font-size:.8em">(20)</span>', 'min' => 0, 'max' => 20, 'modulo' => 20],
    'large-suite' => ['label' => 'Grande suite<span class="ms-1" style="font-size:.8em">(25)</span>', 'min' => 0, 'max' => 25, 'modulo' => 25],
    'full' => ['label' => 'Full<spa class="ms-1" style="font-size:.8em"n>(30)</spa>', 'min' => 0, 'max' => 30, 'modulo' => 30],
    'carre' => ['label' => 'Carré<span class="ms-1" style="font-size:.8em">(40)</span>', 'min' => 0, 'max' => 40, 'modulo' => 40],
    'yams' => ['label' => 'Yams<span class="ms-1" style="font-size:.8em">(50)</span>', 'min' => 0, 'max' => 50, 'modulo' => 50],
    'chance' => ['label' => 'Chance<span class="ms-1" style="font-size:.8em">(somme des dés)</span>', 'min' => 0, 'max' => 30]
  ];

  public static function getWinner($party) {
    $max_value = 0;
    $winner = null;

    foreach ($party->users as $user) {
      $value = self::calculTotal($user);
      if ($value > $max_value) {
        $max_value = $value;
        $winner = $user;
      }
    }

    return $winner;
  }

  public static function calculTotal($user) {
    $total_numbers = 0;
    $total_figures = 0;
    $total = 0;

    $score = collect(json_decode($user->pivot->score, true));

    foreach (self::numbers as $number => $key) $total_numbers += $score->pluck($key)->filter()->first();
    foreach (self::figures as $figure => $props) $total_figures += $score->pluck($figure)->filter()->first();
    if ($total_numbers >= 63) $total_numbers += 35;

    $total = $total_numbers + $total_figures;

    return $total;
  }
}
