<?php

namespace App\Http\Controllers;

use App\Http\Models\{template};
use Illuminate\Http\Request;

class {template}Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function listAll()
    {
        return response()
            ->json({template}::all());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        ${ltemplate} = new {template}();
        ${ltemplate}->name = $request->json()->get('name');

        ${ltemplate}->save();

        return response()
            ->json(["STORE " => $request->all(), "{template}" => ${ltemplate}]);
    }

    public function show($id)
    {
        return response()
            ->json(["SHOW " => {template}::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        ${ltemplate} = {template}::findOrFail($id);
        ${ltemplate}->name = $request->json()->get('name');
        ${ltemplate}->email = $request->json()->get('email');

        ${ltemplate}->save();

        return response()
            ->json(["UPDATE " => $id, "ltemplateUpdated" => ${ltemplate}]);
    }

    public function edit($id)
    {
        return response()
            ->json(["EDIT " => {template}::findOrFail($id)]);
    }

    public function destroy($id)
    {
        {template}::findOrFail($id)->delete();
        return response()
            ->json(["DESTROY " => $id]);
    }
}