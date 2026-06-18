<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BshafferOauth extends Seeder
{
    public function run()
    {
        $data = [
            'client_id' => 'TestClient',
            'client_secret' => 'test_secret',
            'redirect_uri' => 'http://localhost:8080',
            'grant_types' => 'password',
        ];

        $this->db->table('oauth_clients')->insert($data);
        
        echo "Test client created: client_id=TestClient, client_secret=test_secret\n";
    }
}