<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Companies;
use image;
use Storage;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies=Companies::latest()->get();
        return view ('companies.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view ('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      //  $image = $request->file('logo')->store('ok');
      if($request->hasfile('logo')){
        Companies::create([
            'nama'=>$request->nama,
            'email'=>$request->email,
            'website'=>$request->website,
            'logo'=>$request->file('logo')->store('company')
        ]);
    }
   
return redirect()->route('companies.index');
    
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
    public function edit($id)
    {
        
       $companies=Companies::find($id);
       return view('companies.edit', compact('companies'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $companies=Companies::find($id);
        Storage::delete($companies->logo);
        $companies->update([
            'nama'=>$request->nama,
            'email'=>$request->email,
            'website'=>$request->website,
            'logo'=>$request->file('logo')->store('company')
        ]);
        return redirect()->route('companies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $companies=Companies::find($id);
    
        if(!$companies){
            return redirect()-> back();
            Storage::delete($companies->logo);
            $companies->delete();
            return redirect()->route('companies.index');
        }else{
        $companies->delete();
        
        return redirect()->route('companies.index');
        }
    }
}