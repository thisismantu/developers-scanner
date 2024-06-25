<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\{Auth, Redirect, Route};
use App\Models\Project;
use Exception;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        

        if(Auth::user()->is_admin==1){
            $response = Project::join('project_mappings','projects.id','=','project_mappings.project_id')
                                ->join('users','project_mappings.user_id','=','users.id')
                                ->leftJoin('companies','projects.company_id','=','companies.id')
                                ->select('projects.*','users.name as username','companies.name as company_name')
                                //->where('project_mappings.user_id',Auth::id())
                                ->paginate(20); 
        }else{
            $response = Project::join('project_mappings','projects.id','=','project_mappings.project_id')
                               ->join('users','project_mappings.user_id','=','users.id')
                               ->leftJoin('companies','projects.company_id','=','companies.id')
                                ->select('projects.*','users.name as username','companies.name as company_name')
                                ->where('project_mappings.user_id',Auth::id())
                                ->paginate(20); // Fixed relationship name
        }

       // return $response;
        $title = 'Project';
        $breadcrumbs = [route('dashboard') => 'Home', 'javascript:void(0);' => 'Project'];
        return view('project.index', compact('breadcrumbs', 'title', 'response'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Project';
        $breadcrumbs = [route('dashboard') => 'Home', route('projects.index') => 'Project', 'javascript:void(0);' => 'Add'];
        $companies = Company::whereIsActive(1)->get();
        return view('project.create', compact('breadcrumbs', 'title','companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try{
        $validatedData = $request->validate([
            'user_id' => 'required',
            'company_id'=>'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1024',
            'start_at' => 'required',
            'end_at' => 'required',
            'targets' => 'required',
            'scan_engine' => 'required',
            'scan_schedule' => 'required'
        ]);
        $validatedData['is_active'] = true; 
        Project::create($validatedData);
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }catch(\Exception $e){
        return back()->with($request->input());
    }
    }



    /**
     * Soft delete the specified resource from storage.
     */
    public function edit($id)
    {
        $title = 'Edit Project';
        $breadcrumbs = [route('dashboard') => 'Home', route('projects.index') => 'Project', 'javascript:void(0);' => 'Edit'];
        $dataLine = Project::findOrFail($id);
        $companies = Company::whereIsActive(1)->get();
        return view('project.edit', compact('breadcrumbs', 'title','dataLine','companies'));
    }

    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'company_id'=>'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1024',
            'start_at' => 'required',
            'end_at' => 'required',
            'targets' => 'required',
            'scan_engine' => 'required',
            'scan_schedule' => 'required'            
        ]);

        $validatedData['is_active'] = true; 
        $dataLine = Project::findOrFail($id);
        $dataLine->update($validatedData);
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }


    public function destroy($id)
    {
        $Project = Project::findOrFail($id);
        $Project->delete(); // This performs a soft delete

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $Project = Project::withTrashed()->findOrFail($id);
        $Project->restore(); 

        return redirect()->route('projects.index')->with('success', 'Project restored successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function trashed()
    {
        $companies = Project::onlyTrashed()->paginate(19); // This retrieves only soft-deleted records
        $title = 'Trashed Companies';
        $breadcrumbs = [route('dashboard') => 'Home', route('project.index') => 'Project', 'javascript:void(0);' => 'Trashed'];
        return view('project.trashed', compact('companies', 'breadcrumbs', 'title'));
    }

    /**
     * Permanently delete a soft-deleted resource.
     */
    public function forceDelete($id)
    {
        $Project = Project::withTrashed()->findOrFail($id);
        $Project->forceDelete(); // This permanently deletes the record

        return redirect()->route('projects.trashed')->with('success', 'Project permanently deleted.');
    }


    public function Scanning($ids){

        try
        {   
            $dataLine = Project::find(decrypt($ids));

            $jsonData  = [
                "project_name" => $dataLine->name,
                "target" => $dataLine->targets,
                "scan_engine" => $dataLine->scan_engine,
                "scan_schedule" => $dataLine->scan_schedule,
                "start_date" => $dataLine->start_at,
                "end_date" => $dataLine->end_at,
                "status" => "New",
                "description" => $dataLine->description
            ];
            
            $response = app('apiService')->scanning($jsonData);   
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
                    return back();
                }
            }else{
                $scan_id = $response["data"]["scan_id"];
            }
            $dataLine->update(['scan_id'=>$scan_id]); 
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

}
