<?php

namespace App\Http\Controllers;

class TemplateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function listAll()
    {
        return response()
            ->json([0, 1, 2, 3, 4, 5]);
    }

    public function store($data)
    {
        var_dump($data);
    }

    public function show($id)
    {
        return response()
            ->json(["SHOW " => $id]);
    }

    public function update($id)
    {
        return response()
            ->json(["UPDATE " => $id]);
    }

    public function destroy($id)
    {
        return response()
            ->json(["DESTROY " => $id]);
    }
}
