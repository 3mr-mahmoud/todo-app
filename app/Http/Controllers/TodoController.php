<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'todos' => Todo::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = [
            'title' => $request->title,
            'completed' => false,
        ];
        return response()->json([
            'todo' => Todo::create($input),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        return response()->json([
            'status' => $todo->update($request->only(['title', 'completed'])),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        return response()->json([
            'status' => $todo->delete(),
        ]);
    }
}
