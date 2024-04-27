<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedeemController extends Controller
{
    public function create()
    {
        return view('redeem.create');
    }
}
