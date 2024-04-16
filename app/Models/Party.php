<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model {

  protected $table = 'parties';

  protected $fillable = [
    'game_id'
  ];

  /**
   * Game
   */
  public function game() {
    return $this->belongsTo(Game::class, 'game_id', 'id');
  }

  /**
   * Options
   */
  public function options() {
    return $this->belongsToMany(Option::class, 'party_options', 'party_id', 'option_id')->withPivot('value');
  }

  /**
   * Users
   */
  public function users() {
    return $this->belongsToMany(User::class, 'party_users', 'party_id', 'user_id')->withPivot('order', 'score', 'winner', 'current')->orderByPivot('order');
  }

  /**
   * Winner
   */
  public function winner() {
    return $this->users()->wherePivot('winner', true)->first();
  }

  /**
   * Has winner
   */
  public function hasWinner() {
    return $this->winner() !== null;
  }

  /**
   * Current
   */
  public function current() {
    return $this->users()->wherePivot('current', true)->first();
  }

  /**
   * Next
   */
  public function next() {
    $current = $this->current();

    return $this->users()->where('order', $current->pivot->order === $this->users()->count() ? 0 : ++$current->pivot->order)->first();
  }

  /**
   * Previous
   */
  public function previous() {
    $current = $this->current();

    return $this->users()->where('order', $current->pivot->order === 1 ? $this->users()->count() : --$current->pivot->order)->first();
  }

  /**
   * Current user score
   */
  public function currentScore() {
    return json_decode($this->current()->pivot->score, true);
  }

  /**
   * Previous user score
   */
  public function previousScore() {
    return json_decode($this->previous()->pivot->score, true);
  }

  /**
   * End
   */
  public function end() {
    $winner = null;
    switch ($this->game->key) {
      case 'yam':
        $winner = _Yams::getWinner($this);
        break;
    }

    $this->users()->updateExistingPivot($winner->id, ['winner' => true]);
  }
}
