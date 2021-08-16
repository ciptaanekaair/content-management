<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Storage;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $general = GeneralSetting::find(1);

        if(!$general) {
            $general = GeneralSetting::create([
                'website_title'         => 'www.FilterPedia.co.id',
                'website_logo'          => 'website/logo.png',
                'keywords'              => 'Filterpedia, filter pengolahan limbah',
                'website_description'   => 'Filterpedia merupakan tempat dimana anda menemukan tempat yang sangat baik untuk kebutuhan Rumah Tangga, dan juga Perusahaan.',
                'midtrans_client_token' =>' - ',
                'midtrans_server_token' =>' - '
            ]);
        }

        return view('admin.setting.index', compact('general'));
    }

    public function simpanSetting(Request $request)
    {
        $rules = [
            'website_title' => 'required',
            'website_logo'  => 'image|mimes:jpg,jpeg,png|max:2048'
        ];

        $validasi = Validator::make($request->all(), $rules);

        if ($validasi->fails()) {
            return response()->json([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
        }

        $general = GeneralSetting::find(1);

        if ($request->hasFile('website_logo')) {
            if (Storage::exists('/public/'.$general->website_logo)) {
                Storage::delete('/public/'.$general->website_logo);
            }

            $simpan                = $request->website_logo->store('', 'public');
            $general->website_logo = $simpan;
        }

        $general->website_title = $request->website_title;
        $general->update();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan data Setting Website.',
            'data'    => $general
        ], 200);
    }

    public function simpanSeo(Request $request)
    {
        $rules = [
            'keywords'            => 'required',
            'website_description' => 'required',
        ];

        $pesan = [
            'keywords.required'            => 'Isi dengan (-) jika ingin mengosongkan',
            'website_description.required' => 'Isi dengan (-) jika ingin mengosongkan'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response()->json([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
        }

        $general = GeneralSetting::find(1)->update([
            'keywords'            => $request->keywords,
            'website_description' => $request->website_description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan data Setting SEO.',
            'data'    => $general
        ], 200);
    }

    public function simpanMidtrans(Request $request)
    {
        $rules = [
            'midtrans_client_token' => 'required',
            'midtrans_server_token' => 'required'
        ];

        $pesan = [
            'midtrans_client_token.required' => 'Isi dengan (-) jika ingin mengosongkan',
            'midtrans_server_token.required' => 'Isi dengan (-) jika ingin mengosongkan'
        ];

        $validasi = Validator::make($request->all(), $rules, $pesan);

        if ($validasi->fails()) {
            return response()->json([
                'error'   => true,
                'message' => $validasi->errors()
            ], 422);
        }

        $general = GeneralSetting::find(1)->update([
            'midtrans_client_token' => $request->midtrans_client_token,
            'midtrans_server_token' => $request->midtrans_server_token
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menyimpan data Setting Midtrans.',
            'data'    => $general
        ], 200);
    }

}
