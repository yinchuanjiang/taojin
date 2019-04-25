<?php

namespace App\Http\Controllers\Api;

use App\Http\Core\Core;
use App\Models\User;
use App\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    protected $user;
    protected $page;
    protected $limit;
    public function __construct()
    {
        /** @var User $user */
        $this->user = request()->user('api');
        $this->page = request()->input('page') ? : 1;
        $this->limit = request()->input('limit') ? : Core::API_LIMIT;
    }
}
