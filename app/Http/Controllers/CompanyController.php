<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use DB;


class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'companies' => Company::all(),
            'companies_inactives' => Company::onlyTrashed()->get()
        ];
        return view('company.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => null,
            'title' => 'Create Company',
            'url' => url('/company'),
            'button' => 'Save',
        ];
        return view('company.form')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $company = Company::create($request->company);
            DB::commit();
            return redirect('company')->with('success', 'company created sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $data = [
            'model' => $company,
            'title' => 'Edit Company Account',
            'url' => url("/company/$company->id"),
            'button' => 'Edit',

        ];
        return view('company.form')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        DB::beginTransaction();
        try {
            $company->update($request['company']);
            DB::commit();
            return redirect('company')->with('success', 'company updated sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        DB::beginTransaction();
        try {
            $company->delete();
            DB::commit();
            return redirect('company')->with('success', 'company deleted sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
		try{    
            $company = Company::onlyTrashed()->where('id', $id)->first();
            $company->restore();          
			DB::commit();
			return redirect('/company')->with('success', 'company restored sucessful');
		}catch(Exception $e){
			DB::rollback();
			return back()->with('error', 'Server error');
		}
    }
}
