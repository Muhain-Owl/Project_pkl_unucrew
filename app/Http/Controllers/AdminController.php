<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\masyarakat;
use App\Models\Pengaduan;
use App\Models\Tanggapan;
use App\Models\User;
use PDF;


class AdminController extends Controller
{
    public function __invoke()
    {
    }

    public function index($id)
    {

        $item = Pengaduan::with([
            'details', 'user'
        ])->findOrFail($id);

        return view('pages.admin.tanggapan.add', [
            'item' => $item
        ]);
    }

    public function masyarakat()
    {

        $data = DB::table('users')->where('roles', 'USER')->get();

        return view('pages.admin.masyarakat', [
            'data' => $data
        ]);
    }

    public function laporan()
    {

        $pengaduan = Pengaduan::orderBy('created_at', 'DESC')->get();

        return view('pages.admin.laporan', [
            'pengaduan' => $pengaduan
        ]);
    }

    public function cetak()
    {

        $pengaduan = Pengaduan::orderBy('created_at', 'DESC')->get();

        $pdf = PDF::loadview('pages.admin.pengaduan', [
            'pengaduan' => $pengaduan
        ]);
        return $pdf->download('laporan.pdf');
    }

    public function pdf($id)
    {

        $pengaduan = Pengaduan::find($id);

        $pdf = PDF::loadview('pages.admin.pengaduan.cetak', compact('pengaduan'))->setPaper('a4');
        return $pdf->download('laporan-pengaduan.pdf');
    }
}

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengaduan;

class AdminLaporanController extends Controller
{
    // Metode untuk halaman Tamu
    public function tamu()
    {
        $pengaduan = Pengaduan::orderBy(); // Pastikan Anda mengambil data yang benar
        if ($pengaduan->isEmpty()) {
            dd('Data pengaduan kosong');
        }
        return view('admin.laporan.tamu', compact('pengaduan'));
    }

    // Metode untuk halaman Pelayanan
    public function pelayanan()
    {
        $pengaduan = Pengaduan::all(); // Pastikan Anda mengambil data yang benar
        if ($pengaduan->isEmpty()) {
            dd('Data pengaduan kosong');
        }
        return view('admin.laporan.pelayanan', compact('pengaduan'));
    }

    // Metode untuk halaman Pengaduan
    public function pengaduan()
    {
        $pengaduan = Pengaduan::all(); // Pastikan Anda mengambil data yang benar
        if ($pengaduan->isEmpty()) {
            dd('Data pengaduan kosong');
        }
        return view('admin.laporan.pengaduan', compact('pengaduan'));
    }
}