<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\_Yams;
use App\Models\Option;
use Illuminate\Http\Request;

use App\Models\Party;
use App\Models\User;

class PartyController extends Controller {

  // Views
  public function new($game_id) {
    $game = Game::findOrFail($game_id);

    $title = sprintf('New game of %s', strtolower($game->name));

    $template_options = [];
    if ($game->options->count() > 0) foreach ($game->options as $option) {
      if ($option->type === 'select') {
        $option_properties = [];
        if ($props = $option->properties()) foreach ($props as $k => $v) $option_properties[] = view('template.form.select.option', ['value' => $k, 'title' => $v, 'selected' => false]);
        $template_options[] = view('template.form.floating', [
          'type' => $option->type,
          'id' => sprintf('option-%s', $option->id),
          'name' => sprintf('options[%s]', $option->id),
          'label' => $option->name,
          'placeholder' => sprintf('Select %s', strtolower($option->name)),
          'options' => implode('', $option_properties),
          'class' => ['parent' => 'mb-3', 'input' => 'select2'],
          'extra' => ['input' => 'required'],
        ]);
      } else $template_options[] =  view('template.form.floating', [
        'type' => $option->type,
        'id' => $option->key,
        'name' => $option->key,
        'label' => $option->label,
        'value' => null,
        'class' => ['parent' => 'mb-3'],
        'extra' => ['input' => 'required'],
      ]);
    }

    return view('party.new', compact('game', 'title', 'template_options'));
  }

  public function play($id) {
    $party = Party::findOrFail($id);

    if ($party->winner()) return redirect()->route('party.results', ['id' => $party->id]);

    $sheets = [];
    foreach ($party->users as $user) {
      $score = collect(json_decode($user->pivot->score, true));
      switch ($party->game->key) {
        case 'yams':
          $numbers = _Yams::numbers;
          $figures = _Yams::figures;
          $sheets[] = view(sprintf('template.game.%s', $party->game->key), compact('party', 'user', 'score', 'numbers', 'figures'));
          break;
      }
    }

    return view('party.play', compact('party', 'sheets'));
  }

  public function results($id) {
    $party = Party::findOrFail($id);

    if ($winner = $party->winner()) $template = view('template.game.results.yams', compact('party'));
    else $template = view('template.alert', [
      'color' => 'danger',
      'content' => 'No winner yet',
      'class' => 'text-center mb-0'
    ]);

    return view('party.results', compact('party', 'template'));
  }

  // Actions
  public function store(Request $request) {
    $party = new Party();

    $args = $request->all();

    $validatedData = $request->validate(['game_id' => 'required|integer']);

    $party->game_id = $validatedData['game_id'];
    $party->save();
    $players = array_values(array_filter($args['players']));

    if (isset($args['random'])) shuffle($players);

    // Options
    if (isset($args['options'])) foreach ($args['options'] as $option_id => $value) {
      $option = Option::find($option_id)->first();
      if ($option) $party->options()->attach($option, ['value' => $value]);
    }

    // Players
    if (!isset($players)) return back()->withInput()->with('error', 'No players selected.');
    foreach ($players as $i => $player) {
      $user = null;
      $order = $i + 1;
      error_log('player : ' . $player . ' ' . is_numeric($player));
      if (is_numeric($player)) $user = User::where('id', $player)->first();
      elseif ($player) $user = User::newPlayer($player);
      error_log('user : ' . $user->id . ' name : ' . $user->name);
      if ($user) $party->users()->attach($user, ['order' => $order, 'current' => $order === 1]);
    }

    return redirect()->route('party.play', ['id' => $party->id])->with('success', 'Good luck<i class="far fa-thumbs-up ms-2"></i>');
  }

  public function next(Request $request, $id) {
    $party   = Party::findOrFail($id);
    $current = $party->current();
    $next    = $party->next();
    $score   = $party->currentScore();

    $score[] = collect($request->inputs)->whereNotNull()->all();

    $party->users()->updateExistingPivot($current->id, ['score' => json_encode($score), 'current' => false]);
    $party->users()->updateExistingPivot($next->id, ['current' => true]);

    switch ($party->game->key) {
      case 'yams':
        if ($current->pivot->order === $party->users()->count() && count($score) === 13) $party->end();
        break;
    }

    return back()->with('success', 'Next player.');
  }

  public function previous(Request $request, $id) {
    $party    = Party::findOrFail($id);
    $current  = $party->current();
    $previous = $party->previous();
    $score    = $party->PreviousScore();

    array_pop($score);

    $party->updateExistingPivot($current->id, ['current' => false]);
    $party->updateExistingPivot($previous->id, ['score' => json_encode($score), 'current' => true]);

    return back()->with('success', 'Previous player.');
  }

  public function destroy($id) {
    $party = Party::findOrFail($id);
    $party->delete();

    return back()->with('success', 'Party deleted successfully.');
  }

  public function end(Request $request, $id) {
    $party = Party::findOrFail($id);
    $party->end();

    return redirect()->route('party.results')->with('success', 'Game ended successfully.');
  }

  /**
   * Get chart data
   */
  public function getChart($id) {
    $party  = Party::find($id);
    $winner = $party->winner();

    $data = [];
    foreach ($party->users()->get() as $user) {
      switch ($party->game->key) {
        case 'yams':
          $count = _Yams::calculTotal($user);
          break;
      }
      $data[] = ['name' => $user->name, 'count' => $count, 'color' => $winner->id === $user->id ? '#00c853' : '#ff1744'];
    }

    return response()->json(array_values($data));
  }
}
