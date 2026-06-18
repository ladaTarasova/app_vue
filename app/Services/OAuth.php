<?php
namespace App\Services;

use OAuth2\GrantType\UserCredentials;
use OAuth2\Server;
use OAuth2\Request;

class OAuth
{
    public $server;
    
    function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $storage = new MyPdo([
            'dsn' => 'mysql:host=localhost;dbname=ci_oauth;charset=utf8',
            'username' => 'root',
            'password' => ''
        ], ['user_table' => 'users']);
        
        $grantType = new UserCredentials($storage);
        $this->server = new Server($storage);
        $this->server->addGrantType($grantType);
    }

    public function isLoggedIn()
    {
        return $this->server->verifyResourceRequest(Request::createFromGlobals());
    }
}