<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Session;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->get();

        return view('User.index', compact('users'));
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = "users";
        $s=DB::table($users)->select(DB::raw('count(idpegawai) as user_otomatis'));

        if ($s->count()>0) {
            foreach ($s->get() as $t) {
               $tmp = ((int)$t->user_otomatis)+1;
            $st = "BTTM00".$tmp;
            }
           
        }
        else {
            $st = "BTTM001";
        }

        $user_otomatis = $st;

        return view('user.create', compact('user_otomatis','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validasi = Validator::make($data, [
            'idpegawai' => 'required|max:255|unique:users',
            'name' => 'required|max:255',
            'email' => 'required|email|max:100|unique:users',
            'level' => 'required',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()) {
            return redirect('users/create')
                    ->withInput()
                    ->withErrors($validasi);
        }

        $users = new User();
        $users->idpegawai = $request->idpegawai;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->level = $request->level;
        $users->password = bcrypt($request->password);

        $users->save();

        Session::flash('flash_message', 'Data User Berhasil Disimpan.');

        return redirect('users');
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
        $users = User::findOrFail($id);
        return view('user.edit', compact('users'));
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
        $users = User::findOrFail($id);
        $users->idpegawai = $request->idpegawai;
        $users->name = $request->name;
        $users->email = $request->email;
        $users->level = $request->level;
        
        if($request->password===''){

        } else {
            $users->password = bcrypt($request->password);
        }

        $users->save();

        Session::flash('flash_message', 'Data User Berhasil Diupdate.');
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        Session::flash('flash_message', 'Data User Berhasil Dihapus.');
        return redirect()->route('users.index');
         //return redirect('users');
    }
}
