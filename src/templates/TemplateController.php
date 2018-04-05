<?php

namespace App\Http\Controllers;

use App\Http\Models\{ltemplate};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class {ltemplate}Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * @SWG\Get(
     *     tags={"generic"},
     *     path="/api/{ltemplate}s",
     *     summary="Busca todos os {ltemplate}s paginados", produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pFilter"),
     *     @SWG\Parameter(ref="#/parameters/pPage"),
     *     @SWG\Parameter(ref="#/parameters/pPer_page"),
     *     @SWG\Parameter(ref="#/parameters/pSort"),
     *     @SWG\Parameter(ref="#/parameters/pColumns"),
     *     @SWG\Parameter(ref="#/parameters/pPageName"),
     *     @SWG\Response(response="200", description="Retorna {ltemplate}s paginados"),
     *     @SWG\Response(
     *     response="500",
     *     description="Erro inesperado"),
     *     )
     * )
     */
    public function listAll(Request $request)
    {
        $page = $request->get('page');
        $per_page = $request->get('per_page');
        $sort = $request->get('sort');
        $columns = $request->get('columns');
        $pageName = $request->get('pageName');
        $filter = empty($request->get('filter')) ? null : '%' . $request->get('filter') . '%';
        if (empty($sort)) {
            $sort = [];
            $sort[0] = 'updated_at';
            $sort[1] = 'asc';
        } else {
            $sort = explode('|', $request->get('sort'));
        }

        $query = {ltemplate}::query();

        $query = mountOrWhereRecursive($query, 'name', $filter);

        return response()
            ->json($query->orderBy($sort[0], $sort[1])
                ->paginate($per_page, $columns, $pageName, $page));
    }

    /**
     * @SWG\Post(
     *     tags={"generic"},
     *     path="/api/{ltemplate}",
     *     summary="Salva {ltemplate}",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Response(response="200", description="{ltemplate} salvo com sucesso"),
     *     @SWG\Response(response="500", description="Internal server Error"),
     *     @SWG\Parameter(ref="#/parameters/generic_def")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:{ltemplate}s'
            ]);
            ${template} = new {ltemplate}();
            ${template}->name = $request->json()->get('name');

            ${template}->saveOrFail();

            return response()
                ->json(["STORE " => $request->all(), "{ltemplate}Created" => ${template}]);
        } catch (Exception $e) {
            return response()
                ->json(["Unexpected error", $e->getMessage()]);
        }
    }

    /**
     * @SWG\Get(
     *     tags={"generic"},
     *     path="/api/{ltemplate}/{id}",
     *     summary="Busca {ltemplate}",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Response(response="200", description="{ltemplate} encontrado"),
     *     @SWG\Response(response="500", description="Internal server Error")
     * )
     * @param Request $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()
            ->json(["SHOW " => {ltemplate}::findOrFail($id)]);
    }

    /**
     * @SWG\Put(
     *     tags={"generic"},
     *     path="/api/{ltemplate}/{id}",
     *     summary="Altera {ltemplate}",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Parameter(ref="#/parameters/generic_def"),
     *     @SWG\Response(response="200", description="{ltemplate} alterado com sucesso"),
     *     @SWG\Response(response="500", description="Internal server Error")
     * )
     * @param Request $request
     * @param Request $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {            
            $this->validate($request, [
                'name' => 'required|unique:{ltemplate}s',
                Rule::unique('{template}s', 'name')
                    ->ignore($id)
                    ->where('deleted_at', 'NULL')
            ]);

            ${template} = new {ltemplate}();
            ${template}->name = $request->json()->get('name');
            
            ${template}->saveOrFail();

            return response()
                ->json(["UPDATE " => $id, "{template}Updated" => ${template}]);
        } catch (Exception $e) {
            return response()
                ->json(["Unexpected error", $e->getMessage()]);
        }
    }

    /**
     * @SWG\Get(
     *     tags={"generic"},
     *     path="/api/{ltemplate}/{id}/edit",
     *     summary="Busca {ltemplate} para ser editado",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Response(response="200", description="{ltemplate} encontrado para ser editado"),
     *     @SWG\Response(response="500", description="Internal server Error")
     * )
     * @param Request $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return response()
            ->json({ltemplate}::findOrFail($id));
    }
    /**
     * @SWG\Delete(
     *     tags={"generic"},
     *     path="/api/{ltemplate}/{id}",
     *     summary="Deleta {ltemplate}",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Response(response="200", description="{ltemplate} alterado com sucesso"),
     *     @SWG\Response(response="500", description="Internal server Error")
     * )
     * @param Request $request
     * @param Request $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        {ltemplate}::findOrFail($id)->delete();
        return response()
            ->json(["DESTROY " => $id]);
    }
}
