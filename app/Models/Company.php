<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id','name','is_active','created_at'];

    public function user(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // public function companies(){

    //     return $this->belongsTo(Company::class,'id','company_id');

    // }

}