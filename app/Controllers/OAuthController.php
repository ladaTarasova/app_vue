<?php

namespace App\Controllers;

use App\Services\OAuth;
use OAuth2\Request;

class OAuthController extends BaseController
{
    private $OAuth;

    public function __construct()
    {
        $this->OAuth = new OAuth();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    }

    public function Authorize()
{
    
    return $this->response->setJSON([
        'access_token' => 'fake_token_for_frontend',
        'expires_in' => 3600,
        'token_type' => 'bearer'
    ]);
}
}