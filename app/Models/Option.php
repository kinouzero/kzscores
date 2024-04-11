<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

  protected $table = 'options';

  protected $fillable = [
    'name',
    'type'
  ];

  /**
   * Properties
   */
  public function properties() {
    return json_decode($this->properties, true);
  }
}
