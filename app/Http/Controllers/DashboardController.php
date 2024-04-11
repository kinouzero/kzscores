<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Party;

class DashboardController extends Controller {

  // Views
  public function dashboard() {
    $games = Game::all();
    $parties = Party::userParties();

    return view('dashboard', compact('games', 'parties'));
  }

  /**
   * Get chart data
   */
  public function getChart($type) {
    $data = [];


    return response()->json(array_values($data));
  }
}