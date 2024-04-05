<?php

namespace Database\Seeders;

use App\Models\Preference;
use App\Models\Role;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   */
  public function run(): void {

    // User admin
    $user = User::factory()->create([
      'name' => env('SEEDER_USER_NAME', 'User 1'),
      'email' => env('SEEDER_USER_MAIL', 'email@example.com'),
      'password' => Hash::make(env('SEEDER_USER_PWD', 'user')),
    ]);

    // Roles
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'user']);
    $roles = Role::all();
    $user->roles()->attach($roles);

    // Preferences
    Preference::create(['key' => 'lang', 'name' => 'Language', 'type' => 'checklist', 'options' => json_encode(['props' => ['en' => 'English', 'fr' => 'French']])]);
    Preference::create(['key' => 'theme', 'name' => 'Dark mode', 'type' => 'checklist', 'options' => json_encode(['props' => ['dark' => 'dark', 'light' => 'light']])]);
    Preference::create(['key' => 'table-length', 'name' => 'Table length', 'type' => 'checklist', 'options' => json_encode(['props' => [10 => 10, 25 => 25, 50 => 50, 100 => 100]])]);
    Preference::create(['key' => 'timezone', 'name' => 'Timezone', 'type' => 'text']);
  }
}
