<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $date = new \DateTime();
        $data = [
            [
                'givenName'   => 'Mario',
                'familyName'   => 'Mario',
                'email'    => 'mario@bros.com',
                'birthDate'    => '1981-01-01',
                'password'    => sha1('Password1.'),
                'createdAt' => $date->modify('-1 day')->format('Y-m-d H:i:s'),
                'updatedAt' => $date->modify('-1 day')->format('Y-m-d H:i:s'),
            ],
            [
                'givenName'   => 'Luigi',
                'familyName'   => 'Mario',
                'email'    => 'luigimario@bros.com',
                'birthDate'    => NULL,
                'password'    => sha1('Password1.'),
                'createdAt' => $date->format('Y-m-d H:i:s'),
                'updatedAt' => $date->format('Y-m-d H:i:s'),
            ]
        ];

        $table = $this->table('users');
        $table->insert($data)
              ->saveData();
    }
}
