<?php

namespace App\Service;
use Illuminate\Support\Facades\{Auth,Http};
use App\Models\User;

class ApiService
{
    public function login($jsonData)
    {
        $response = Http::asForm()->withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
                        ->post(env('APIURL').'/auth/login/',$jsonData);
        return $response->json();
    }

    public function register($formData)
    {   
        $response = Http::asForm()->withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
                                   ->post(env('APIURL') . '/auth/register/', $formData);
        return $response->json();
    }
    
    

    public function project($jsonData)
    {
        $response = Http::post(env('APIURL').'/auth/register/',$jsonData)->post();
        return $response->json();
    }

    public function scanning($jsonData)
    {
        //return $this->token(['email'=>'fexle2@gmail.com','password'=>'fexle123']);
       // return $this->token(['email'=>Auth::user()->email,'password'=>Auth::user()->user_password]);
        $response = Http::withToken(['email'=>Auth::user()->email,'password'=>Auth::user()->user_password])
                        ->post(env('APIURL').'/scans/ss/',$jsonData)->post();
        return $response->json();    
    }

    public function status($scanID,$jsonData)
    {
        $response = Http::get(env('APIURL').'/scans/{$scanID}/status/',$jsonData)->post();
        return $response->json();   
    }

    public function reports($scanID,$jsonData)
    {
        $response = Http::get(env('APIURL').'/scans/{$scanID}/download-scan-report-pdf/',$jsonData)->post();
        return $response->json();    
    }

    public function token($jsonData){
        $response = Http::asForm()->withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
                        ->post(env('APIURL').'/auth/login/',$jsonData);
        return $response->json();
    }

}
