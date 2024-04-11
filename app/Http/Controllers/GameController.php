<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Game;
use App\Models\Option;

class GameController extends Controller {

  // Views
  public function index() {
    $games = Game::all();

    return view('game.index', compact('games'));
  }

  public function create() {
    $game    = null;
    $options = Option::all();

    $title = 'Create new game';

    $game_options = [];
    foreach ($options as $option) $game_options[] = view('template.form.select.option', ['value' => $option->id, 'title' => $option->name, 'selected' => false]);

    return view('game.edit', compact('game', 'title', 'game_options'));
  }

  public function edit($id) {
    $game = Game::findOrFail($id);
    $options = Option::all();

    $title = sprintf('Edit game: %s', $game->name);

    $game_options = [];
    foreach ($options as $option) $game_options[] = view('template.form.select.option', ['value' => $option->id, 'title' => $option->name, 'selected' => $game->options->contains('id', $option->id)]);

    return view('game.edit', compact('game', 'title', 'game_options'));
  }

  // Actions
  public function store(Request $request) {
    $game = new Game();

    $validatedData = $request->validate([
      'name' => 'required|string',
      'key' => 'required|string',
      'description' => 'string',
      'icon' => 'required|string',
      'color' => 'required|string'
    ]);

    $game->name        = $validatedData['name'];
    $game->key         = $validatedData['key'];
    $game->description = $validatedData['description'];
    $game->icon        = $validatedData['icon'];
    $game->color       = $validatedData['color'];
    $game->save();

    // Options
    $options = isset($args['options']) ? Option::whereIn('id', $args['options'])->get() : null;
    $game->options()->attach($options ? $options->pluck('id')->toArray() : []);

    return back()->with('success', 'Game created successfully.');
  }

  public function update(Request $request, $id) {
    $game = Game::findOrFail($id);

    $args = $request->all();

    // Dashboards
    $options = isset($args['options']) ? Option::whereIn('id', $args['options'])->get() : null;
    $game->options()->sync($options ? $options->pluck('id')->toArray() : []);
    unset($args['options']);

    $game->update($args);

    return back()->with('success', 'Game updated successfully.');
  }

  public function destroy($id) {
    $game = Game::findOrFail($id);
    $game->delete();

    return back()->with('success', 'Game deleted successfully.');
  }
}
