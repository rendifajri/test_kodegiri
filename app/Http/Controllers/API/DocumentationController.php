<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class DocumentationController extends Controller
{
    public function index()
    {
        return Redirect::to("https://documenter.getpostman.com/view/9508853/2s8ZDeTdts");
    }
}
