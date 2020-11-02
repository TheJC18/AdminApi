<?php
namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;


class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'nivel' => 'required|numeric',
            'estatus' => 'required|numeric',
        ]);
        $user = new User([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'nivel'    => $request->nivel,
            'estatus'    => $request->estatus,
        ]);
        $user->save();
        return response()->json([
            'message' => 'Usuario creado correctamente!'], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|string|email',
            'password'    => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type'   => 'Bearer',
            'expires_at'   => Carbon::parse(
                $tokenResult->token->expires_at)
                    ->toDateTimeString(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Deslogueado exitosamente...']);
    }

    public function user(Request $request)
    {
        $permiso = Auth::user()->hasPermissionTo('ver_roles');
        
        if($permiso == '1'){
            return response()->json($request->user());
        }else{
            return response()->json([
                'message' => 'No tienes acceso a este sitio'], 401);
        }
    }

    public function permisos(Request $request)
    {
        $permi = DB::table('permissions')
        ->get(['id','name']);       
   
        return response()->json([
            'data' => $permi], 200);
    }

    public function roles(Request $request)
    {
        $rol = DB::table('roles')
        ->get(['id','name']);

        return response()->json([
            'data' => $rol], 200);
    }

    public function asignar_roles(Request $request)
    {
        $user = User::find($request->id_user);

        $buscar = DB::table('model_has_roles')
        ->where('model_id', '=', $request->id_user)
        ->get(['model_id']);

        $rol = DB::table('roles')
        ->where('id', '=', $request->id_role)
        ->get(['name']);

        if($buscar == '[]'){

            $user->assignRole($rol[0]->name);
            return response()->json([
                'message' => 'El rol se asigno correctamente',
            ], 200);

        }else{

            $buscar = DB::table('model_has_roles')
            ->where('model_id', '=', $request->id_user)
            ->delete();

            $user->assignRole($rol[0]->name);

            return response()->json([
                'message' => 'Rol actualizado correctamente',
            ], 200);      

        }

    }


    public function asignar_permisos(Request $request)
    {
        $permisos = $request["array"];
        $listado = '';
        $acum = '';

        foreach ($permisos as $i) {

            $com = DB::table('permissions')
            ->where('name', '=', $i)
            ->get('id');
            
            $val = DB::table('role_has_permissions')
            ->where('role_id', '=', $request->id_role)
            ->where('permission_id', '=', $com[0]->id)
            ->get();

            if($val == '[]'){
                return 'vacio';
            }else{
                
            echo $listado = $listado.$i.','.' ';

            }

        }

        return $listado;
        return response()->json([
            'message' => 'Rol actualizado correctamente',
        ], 200);    
    }




}