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
        /**
         * Seeder for local environment.
         */
        if (env('APP_ENV') == 'local') {
            // Fake 2 users easy remember information
            $this->call(FakeUserTableSeeder::class);
            $this->call(UserTableSeeder::class);
            $this->call(RelationshipTableSeeder::class);
            $this->call(ContactLogTableSeeder::class);
            $this->call(ReminderTableSeeder::class);
            $this->call(ContactFieldValueTableSeeder::class);
        }

        /**
         * Seeder for testing environment.
         */
        if (env('APP_ENV') == 'testing') {
            // Fake 2 users easy remember information
            $this->call(FakeUserTableSeeder::class);
            $this->call(UserTableSeeder::class);
            $this->call(RelationshipTableSeeder::class);
            $this->call(ContactLogTableSeeder::class);
            $this->call(ReminderTableSeeder::class);
            $this->call(ContactFieldValueTableSeeder::class);
        }

        /**
         * Seeder for production environment.
         */
        if (env('APP_ENV') == 'production') {
            // Do something
        }
    }
}
