<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use DB;

class CurrencyController extends Controller
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
            'currencies' => Currency::all(),
            'currencies_inactives' => Currency::onlyTrashed()->get()
        ];
        return view('currency.index')->with('data',$data);
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
            'title' => 'Create Currency',
            'url' => url('/currency'),
            'button' => 'Save'
        ];
        return view('currency.form')->with('data',$data);
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
            $currency = Currency::create($request->currency);
            DB::commit();
            return redirect('currency')->with('success', 'currency created sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        $data = [
            'model' => $currency,
            'title' => 'Edit Currency',
            'url' => url("/currency/$currency->id"),
            'button' => 'Edit'
        ];
        return view('currency.form')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        DB::beginTransaction();
        try {
            $currency->update($request['currency']);
            DB::commit();
            return redirect('currency')->with('success', 'currency updated sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        DB::beginTransaction();
        try {
            $currency->delete();
            DB::commit();
            return redirect('currency')->with('success', 'currency deleted sucessful');
        }catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Server error');
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
		try{    
            $currency = Currency::onlyTrashed()->where('id', $id)->first();
            $currency->restore();          
			DB::commit();
			return redirect('/currency')->with('success', 'currency restored sucessful');
		}catch(Exception $e){
			DB::rollback();
			return back()->with('error', 'Server error');
		}
    }

}
