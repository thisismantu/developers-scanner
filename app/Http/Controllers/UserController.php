<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectMapping;
use Illuminate\Support\Facades\{Auth,DB, Hash,Redirect, Route};
use Illuminate\Validation\Rule;
use Rules\Password;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(Auth::user()->is_admin==1){
            $response = User::latest()->paginate(14); // Fixed relationship name
        }else{
            $response = User::whereId(Auth::id())->latest()->paginate(14); // Fixed relationship name
        }
        $title = 'User';
        $breadcrumbs = [route('dashboard') => 'Home', 'javascript:void(0);' => 'User'];
        return view('users.index', compact('breadcrumbs', 'title', 'response'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add User';
        $breadcrumbs = [route('dashboard') => 'Home', route('users.index') => 'User', 'javascript:void(0);' => 'Add'];
        $companies = Company::whereIsActive(1)->get();
        return view('users.create', compact('breadcrumbs', 'title','companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try{

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed'],
            ]);
            
            
            $response = app('apiService')->register(['email'=>$request->email,'password'=>$request->password]);   
            if($response['code']==400){
                if(is_array($response['message'])){
                    flash()
                        ->options([
                            'timeout' => 2000, 
                            'position' => 'top-center',
                        ])
                        ->error($response['message'][0]);
                    return back()->withInput();
                }else{

                    flash()
                        ->options([
                            'timeout' => 2000, 
                            'position' => 'top-center',
                        ])
                        ->error($response['message']);

                    return back()->withInput();
                }
            }else{
                $tenant_id = $response["data"]["tenant_id"];
            }
            
            User::create([
                'tenant_id'=>$tenant_id,
                'is_admin'=>$request->is_admin?1:0,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_password' => $request->password,
            ]);
            flash()
            ->options([
                'timeout' => 2000, 
                'position' => 'top-center',
            ])
            ->success('User created successfully.');
        return redirect()->route('users.index');
    }catch(\Exception $e){
        return back()->with('error',$e->getMessage())->withInput();
    }
    }



    /**
     * Soft delete the specified resource from storage.
     */
    public function edit($id)
    {
        $title = 'Edit User';
        $breadcrumbs = [route('dashboard') => 'Home', route('users.index') => 'User', 'javascript:void(0);' => 'Edit'];
        $dataLine = User::findOrFail($id);
        return view('users.edit', compact('breadcrumbs', 'title','dataLine'));
    }

    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1024',
            'start_at' => 'required',
            'end_at' => 'required'
        ]);

        $validatedData['is_active'] = true; 



        $dataLine = User::findOrFail($id);
        $dataLine->update($validatedData);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function destroy($id)
    {
        $Project = User::findOrFail($id);
        $Project->delete(); // This performs a soft delete

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $Project = User::withTrashed()->findOrFail($id);
        $Project->restore(); 

        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function trashed()
    {
        $companies = User::onlyTrashed()->paginate(19); // This retrieves only soft-deleted records
        $title = 'Trashed Companies';
        $breadcrumbs = [route('dashboard') => 'Home', route('users.index') => 'User', 'javascript:void(0);' => 'Trashed'];
        return view('users.trashed', compact('companies', 'breadcrumbs', 'title'));
    }

    /**
     * Permanently delete a soft-deleted resource.
     */
    public function forceDelete($id)
    {
        $Project = User::withTrashed()->findOrFail($id);
        $Project->forceDelete(); // This permanently deletes the record

        return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
    }

    public function projectMapping()
    {

        if(Auth::user()->is_admin==1){
            $projects = Project::whereIsActive(1)->get(); // Fixed relationship name
            $response = User::with(['mappings' => function($query) {
                $query->select('id', 'user_id', 'project_id'); 
            }])->latest()->paginate(20);
        }else{
            $projects = Project::whereIsActive(1)->get();
            $response = User::whereId(Auth::id())->with(['mappings' => function($query) {
                $query->select('id', 'user_id', 'project_id'); 
            }])->latest()->paginate(20);// Fixed relationship name
        }        
        
        $title = 'Project Mapping';
        $breadcrumbs = [route('dashboard') => 'Home', 'javascript:void(0);' => 'Project Mapping'];
        return view('users.mapping', compact('breadcrumbs', 'title', 'response','projects'));

    }

    public function projectMappingUpdate(Request $request, $id)
    {

        
        try {
            // Validate the incoming request
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'project_id' => 'required|array',
                'project_id.*' => 'exists:projects,id',
            ]);
    
            // Fetch existing project mappings for the user
            DB::statement('DELETE FROM project_mappings WHERE user_id = ?', [$request->user_id]);
    
            // Delete existing mappings
            // foreach ($existingMappings as $mapping) {

            //     ProjectMapping::whereId($mapping->id)->delete();
            //     $mapping->whereId($mapping->id)->delete();
            // }
    
            // Create new project mappings
            foreach ($request->project_id as $projectId) {
                ProjectMapping::create([
                    'user_id' => $request->user_id,
                    'project_id' => $projectId,
                    'created_at' => now(),
                ]);
            }

            return back()->with('success','Project mappings updated successfully.');    
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }
    
}
