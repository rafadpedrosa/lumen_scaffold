<?php

namespace App\Http\Controllers;

class {template}Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // {template}
    }

    public function listAll()
    {
        // {template}
        return response()
            ->json([0, 1, 2, 3, 4, 5]);
    }

    public function store($data)
    {
        // {template}
        var_dump('{template}');
        var_dump($data);
    }

    public function show($id)
    {
        // {template}
        return response()
            ->json(["SHOW " => $id]);
    }

    public function update($id)
    {
        // {template}
        return response()
            ->json(["UPDATE " => $id]);
    }

    public function destroy($id)
    {
        // {template}
        return response()
            ->json(["DESTROY " => $id]);
    }
}
