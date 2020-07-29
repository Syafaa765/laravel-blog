<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artikel;
use App\Categori;
use Storage;
class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artikel=Artikel::latest()->get();
      //  return $artikel;
       // die;
       return view ('artikel.index',compact('artikel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categori=Categori::select('id', 'nama_kategori')->get();
        return view('artikel.create', compact('categori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //return $request ->all();
       $image=$request->file('gambar')->store('artikels');
       Artikel::create([
           'judul'=>\Str::slug($request->judul),
           'body'=>$request->body,
           'gambar'=>$image,
           'categories_id'=>$request->categories_id,
       ]);

       return redirect()->route('artikel.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        return view('artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categori=Categori::select('id','nama_kategori')->get();
        $artikel=Artikel::find($id);

        return view('artikel.edit', compact('categori', 'artikel'));

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
        $artikel=Artikel::find($id);
        Storage::delete($artikel->gambar);
        $artikel->update([
            'judul'=>\Str::slug($request->judul),
            'body'=>$request->body,
            'gambar'=>$request->file('gambar')->store('artikels'),
           'categories_id'=>$request->categories_id,
        ]);
        return redirect()->route('artikel.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $artikel=Artikel::find($id);
    
        if(!$artikel){
            return redirect()->back();
        }
        Storage::delete($artikel->gambar);
        $artikel->delete();
        return redirect()->route('artikel.index');
        
    }
}
