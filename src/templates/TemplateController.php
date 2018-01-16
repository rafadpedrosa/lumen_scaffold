<?php

namespace App\Http\Controllers;

use App\Http\Models\{ltemplate};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

    public function test()
    {
        Cache::flush();
        dd('FOI!');
    }

    public function auth()
    {
        return !empty(Auth::{template}()) ? 'ok' : '{ltemplate} Unauthorized';
    }

    /**
     * @SWG\Post(
     *     tags={"{template}"},
     *     path="/api/logout",
     *     summary="Deslogar da aplicação", produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Response(response="200", description="Logout sucess"),
     *     @SWG\Response(response="default", description="Não foi possível deslogar; algum erro inesperado ocorreu")
     * )
     */
    public function logOut(Request $request)
    {
        $tokenRequest = $request->header('Authorization');
        Cache::forget($tokenRequest);
        return 'logout success';
    }

    /**
     * @Deprecated
     */
    public function refresh_token(Request $request)
    {
        $token_time = intval(config("appConfig.token_time"));
        $api_token = $request->json()->get('api_token');
        $decripted_token = decrypt($api_token);
        ${template} = Cache::pull($decripted_token);

        if (is_object(${template})) {
            ${template} = {ltemplate}::find(${template}->id);
            Cache::put($decripted_token, ${template}, $token_time);
            return response()
                ->json(["Success" => 'Login was succeded!',
                    "api_token" => $api_token,
                    "permissions" => ${template}->{template}_type,
                    "person" => ${template}->person
                ]);
        } else {
            return response()->json(['Unauthorized', ${template}], 403);
        }
    }

    /**
     * @SWG\Post(
     *     tags={"{template}"},
     *     path="/api/login",
     *     summary="Logar na aplicação", produces={"application/json"},
     *     @SWG\Parameter(ref="#/parameters/{template}_login"),
     *     @SWG\Response(response="200", description="Login success"),
     *     @SWG\Response(response="422", description="{'email': ['The email field is required.'],'password': ['The password field is required.']}"),
     *     @SWG\Response(
     *     response="default",
     *     description="Não loga na aplicação. Retorna erro esperado"),
     *     )
     * )
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->json()->get('email');
        $pass = $request->json()->get('password');
        $remember_me = $request->json()->get('remember_me');


        ${template} = {ltemplate}::where('email', $email)->first();
        if (!empty(${template}) && decrypt(${template}->password) === $pass) {
            $api_token_str = str_random(32);

            $api_token = encrypt($api_token_str);
            if ($remember_me) {
                ${template}->remember_token = $api_token;
                ${template}->saveOrFail();
            }
            $token_time = intval(config("appConfig.token_time"));
            Cache::put($api_token_str, ${template}, $token_time);

            return response()
                ->json(["Success" => 'Login was succeded!',
                    "api_token" => $api_token,
                    "permissions" => ${template}->{template}_type,
                    "person" => ${template}->person
                ]);
        } else {
            return response()
                ->json(["Error" => 'Wrong password or login'], 403);
        }
    }

    /**
     * @SWG\Post(
     *     tags={"diversos"},
     *     path="/api/{template}_unique_email",
     *     summary="Validar se o email é unico", produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\parameter(ref="#/parameters/pEmail"),
     *     @SWG\Response(response="200", description="numero de quantos emails existem"),
     *     @SWG\Response(
     *     response="default",
     *     description="Erro inesperado"),
     *     )
     * )
     */
    public function uniqueEmail(Request $request)
    {
        return {ltemplate}::where('email', $request->json()->get('email'))->count();
    }

    /**
     * @SWG\Get(
     *     tags={"{template}"},
     *     path="/api/{template}s",
     *     summary="Busca todos os usuários paginados", produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pFilter"),
     *     @SWG\Parameter(ref="#/parameters/pPage"),
     *     @SWG\Parameter(ref="#/parameters/pPer_page"),
     *     @SWG\Parameter(ref="#/parameters/pSort"),
     *     @SWG\Parameter(ref="#/parameters/pColumns"),
     *     @SWG\Parameter(ref="#/parameters/pPageName"),
     *     @SWG\Response(response="200", description="Retorna usuários paginados"),
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

        $query = mountOrWhereRecursive($query, 'email', $filter);
        $query->where('id', '<>', Auth::{template}()->id);
        $query = mountOrWhereRecursive($query, 'login', $filter);
        $query->where('id', '<>', Auth::{template}()->id);

        return response()
            ->json($query->orderBy($sort[0], $sort[1])
                ->paginate(1, $columns, $pageName, $page));
    }

    /**
     * @SWG\Post(
     *     tags={"{template}"},
     *     path="/api/{template}",
     *     summary="Salva usuário",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Response(response="200", description="Usuário salvo com sucesso"),
     *     @SWG\Response(response="500", description="Internal server Error"),
     *     @SWG\Parameter(ref="#/parameters/{template}_required")
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required',
                'email' => 'required|email|unique:{template}s'
            ]);
            ${template} = new {ltemplate}();
            ${template}->login = $request->json()->get('login');
            ${template}->email = $request->json()->get('email');
            ${template}->password = encrypt('123');

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
     *     tags={"{template}"},
     *     path="/api/{template}/{id}",
     *     summary="Busca usuário",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Response(response="200", description="Usuário encontrado"),
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
     *     tags={"{template}"},
     *     path="/api/{template}/{id}",
     *     summary="Altera usuário",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Parameter(ref="#/parameters/{template}_required"),
     *     @SWG\Response(response="200", description="Usuário alterado com sucesso"),
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
                'login' => 'required',
                'email' => 'required|email',
                Rule::unique('{template}s', 'email')
                    ->ignore($id)
                    ->where('deleted_at', 'NULL')
            ]);

            ${template} = {ltemplate}::findOrFail($id);
            ${template}->login = $request->json()->get('login');
            ${template}->email = $request->json()->get('email');

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
     *     tags={"{template}"},
     *     path="/api/{template}/{id}/edit",
     *     summary="Busca usuário para ser editado",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Response(response="200", description="Usuário encontrado para ser editado"),
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
     *     tags={"{template}"},
     *     path="/api/{template}/{id}",
     *     summary="Deleta usuário",
     *     produces={"application/json"},
     *     @SWG\parameter(ref="#/parameters/pAuthorization"),
     *     @SWG\Parameter(ref="#/parameters/pId"),
     *     @SWG\Response(response="200", description="Usuário alterado com sucesso"),
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