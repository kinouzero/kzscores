<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Option;

class OptionController extends Controller {

  // Views
  public function index() {
    $options = Option::all();

    return view('option.index', compact('options'));
  }

  public function create() {
    $option = null;

    $title = 'Create new option';

    $types = [
      view('template.form.select.option', ['value' => 'text', 'title' => 'Text', 'selected' => false]),
      view('template.form.select.option', ['value' => 'number', 'title' => 'Number', 'selected' => false]),
      view('template.form.select.option', ['value' => 'select', 'title' => 'List', 'selected' => false])
    ];

    $template_properties = [
      view('template.form.row', [
        'id'        => null,
        'value'     => '',
        'key_value' => '',
        'type'      => 'text',
        'key'       => 'properties',
        'label'     => 'Key'
      ]),
      view('template.alert', ['color' => 'secondary', 'class' => null, 'content' => 'No property yet'])
    ];

    return view('option.edit', compact('option', 'title', 'types', 'template_properties'));
  }

  public function edit($id) {
    $option = Option::findOrFail($id);

    $title = sprintf('Edit option: %s', $option->name);

    $types = [
      view('template.form.select.option', ['value' => 'text', 'title' => 'Text', 'selected' => $option->type === 'text']),
      view('template.form.select.option', ['value' => 'number', 'title' => 'Number', 'selected' => $option->type === 'number']),
      view('template.form.select.option', ['value' => 'select', 'title' => 'List', 'selected' => $option->type === 'select'])
    ];

    $template_properties = [view('template.form.row', [
      'id'        => null,
      'value'     => '',
      'key_value' => '',
      'type'      => 'text',
      'key'       => 'options',
      'label'     => 'Key'
    ])];
    if ($option->properties()) foreach ($option->properties() as $k => $v) $template_properties[] = view('template.form.row', [
      'id'        => Str::uuid(),
      'key_value' => $k ?: '',
      'value'     => $v ?: '',
      'type'      => 'text',
      'key'       => 'options',
      'label'     => 'Key'
    ]);
    else $template_properties[] = view('template.alert', ['color' => 'secondary', 'class' => null, 'content' => 'No property yet']);

    return view('option.edit', compact('option', 'title', 'types', 'template_properties'));
  }

  public function detail($id) {
    $option = Option::findOrFail($id);

    return view('option.detail', compact('option'));
  }

  // Actions
  public function store(Request $request) {
    $option = new Option();

    $args = $request->all();

    $validatedData = $request->validate(['name' => 'required|string']);

    $option->name = $validatedData['name'];

    // Properties
    $properties = [];
    if ($args['properties']) foreach ($args['properties'] as $i => $k) if ($v = $args['values'][$i]) $properties[$k] = $v;
    $option->properties = json_encode($properties);

    $option->save();

    return back()->with('success', 'Option created successfully.');
  }

  public function update(Request $request, $id) {
    $option = Option::findOrFail($id);

    $args = $request->all();

    // Properties
    $properties = [];
    if ($args['properties']) foreach ($args['properties'] as $i => $k) if ($v = $args['values'][$i]) $properties[$k] = $v;
    $args['properties'] = json_encode($properties);

    $option->update($args);

    return back()->with('success', 'Option updated successfully.');
  }

  public function destroy($id) {
    $option = Option::findOrFail($id);
    $option->delete();

    return back()->with('success', 'Option deleted successfully.');
  }
}
