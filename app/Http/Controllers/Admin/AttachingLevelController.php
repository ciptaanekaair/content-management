<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LevelRole;

class AttachingLevelController extends Controller
{
    public function attachLevel(Request $request)
    {
        $rules = [
            'level_id' => 'required',
        ];

        $validasi = $this->validate($request, $rules);

        $level_id = $request->level_id;

        foreach($request['id'] as $id) {
            LevelRole::create([
                'level_id' => $level_id,
                'role_id'  => $id
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil attach data untuk level_id: '.$level_id
        ], 200);
    }

    public function unattachLevel(Request $request)
    {
        $rules = [
            'level_id' => 'required',
        ];

        $validasi = $this->validate($request, $rules);

        $level_id = $request->level_id;

        foreach($request['id'] as $id) {
            LevelRole::where([
                'level_id' => $level_id,
                'role_id'  => $id
            ])->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil unattach data untuk level_id: '.$level_id
        ], 200);
    }
}
