<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminService
{
    /**
     * @var User
     */
    public User $user;

    /**
     *
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }
}
