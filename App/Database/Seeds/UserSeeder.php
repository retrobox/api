<?php

use Carbon\Carbon;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $this->table('users')->truncate();
        $instant = Carbon::now()->toDateTimeString();
        $this->insert('users', [
            ['id' => '000_start'], // we use this non sense user to see if there is an issue with the process of retrieving item from the database, for example if a errored piece of code always fetch the first item from a table.
            [
                'id' => 'lambda-user-a',
                'last_username' => 'Lambda user A',
                'last_email' => 'lambda-user-a@example.com',
                'created_at' => $instant,
                'updated_at' => $instant
            ], [
                'id' => 'lambda-user-b',
                'last_username' => 'Lambda user B',
                'last_email' => 'lambda-user-b@example.com',
                'created_at' => $instant,
                'updated_at' => $instant
            ], [
                'id' => 'admin-user-A',
                'last_username' => 'Admin user A',
                'last_email' => 'admin-user-a@example.com',
                'is_admin' => true,
                'created_at' => $instant,
                'updated_at' => $instant
            ]]);
    }
}
