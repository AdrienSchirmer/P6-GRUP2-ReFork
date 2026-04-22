<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class admin_index_controller extends Controller
{
    public function index()
    {
        return inertia('admin/index');
    }
}
