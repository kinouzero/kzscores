<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Option;
use App\Models\Party;
use App\Models\Preference;
use App\Models\Role;
use App\Models\User;
use App\Models\_Yams;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   */
  public function run(): void {

    // User admin
    $user1 = User::factory()->create([
      'name' => env('SEEDER_USER_NAME', 'User 1'),
      'email' => env('SEEDER_USER_MAIL', 'user1@email.com'),
      'password' => Hash::make(env('SEEDER_USER_PWD', 'user1')),
    ]);

    // $user2 = User::factory()->create([
    //   'name' => 'User 2',
    //   'email' => 'user2@email.com',
    //   'password' => Hash::make('user2'),
    // ]);

    // Roles
    Role::create(['name' => 'admin']);
    $player = Role::create(['name' => 'player']);
    $roles = Role::all();
    $user1->roles()->attach($roles);
    // $user2->roles()->attach($player);

    // Preferences
    // Preference::create(['key' => 'lang', 'name' => 'Language', 'type' => 'checklist', 'options' => json_encode(['en' => 'English', 'fr' => 'French'])]);
    Preference::create(['key' => 'theme', 'name' => 'Dark mode', 'type' => 'checklist', 'options' => json_encode(['dark' => 'Dark', 'light' => 'Light'])]);
    // Preference::create(['key' => 'table-length', 'name' => 'Table length', 'type' => 'checklist', 'options' => json_encode([10 => 10, 25 => 25, 50 => 50, 100 => 100])]);
    // Preference::create(['key' => 'timezone', 'name' => 'Timezone', 'type' => 'text']);

    // Games
    $yams = Game::create(['key' => 'yams', 'name' => 'Yams', 'icon' => 'fas fa-dice', 'color' => '#660000']);
    // Game::create(['key' => '421', 'name' => '421', 'icon' => 'fas fa-dice', 'color' => '#006600']);
    // Game::create(['key' => '5000', 'name' => '5000', 'icon' => 'fas fa-dice', 'color' => '#000066']);
    // Game::create(['key' => '10000', 'name' => '10000', 'icon' => 'fas fa-dice', 'color' => '#0000ee']);
    // $dart = Game::create(['key' => 'darts', 'name' => 'Darts', 'icon' => 'fas fa-bullseye', 'color' => '#ee0000']);
    // Game::create(['key' => 'petanque', 'name' => 'Petanque', 'icon' => 'fas fa-circle', 'color' => '#444444']);
    // Game::create(['key' => 'corsair', 'name' => 'Corsair', 'icon' => 'fas fa-skull-crossbones', 'color' => '#000000']);

    // $optionDart = Option::create(['name' => 'Dart mode', 'type' => 'select', 'properties' => json_encode(['301' => '301', '501' => '501', 'cricket' => 'Cricket'])]);

    // $dart->options()->attach($optionDart);

    // $party = Party::create(['game_id' => $yams->id]);
    // $scoreU1 = $scoreU2 = [];
    // foreach (_Yams::numbers as $number => $key) {
    //   $scoreU1[] = [$key => (int)$number * 3];
    //   $scoreU2[] = [$key => (int)$number * 2];
    // }
    // foreach (_Yams::figures as $figure => $props) {
    //   $scoreU1[] = [$figure => $props['max']];
    //   $scoreU2[] = [$figure => $props['min']];
    // }
    // $party->users()->attach($user1, ['current' => false, 'winner' => true, 'order' => 1, 'score' => json_encode($scoreU1)]);
    // $party->users()->attach($user2, ['current' => true, 'winner' => false, 'order' => 2, 'score' => json_encode($scoreU2)]);
  }
}
