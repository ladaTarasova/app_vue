<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBshafferOAuthTables extends Migration
{
    public function up()
    {
        // Таблица oauth_clients
        if (!$this->db->tableExists('oauth_clients')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => false,
                    'auto_increment' => true,
                ],
                'client_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'client_secret' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'redirect_uri' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'grant_types' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'scope' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'user_id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('user_id', 'users', 'id', 'RESTRICT', 'RESTRICT');
            $this->forge->createTable('oauth_clients', true);
        }

        // Таблица oauth_access_tokens
        if (!$this->db->tableExists('oauth_access_tokens')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => false,
                    'auto_increment' => true,
                ],
                'access_token' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'client_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'user_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'expires' => [
                    'type' => 'TIMESTAMP',
                    'null' => true,
                ],
                'scope' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('oauth_access_tokens', true);
        }

        // Таблица oauth_refresh_tokens
        if (!$this->db->tableExists('oauth_refresh_tokens')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => false,
                    'auto_increment' => true,
                ],
                'refresh_token' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'client_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'user_id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'expires' => [
                    'type' => 'TIMESTAMP',
                    'null' => true,
                ],
                'scope' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('oauth_refresh_tokens', true);
        }

        // Таблица oauth_scopes (если нужна)
        if (!$this->db->tableExists('oauth_scopes')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'unsigned' => true,
                    'null' => false,
                    'auto_increment' => true,
                ],
                'scope' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false,
                ],
                'is_default' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'null' => false,
                    'default' => 0,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('oauth_scopes', true);
        }
    }

    public function down()
    {
        $this->forge->dropTable('oauth_scopes', true);
        $this->forge->dropTable('oauth_refresh_tokens', true);
        $this->forge->dropTable('oauth_access_tokens', true);
        $this->forge->dropTable('oauth_clients', true);
    }
}