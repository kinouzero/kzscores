<?php

namespace App\Http\Controllers;

use App\Models\Dashboard;
use App\Models\Plant;
use App\Models\Statut;
use App\Models\Strain;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller {

  // Views
  public function dashboard() {
    return view('dashboard');
  }

  /**
   * Get chart data
   */
  public function getChart($type) {
    $data = [];


    return response()->json(array_values($data));
  }
}
