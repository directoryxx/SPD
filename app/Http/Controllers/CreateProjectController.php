<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyek;
use App\User;
use App\Proyekterlibat;
use Auth;

class CreateProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('managercheck');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proyek = Proyek::all();
        $users = User::where('roles', 3)
                    ->get();
        return view('manager.createproject')->with('proyeks',$proyek)->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'namaproyek' => 'required',
            'lokasiproyek' => 'required',
            'ptpengaju' => 'required',
            'spvid' => 'required',
        ]);
        $proyek = new Proyek();
        $proyek->namaproyek = $request->namaproyek;
        $proyek->lokasiproyek = $request->lokasiproyek;
        $proyek->ptpengaju = $request->ptpengaju;
        $proyek->createdby = Auth::user()->id;
        $proyek->save();

        $lastid = $proyek->id;
        
        $proyekterlibat = new Proyekterlibat;
        $proyekterlibat->user_id = $request->spvid;
        $proyekterlibat->proyek_id = $lastid;

        $proyekterlibat->save();

        return redirect()->back();

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
