<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\{Auth, Redirect, Route};
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(Auth::user()->is_admin==1){
        $response = Company::whereUserId(Auth::id())->with('user')->latest()->paginate(20); // Fixed relationship name
        }else{
        $response = Company::with('user')->latest()->paginate(20);
        }
        $title = 'Company';
        $breadcrumbs = [route('dashboard') => 'Home', 'javascript:void(0);' => 'Company'];
        return view('company.index', compact('breadcrumbs', 'title', 'response'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add Company';
        $breadcrumbs = [route('dashboard') => 'Home', route('companies.index') => 'Company', 'javascript:void(0);' => 'Add'];
        return view('company.create', compact('breadcrumbs', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);
        if (!isset($validatedData['is_active'])) {
            $validatedData['is_active'] = true; 
        }
        Company::create($validatedData);
        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }



    /**
     * Soft delete the specified resource from storage.
     */
    public function edit($id)
    {
        $title = 'Edit Company';
        $breadcrumbs = [route('dashboard') => 'Home', route('companies.index') => 'Company', 'javascript:void(0);' => 'Edit'];
        $dataLine = Company::findOrFail($id);
        return view('company.edit', compact('breadcrumbs', 'title','dataLine'));
    }

    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        if (!isset($validatedData['is_active'])) {
            $validatedData['is_active'] = false; 
        }



        $dataLine = Company::findOrFail($id);
        $dataLine->update($validatedData);
        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }


    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete(); // This performs a soft delete

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    /**
     * Restore a soft-deleted resource.
     */
    public function restore($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore(); // This restores the soft-deleted record

        return redirect()->route('companies.index')->with('success', 'Company restored successfully.');
    }

    /**
     * Display a listing of the soft-deleted resources.
     */
    public function trashed()
    {
        $companies = Company::onlyTrashed()->paginate(19); // This retrieves only soft-deleted records
        $title = 'Trashed Companies';
        $breadcrumbs = [route('dashboard') => 'Home', route('company.index') => 'Company', 'javascript:void(0);' => 'Trashed'];
        return view('company.trashed', compact('companies', 'breadcrumbs', 'title'));
    }

    /**
     * Permanently delete a soft-deleted resource.
     */
    public function forceDelete($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->forceDelete(); // This permanently deletes the record

        return redirect()->route('companies.trashed')->with('success', 'Company permanently deleted.');
    }
}
