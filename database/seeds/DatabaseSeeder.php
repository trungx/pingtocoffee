<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        switch (\Illuminate\Support\Facades\App::environment()) {
            case 'local':
                $this->call(FakeUserTableSeeder::class);
                $this->call(UserTableSeeder::class);
                $this->call(RelationshipTableSeeder::class);
                $this->call(ContactLogTableSeeder::class);
                $this->call(ReminderTableSeeder::class);
                $this->call(ContactFieldValueTableSeeder::class);
                $this->call(NoteTableSeeder::class);
                $this->call(DebtTableSeeder::class);
                break;
            case 'testing':
                $this->call(FakeUserTableSeeder::class);
                break;
            case 'production':
                break;
            default:
                break;
        }
    }
}
