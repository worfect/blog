<?php


namespace App\Http\Controllers\Site;


use App\Models\Layouts\NavigationMenu;

class AuthPage extends BasePage
{

    protected $authData = [];

    public function __construct($authData = null)
    {
        $this->authData = $authData;
        parent::__construct(new NavigationMenu());

    }
}
