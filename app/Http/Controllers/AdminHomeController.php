<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHomeController extends Controller
{
    public function index()
    { 
        // Ambil semua voucher dan kelompokkan berdasarkan kategori
        $voucher = Voucher::orderBy('id', 'desc')->get();
        $kategoriCounts = $voucher->groupBy('kategori')->map(function ($items) {
            return $items->count();
        });

        // Daftar kategori yang diinginkan
        $kategoriOrder = ['Food', 'Fashion', 'Electronic', 'Travelling'];

        // Siapkan data kategori dengan jumlah 0 jika tidak ada di hasil query
        $kategoriData = [];
        foreach ($kategoriOrder as $kategori) {
            $kategoriData[$kategori] = $kategoriCounts->get($kategori, 0); // 0 jika kategori tidak ditemukan
        }

        return view('admin.dashboard', compact('voucher', 'kategoriData'));
    }


    public function create()
    {
        return view('admin.create_voucher');
    }


    public function store(Request $request)
    {
        $validation = $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'status' => 'required',
            'foto'=>'required',
        ]);
        if($request->hasFile('foto')){
            $request-> file('foto')->move('foto_voucher/', $request->file('foto')->getClientOriginalName());
            $validation['foto']  = $request->file('foto')->getClientOriginalName();
        }
        $voucher = Voucher::create($validation);
        
        if($voucher){
            return redirect('admin/dashboard')->with('success', 'Data has been added!');
        }else{
            return redirect(route('admin/dashboard/create_voucher'));
        }        
    }

    public function edit($id)
    {
        $voucher = Voucher::find($id);
        return view('admin.edit_voucher',compact(['voucher']));
    }

    public function update($id, Request $request)
    {
        $voucher = Voucher::find($id);
        $nama = $request->nama;
        $kategori = $request->kategori;
        $status = $request->status;
        if($request->hasFile('foto')){
            $request-> file('foto')->move('foto_voucher/', $request->file('foto')->getClientOriginalName());
            $voucher['foto']  = $request->file('foto')->getClientOriginalName();
        }

        $voucher->nama = $nama;
        $voucher->kategori = $kategori;
        $voucher->status = $status;
        
        $data = $voucher->save();
        if($data){
            return redirect('admin/dashboard')->with('success', 'Data updated successfully!');
        }else{
            return redirect(route('admin/dashboard/create_voucher'));
        } 
    }

    public function delete($id)
    {
        $voucher = Voucher::find($id);
        // return view('admin.dashboard',compact(['voucher']));
        if($voucher){
            $voucher ->delete();
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.dashboard');
        } 
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
