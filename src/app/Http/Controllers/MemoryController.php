<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memory;

class MemoryController extends Controller
{
    public function index()
    {
        $memories = Memory::all()->sortByDesc('created_at');

        return view('memories.index', ['memories' => $memories]);
    }

}
