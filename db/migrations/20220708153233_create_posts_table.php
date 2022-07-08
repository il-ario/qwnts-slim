<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('posts');
        $table->addColumn('title', 'string')
              ->addColumn('body', 'string')
              ->addColumn('status', 'enum', ['values' => ['offline', 'online']], ['default' => 'offline'])
              ->addColumn('createdAt', 'timestamp', ['default' => date('Y-m-d H:i:s')])
              ->addColumn('updatedAt', 'timestamp', ['default' => date('Y-m-d H:i:s')])
              ->create();
    }
}
