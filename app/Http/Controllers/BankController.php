<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Bank;
use Illuminate\Http\Request;
use DB;

class BankController extends Controller
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
            'banks' => Bank::all(),
            'banks_inactives' => Bank::onlyTrashed()->get()
        ];
        return view('bank.index')->with('data',$data);
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
            'title' => 'Create Bank Account',
            'url' => url('/bank'),
            'button' => 'Save',
            'currencies' => Currency::all()
        ];
        return view('bank.form')->with('data',$data);
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
            $bank = Bank::create($request->bank);
            DB::commit();
            return redirect('bank')->with('success', 'bank created sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        $data = [
            'model' => $bank,
            'title' => 'Edit Bank Account',
            'url' => url("/bank/$bank->id"),
            'button' => 'Edit',
            'currencies' => Currency::all()

        ];
        return view('bank.form')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        DB::beginTransaction();
        try {
            $bank->update($request['bank']);
            DB::commit();
            return redirect('bank')->with('success', 'bank updated sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        DB::beginTransaction();
        try {
            $bank->delete();
            DB::commit();
            return redirect('bank')->with('success', 'bank deleted sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    public function restore( $id)
    {
        DB::beginTransaction();
		try{    
            $bank = Bank::onlyTrashed()->where('id', $id)->first();
            $bank->restore();          
			DB::commit();
			return redirect('/bank')->with('success', 'bank restored sucessful');
		}catch(Exception $e){
			DB::rollback();
			return back()->with('error', 'Server error');
		}
    }
}
