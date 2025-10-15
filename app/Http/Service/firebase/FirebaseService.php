<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(config('firebase.credentials'))
            ->withDatabaseUri('https://your-project-id.firebaseio.com'); // اختياري

        $this->auth = $factory->createAuth();
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}
