<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyek;
use App\Proyekterlibat;
use App\Fileproyek;
use App\User;
use App\Kategori;
use DB;
use Auth;
use Illuminate\Support\Facades\Mail;

class HomeSupervisorController extends Controller
{

    public function __construct()
    {
        $this->middleware('supervisorcheck');
    }

    public function index()
    {
        $proyek = Proyek::with(['terlibat' => function ($query) {
            $query->where('proyekterlibats.user_id', '=', Auth::user()->id);
        }])->where('active', 1)->get();
        return view('supervisor.activeproyek')->with('proyeks', $proyek);
    }

    public function proyekhandlespv($id)
    {
        //dd($id);
        $proyek_by = Proyek::find($id)->createdby()->first();
        $proyek = Proyek::where('id', $id)->first();
        //dd($proyek);
        if ($proyek->active == 0) {
            return redirect(url('proyekselesai'));
        } else {
            $user = new User();
            $karyawan = User::where('roles', 4)->get();
            $count = Proyekterlibat::where('proyek_id', $id)->count();
            $count_kat = Kategori::whereNotNull('created_at')->count();
            $proyek_approve = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 1)->count();
            $kategori_all = Fileproyek::with('kategori', 'proyek')->where('proyek_id', $id)->get();
            $id_proyek = $id;
            $dokumenrekap = Fileproyek::where('proyek_id', $id)->where('kategori_id', 101)->first();
            //dd($kategori_all);
            return view('supervisor.detailproyek')
                ->with('proyek', $proyek)
                ->with('proyek_by', $proyek_by)
                ->with('karyawans', $karyawan)
                ->with('id', $id_proyek)
                ->with('count', $count)
                ->with('kategori_all', $kategori_all)
                ->with('count_kat', $count_kat)
                ->with('dokumenrekap', $dokumenrekap)
                ->with('proyek_approve', $proyek_approve);
        }
    }

    public function proyekhandlespv_old($id)
    {
        $proyek_by = Proyek::find($id)->createdby()->first();
        $proyek = Proyek::find($id)->first();
        $karyawan = User::leftJoin('proyekterlibats', function ($join) {
            $join->on('users.id', '=', 'proyekterlibats.user_id');
        })
            ->where('users.roles', 4)
            ->get([
                'users.id',
                'users.name',
            ]);
        $count = Proyekterlibat::where('proyek_id', $id)->count();
        $count_kat = Kategori::whereNotNull('created_at')->count();
        $proyek_approve = Fileproyek::where('proyek_id', $id)->where('kategori_id', '>', 101)->where('status', 1)->count();
        $kategori_all = Kategori::get();
        $id_proyek = $id;
        $dokumenrekap = Fileproyek::where('proyek_id', $id)->where('kategori_id', 101)->first();
        return view('supervisor.detailproyek')
            ->with('proyek', $proyek)
            ->with('proyek_by', $proyek_by)
            ->with('karyawans', $karyawan)
            ->with('id', $id_proyek)
            ->with('count', $count)
            ->with('kategori_all', $kategori_all)
            ->with('count_kat', $count_kat)
            ->with('dokumenrekap', $dokumenrekap)
            ->with('proyek_approve', $proyek_approve);
    }

    public function insertkaryawan(Request $request, $id)
    {
        $array = $request->karyawan;
        $key = array_keys($array);
        $max = max($key);
        $user = new User();
        if ($this->array_has_dupes($array) == 0) {
            for ($a = 0; $a <= $max; $a++) {
                $proyek = new Proyekterlibat();
                if (!$user->checkKaryawanhasTask($array[$a])) {
                    return redirect()->back();
                } else {
                    $proyek->user_id = $array[$a];
                    $proyek->proyek_id = $id;
                    $proyek->save();
                }
            }
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    function array_has_dupes($array)
    {
        return count($array) !== count(array_unique($array));
    }

    public function acceptdokumen(Request $request)
    {
        $this->validate($request, [
            'idfile' => 'required',
        ]);
        $fileproyek = Fileproyek::find($request->idfile);
        $fileproyek->status = 1;
        $fileproyek->save();
        $karyawan = Fileproyek::with(['user'])
            ->where('id', $request->idfile)
            ->get();
        //dd($karyawan[0]->namafile);
        //dd($karyawan);
        $to_name = $karyawan[0]->user->name;
        $to_email = $karyawan[0]->user->email;
        $data = array('name' => $to_name, "kategori" => $karyawan[0]->namafile);
        Mail::send('mail.accept', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Notifikasi Status Dokumen');
            $message->from('laravelemailtestone@gmail.com', 'Notifikasi Status Dokumen');
        });

        return redirect()->back();
    }

    public function rejectdokumen(Request $request)
    {
        $this->validate($request, [
            'idfile' => 'required',
        ]);
        $fileproyek = Fileproyek::find($request->idfile);
        $fileproyek->status = 2;
        $fileproyek->komentar = $request->komentar;
        $fileproyek->save();
        $karyawan = Fileproyek::with(['user'])
            ->where('id', $request->idfile)
            ->get();
        //dd($karyawan[0]->namafile);
        //dd($karyawan);
        $to_name = $karyawan[0]->user->name;
        $to_email = $karyawan[0]->user->email;
        $data = array('name' => $to_name, "kategori" => $karyawan[0]->namafile);
        Mail::send('mail.reject', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Notifikasi Status Dokumen');
            $message->from('laravelemailtestone@gmail.com', 'Notifikasi Status Dokumen');
        });
        return redirect()->back();
    }

    public function fileUpload(Request $request)
    {
        $id = Proyekterlibat::where('user_id', Auth::user()->id)->first();
        $id = $id->proyek_id;
        $this->validate($request, [
            'file' => 'required|file|max:2000'
        ]);
        $uploadedFile = $request->file('file');
        
        $manager = Proyek::with(['createdby'])
            ->where('id', $id)
            ->whereHas('createdby', function ($query) {
                $query->where('roles', '=', '2');
            })
            ->get();
        dd($manager[0]->createdby);
        $path = $uploadedFile->store('public/files');
        $lokasi = "files/" . $request->file('file')->hashName();
        $file = new Fileproyek();
        $file->namafile = $request->file->getClientOriginalName();
        $file->lokasifile = $lokasi;
        $file->user_id = Auth::user()->id;
        $file->kategori_id = $request->kategoriid;
        $file->status = 0;
        $file->proyek_id = $id;
        $file->save();

        $to_name = $manager[0]->createdby->name;
        $to_email = $manager[0]->createdby->email;
        $data = array('name' => $to_name, "kategori" => $request->kategoriid);
        Mail::send('mail.xyz', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('Notifikasi Dokumen Masuk');
            $message->from('laravelemailtestone@gmail.com', 'Notifikasi Dokumen Masuk');
        });


        return redirect()->back();
    }
}
