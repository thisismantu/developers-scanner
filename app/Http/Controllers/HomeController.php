<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectMapping;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $projects = ProjectMapping::when(Auth::user()->is_admin==0,function($query){
                                    return $query->whereUserId(Auth::id());
                                })->get();
        $users = User::when(Auth::user()->is_admin==0,function($query){
                            return $query->whereId(Auth::id());
                        })->get();
        $companies = Company::whereUserId(Auth::id())->get();
        return view('dashboard',compact('projects','users','companies'));
    }
}
