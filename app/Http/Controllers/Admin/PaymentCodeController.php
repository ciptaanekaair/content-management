<?php

namespace App\Http\Controllers\Admin;

use App\Models\PaymentCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class PaymentCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->authorize('MOD1007-edit')) {
            $pMethod = PaymentCode::where('status', '!=', 9)->orderBy('id', 'DESC')->paginate(10);

            return view('admin.payment-code.index', compact('pMethod'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($this->authorize('MOD1007-create')) {
            return view('admin.payment-code.form-create', ['pMethod' => new PaymentCode()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->authorize('MOD1007-create')) {
            $rules = [
                'kode_pembayaran'    => 'required',
                'nama_pembayaran'    => 'required',
                'nama_bank'          => 'required',
                'atas_nama_rekening' => 'required',
                'nomor_rekening'     => 'required|numeric',
                'cabang'             => 'required'
            ];

            $pesan = [
                'kode_pembayaran.required'    => 'Field Kode Pembayaran harus di isi.',
                'nama_pembayaran.required'    => 'Field Nama Pembayaran harus di isi.',
                'nama_bank.required'          => 'Field nama bank harus di isi.',
                'atas_nama_rekening.required' => 'Field Atas Nama rekening harus di isi.',
                'nomor_rekening.required'     => 'Field Nomor Rekening harus di isi.',
                'nomor_rekening.required'     => 'Field Nomor Rekening harus di isi dengan angka.',
                'cabang.required'             => 'Field Cabang, wajib di isi.'
            ];

            $this->validate($request, $rules, $pesan);

            $pMethod = new PaymentCode;
            $pMethod->kode_pembayaran    = $request->kode_pembayaran;
            $pMethod->nama_pembayaran    = $request->nama_pembayaran;
            $pMethod->nama_bank          = $request->nama_bank;
            $pMethod->atas_nama_rekening = $request->atas_nama_rekening;
            $pMethod->nomor_rekening     = $request->nomor_rekening;
            $pMethod->save();

            return response()->json([
                'success' => true,
                'message' => 'Berashil mendapatkan sertifikat yang kalian daftarkan',
                'data'    => $pMethod
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($this->authorize('MOD1007-read')) {
            $pMethod = PaymentCode::find($id);

            if (!empty($pMethod)) {
                // code...
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil mengambil data dari database.',
                    'data'    => $pMethod
                ]);
            }

            return response()->json([
                'error'   => true,
                'message' => 'Gagal mengambil data dari database.',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($this->authorize('MOD1007-edit')) {
            $pMethod = PaymentCode::find($id);

            if (!empty($pMethod)) {
                return view('admin.payment-code.form-create', compact('pMethod'));
            }

            return redirect()->route('payment-methodes.index');
        }
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
        if ($this->authorize('MOD1007-update')) {
            $rules = [
                'kode_pembayaran'    => 'required',
                'nama_pembayaran'    => 'required',
                'nama_bank'          => 'required',
                'atas_nama_rekening' => 'required',
                'nomor_rekening'     => 'required|numeric',
                'cabang'             => 'required'
            ];

            $pesan = [
                'kode_pembayaran.required'    => 'Field Kode Pembayaran harus di isi.',
                'nama_pembayaran.required'    => 'Field Nama Pembayaran harus di isi.',
                'nama_bank.required'          => 'Field nama bank harus di isi.',
                'atas_nama_rekening.required' => 'Field Atas Nama rekening harus di isi.',
                'nomor_rekening.required'     => 'Field Nomor Rekening harus di isi.',
                'nomor_rekening.required'     => 'Field Nomor Rekening harus di isi dengan angka.',
                'cabang.required'             => 'Field Cabang, wajib di isi.'
            ];

            $this->validate($request, $rules, $pesan);

            $pMethod = PaymentCode::find($id);
            $pMethod->kode_pembayaran    = $request->kode_pembayaran;
            $pMethod->nama_pembayaran    = $request->nama_pembayaran;
            $pMethod->nama_bank          = $request->nama_bank;
            $pMethod->atas_nama_rekening = $request->atas_nama_rekening;
            $pMethod->nomor_rekening     = $request->nomor_rekening;
            $pMethod->cara_bayar         = $request->cara_bayar;
            $pMethod->update();

            return redirect()->route('payment-methodes.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->authorize('MOD1007-edit')) {
            // code...
        }
    }
}
