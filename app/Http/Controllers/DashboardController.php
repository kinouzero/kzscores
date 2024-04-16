<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;

class DashboardController extends Controller {

  // Views
  public function dashboard() {
    $games = Game::all();
    /** @var User $user */ // Hack for undefined method issue in vscode
    $user     = auth()->user();
    $actives  = $user->actives();
    $finished = $user->finished(9);
    $counts   = [
      'actives' => $user->finished()->count(),
      'finished' => $user->actives()->count()
    ];

    return view('dashboard', compact('games', 'actives', 'finished', 'counts'));
  }

  /**
   * Get chart data
   */
  public function getChart($type) {
    $data = [];


    return response()->json(array_values($data));
  }
}
