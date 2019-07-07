<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyekterlibat;
use App\Proyek;
use App\Kategori;
use App\Fileproyek;
use App\User;
use Auth;
use Illuminate\Support\Facades\Mail;


class HomeKaryawanController extends Controller
{

    public function __construct()
    {
        $this->middleware('karyawancheck');
    }

    public function index_old()
    {
        if (Proyekterlibat::where('user_id', Auth::user()->id)->count() > 0) {
            $id = Proyekterlibat::where('user_id', Auth::user()->id)->first();
            $proyek = Proyek::where('id', $id->proyek_id)->first();
            if ($proyek->active != 0) {
                $id = $id->proyek_id;
                $proyek_by = Proyek::find($id)->createdby()->first();
                $proyek = Proyek::find($id)->first();
                $karyawan = User::where('roles', 4)->get();
                $count = Proyekterlibat::where('proyek_id', $id)->count();
                $count_kat = Kategori::count();
                $file_reject = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 2)->count();
                $file_accept = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 1)->count();
                $file_waiting = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 0)->count();
                $kategori_all = Kategori::all();
                $kategori_file = Kategori::with(['fileproyek'], function ($join) {
                    $join->where('fileproyeks.proyekid', $id);
                })->get();
                $kat_file = Fileproyek::with(['kategori', 'proyek'])
                    ->where('proyek_id', $id);
                return view('karyawan.projecthandle')
                    ->with('fileaccept', $file_accept)
                    ->with('filereject', $file_reject)
                    ->with('filewaiting', $file_waiting)
                    ->with('proyek', $proyek)
                    ->with('proyek_by', $proyek_by)
                    ->with('karyawans', $karyawan)
                    ->with('id', $id)
                    ->with('count', $count)
                    ->with('kategori_all', $kategori_file)
                    ->with('count_kat', $count_kat);
            } else {
                return view('karyawan.index');
            }
        } else {
            return view('karyawan.index');
        }


        //return view('karyawan.index');
    }

    public function index()
    {
        if (Proyekterlibat::where('user_id', Auth::user()->id)->count() > 0) {
            $id = Proyekterlibat::where('user_id', Auth::user()->id)->first();
            $proyek = Proyek::where('id', $id->proyek_id)->first();
            if ($proyek->active != 0) {
                $id = $id->proyek_id;
                $proyek_by = Proyek::find($id)->createdby()->first();
                $proyek = Proyek::find($id)->first();
                $karyawan = User::where('roles', 4)->get();
                $count = Proyekterlibat::where('proyek_id', $id)->count();
                $count_kat = Kategori::count();
                $file_reject = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 2)->count();
                $file_accept = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 1)->count();
                $file_waiting = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 0)->count();
                $kategori_all = Fileproyek::with('kategori', 'proyek')->where('proyek_id', $id)->get();
                //dd($kategori_all);
                $kategori_semua = Kategori::where('id', '>', 101)->get();
                $kategori_file = Kategori::with(['fileproyek'], function ($join) {
                    $join->where('fileproyeks.proyekid', $id);
                })->get();
                $kat_file = Fileproyek::with(['kategori', 'proyek'])
                    ->where('proyek_id', $id);
                return view('karyawan.projecthandle1')
                    ->with('fileaccept', $file_accept)
                    ->with('filereject', $file_reject)
                    ->with('filewaiting', $file_waiting)
                    ->with('proyek', $proyek)
                    ->with('proyek_by', $proyek_by)
                    ->with('karyawans', $karyawan)
                    ->with('id', $id)
                    ->with('count', $count)
                    ->with('kategori_all', $kategori_file)
                    ->with('kat_all', $kategori_all)
                    ->with('kategori_semua', $kategori_semua)
                    ->with('count_kat', $count_kat);
            } else {
                return view('karyawan.index');
            }
        } else {
            return view('karyawan.index');
        }


        //return view('karyawan.index');
    }

    public function fileUpload(Request $request)
    {

        $id = Proyekterlibat::where('user_id', Auth::user()->id)->first();
        $id = $id->proyek_id;
        //dd($id);
        $get_waiting = Fileproyek::where('proyek_id', $id)->where('kategori_id', $request->kategoriid)->where('status', 0)->first();
        $get_refuse = Fileproyek::where('proyek_id', $id)->where('kategori_id', $request->kategoriid)->where('status', 2)->first();
        //dd($get_waiting);
        //dd($get_refuse);
        //die();
        $supervisor = Proyekterlibat::with(['user'])
        ->where('proyek_id',$id)
        ->whereHas('user',function($query) {
            $query->where('roles', '=', '3');
        })
        ->get();
        //dd($query);
        //dd($supervisor[0]->user->email);
        if ($get_waiting == null) {
            $uploadedFile = $request->file('file');
            $path = $uploadedFile->store('public/files');
            $lokasi = "files/" . $request->file('file')->hashName();
            //die();
            $file = new Fileproyek();
            $file->namafile = $request->file->getClientOriginalName();
            $file->lokasifile = $lokasi;
            $file->user_id = Auth::user()->id;
            $file->kategori_id = $request->kategoriid;
            $file->status = 0;
            $file->proyek_id = $id;
            $file->save();
            $to_name = $supervisor[0]->user->name;
            $to_email = $supervisor[0]->user->email;
            $data = array('name' => $to_name, "kategori" => $request->kategoriid);
            Mail::send('mail.xyz', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Notifikasi Dokumen Masuk');
                $message->from('laravelemailtestone@gmail.com', 'Notifikasi Dokumen Masuk');
            });
            return redirect()->back();
        } else {
            return redirect()->back();
        }

        if ($get_refuse != null) {
            $uploadedFile = $request->file('file');
            $path = $uploadedFile->store('public/files');
            $lokasi = "files/" . $request->file('file')->hashName();
            //die();
            $file = new Fileproyek();
            $file->namafile = $request->file->getClientOriginalName();
            $file->lokasifile = $lokasi;
            $file->user_id = Auth::user()->id;
            $file->kategori_id = $request->kategoriid;
            $file->status = 0;
            $file->proyek_id = $id;
            $file->save();
            $to_name = $supervisor[0]->user->name;
            $to_email = $supervisor[0]->user->email;
            $data = array('name' => $to_name, "kategori" => $request->kategoriid);
            Mail::send('mail.xyz', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('Notifikasi Dokumen Masuk');
                    $message->from('laravelemailtestone@gmail.com', 'Notifikasi Dokumen Masuk');
            });
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
