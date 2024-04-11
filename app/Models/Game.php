<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {

  protected $table = 'games';

  protected $fillable = [
    'key',
    'name',
    'description',
    'icon',
    'color'
  ];

  /**
   * Options
   */
  public function options() {
    return $this->belongsToMany(Option::class, 'game_options', 'game_id', 'option_id');
  }
}
