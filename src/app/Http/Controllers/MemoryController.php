<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemoryRequest;
use App\Models\Memory;

class MemoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Memory::class, 'memory');
    }

    public function index()
    {
        $memories = Memory::all()->sortByDesc('created_at');

        return view('memories.index', ['memories' => $memories]);
    }

    public function create()
    {
        return view('memories.create');
    }

    public function store(MemoryRequest $request, Memory $memory)
    {
        $memory->fill($request->all());
        $memory->user_id = $request->user()->id;
        $memory->save();
        return redirect()->route('memories.index');
    }

    public function edit(Memory $memory)
    {
        return view('memories.edit', ['memory' => $memory]);
    }

    public function update(MemoryRequest $request, Memory $memory)
    {
        $memory->fill($request->all())->save();
        return redirect()->route('memories.index');
    }

    public function destroy(Memory $memory)
    {
        $memory->delete();
        return redirect()->route('memories.index');
    }

    public function show(Memory $memory)
    {
        return view('memories.show', ['memory' => $memory]);
    }


}
