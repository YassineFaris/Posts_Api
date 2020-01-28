<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        // constructeur de la classe
    }
    public function LoginUtilisateur(Request $request)
    {
        try
        {
            $messages = [
                'email_user' => 'required|min:10|max:100',
                'password_user' => 'required|min:6|max:30',
            ];

            $validator = Validator::make(
                $request->all(),
                [
                    'email_user' => 'required|min:10|max:100',
                    'password_user' => 'required|min:6|max:30',
                ],$messages
            );

            if ($validator->fails()) {
                return response()->json(
                    [
                        'Api_Message' => 'Erreur de paramètres',
                        'Erreur' => $messages,
                    ],200
                );
            } 
            else { //validators Ok
                $credentials = array(
                    'email_user' => $request->post('email_user'),
                    'password' => $request->post('password_user'),
                );

                $user = DB::table('users')
                    ->join('roles', 'users.id_role', '=', 'roles.id')
                    ->select('users.*', 'roles.libelle_role')
                    ->where('email_user', $credentials['email_user'])
                    ->whereNull('roles.deleted_at')
                    ->whereNull('users.deleted_at')
                    ->get();

                if ($user->count() == 0) {
                    return response()->json(
                        [
                            'Api_Message' => 'Email non existant',
                        ],
                        200
                    );
                } 
                else { // Email valide
                    //JWT laravel authentication
                    if (!$token = JWTAuth::attempt($credentials)) {
                        return response()->json(
                            [
                                'Api_Message' => 'Mot de passe invalide',
                            ], 200);
                    } 
                    else {
                        return response()->json(
                        [
                            'Api_Message' => 'Authentification valide',
                            'data' =>
                            [
                                'token' => $token,
                                'nom_user' => $user[0]->nom_user,
                                'prenom_user' => $user[0]->prenom_user,
                                'id_user' => Crypt::encryptString(Auth::id()),
                                'role' => $user[0]->libelle_role,
                                'Expiration' => (auth('api')->factory()->getTTL() * 60 / 3600) . ' ' . 'Heure',
                            ],
                        ], 200);
                    }
                } // fin Email valide
            } // fin else validators Ok
        } // fin try

         catch (JWTException $error) {
            return response()->json(
                [
                    'Api_Message' => 'Authentification échoué erreur',
                    'Erreur' => $error,
                ], 200);
        } 
        catch (Exception $error) {
            return response()->json(
                [
                    'Api_Message' => 'Authentification échoué erreur',
                    'Erreur' => $error,
                ], 200);
        } 
        catch (QueryException $error) {
            return response()->json(
                [
                    'Api_Message' => 'Authentification échoué erreur',
                    'Erreur' => $error,
                ], 200);
        }
    } // fin login

    public function AjouterUtilisateur(Request $request)
    {
        $messages = [
            'nom_user' => 'required|min:4|max:50',
            'prenom_user' => 'required|min:4|max:50',
            'phone_user' => 'required|min:10|max:15',
            'email_user' => 'required|min:10|max:100',
            'password_user' => 'required|min:6|max:100',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'nom_user' => 'required|min:4|max:50',
                'prenom_user' => 'required|min:4|max:50',
                'phone_user' => 'required|min:10|max:15',
                'email_user' => 'required|min:10|max:100',
                'password_user' => 'required|min:6|max:100',
            ],$messages);

        if ($validator->fails()) {
            return response()->json(
            [
                'Api_Message' => 'Erreur de Paramètres',
                'Erreur' => $messages,
            ], 200);
        } 
        else {
            try
            {
                // Chercher si l'utilisateur est existant
                $UserExist = DB::table('users')
                    ->where('email_user', $request->post('email_user'))
                    ->orWhere('phone_user', $request->post('phone_user'))
                    ->value('id');

                if ($UserExist) {
                    return response()->json(
                    [
                        'Api_Message' => 'Utilisateur existant',
                    ], 200);
                } 
                else {
                    $Query = User::create([
                        'nom_user' => $request->post('nom_user'),
                        'prenom_user' => $request->post('prenom_user'),
                        'phone_user' => $request->post('phone_user'),
                        'email_user' => $request->post('email_user'),
                        'password_user' => Hash::make($request->post('password_user')),
                        'id_role' => 1,
                        'updated_at' => null,
                        'deleted_at' => null,
                    ]);

                    return response()->json(
                    [
                        'Api_Message' => 'Utilisateur Ajouter',
                    ], 200);
                }
            } // fin try

             catch (Exception $error) 
             {
                return response()->json(
                [
                    'Api_Message' => 'Authentification échoué erreur',
                    'Erreur' => $error,
                ], 200);
            } 
            catch (QueryException $error) {
                return response()->json(
                [
                    'Api_Message' => 'Authentification échoué erreur',
                    'Erreur' => $error,
                ], 200);
            }
        }
    } // fin AjouterUtilisateur
}
