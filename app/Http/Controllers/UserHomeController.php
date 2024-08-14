<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Voucher_claim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserHomeController extends Controller
{

    // Halaman Dashboard
    // public function index()
    // {

    //     $voucher = Voucher::orderBy('id', 'desc')->get();
    //     $kategoriOrder = ['Food', 'Fashion', 'Electronic', 'Travelling'];
    //     $vouchersByCategory = $voucher->groupBy('kategori');
    //     $sortedVouchersByCategory = [];
    //     $voucherCounts = [];

    //     foreach ($kategoriOrder as $kategori) {
    //         $sortedVouchersByCategory[$kategori] = $vouchersByCategory->get($kategori, collect());
    //         $voucherCounts[$kategori] = $sortedVouchersByCategory[$kategori]->count(); 
    //     }

    //     return view('user.dashboard', compact('sortedVouchersByCategory', 'voucherCounts'));
    // }

    public function index()
    {
        $userId = Auth::id(); // Ambil ID pengguna saat ini
        $voucher = Voucher::orderBy('id', 'desc')->get();
        $voucher_claims = Voucher_claim::where('id_user', $userId)->pluck('id_voucher')->toArray();

        $kategoriOrder = ['Food', 'Fashion', 'Electronic', 'Travelling'];
        $vouchersByCategory = $voucher->groupBy('kategori');

        $sortedVouchersByCategory = [];
        $voucherCounts = [];

        foreach ($kategoriOrder as $kategori) {
            $vouchers = $vouchersByCategory->get($kategori, collect());
            $vouchers = $vouchers->map(function ($voucher) use ($voucher_claims) {
                $voucher->is_claimed = in_array($voucher->id, $voucher_claims);
                return $voucher;
            });

            $sortedVouchersByCategory[$kategori] = $vouchers;
            $voucherCounts[$kategori] = $vouchers->count();
        }

        return view('user.dashboard', [
            'sortedVouchersByCategory' => $sortedVouchersByCategory,
            'voucherCounts' => $voucherCounts
        ]);
    }


    // logout
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    // ========================================== claim voucher ===========================================

    public function claim_voucher(Request $request)
    {
        $validated = $request->validate([
            'id_voucher' => 'required|integer|exists:vouchers,id', 
        ]);

        $voucherId = $validated['id_voucher'];
    
        Voucher_claim::create([
            'id_voucher' => $voucherId,
            'id_user' => auth()->id(),
        ]);
    
        return redirect()->back()->with('success', 'Claim voucher berhasil!');
    }

    public function history($id)
    {
        $user = User::find($id);

        // Ambil semua klaim voucher untuk user
        $voucher_claims = Voucher_claim::with('voucher')->where('id_user', $id)->get();

        // Inisialisasi kategori
        $categories = [
            'Food' => 0,
            'Fashion' => 0,
            'Electronic' => 0,
            'Travelling' => 0
        ];

        // Hitung jumlah voucher per kategori
        foreach ($voucher_claims as $claim) {
            $category = $claim->voucher->kategori ?? 'Kategori';
            if (array_key_exists($category, $categories)) {
                $categories[$category]++;
            }
        }

        return view('user.history', [
            'voucher_claims' => $voucher_claims,
            'user' => $user,
            'categories' => $categories
        ]);
    }



    public function claim_delete($id)
    {
        $voucher_claims = Voucher_claim::findOrFail($id);
        $voucher_claims->delete();

        return redirect()->back()->with('success', 'Voucher deleted successfully');
    }

    
}
