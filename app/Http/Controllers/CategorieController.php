<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class CategorieController extends Controller
{
    public function __construct()
    {
        // constructeur de la classe
    }
}
