<?php


use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
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
                'title'   => 'Lorem ipsum',
                'body'    => "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
                'status'    => 'offline',
                'createdAt' => $date->modify('-1 day')->format('Y-m-d H:i:s'),
                'updatedAt' => $date->modify('-1 day')->format('Y-m-d H:i:s'),
            ],
            [
                'title'   => 'Dolor sit amet',
                'body'    => "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.",
                'status'    => 'online',
                'createdAt' => $date->format('Y-m-d H:i:s'),
                'updatedAt' => $date->format('Y-m-d H:i:s'),
            ]
        ];

        $table = $this->table('posts');
        $table->insert($data)
              ->saveData();
    }
}
