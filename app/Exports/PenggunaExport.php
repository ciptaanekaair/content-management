<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use App\Models\User;

class PenggunaExport implements FromView, ShouldAutoSize, WithColumnFormatting
{

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function view(): View
    {
        return view('admin.users.export-view', [
            'data' => User::select('users.id', 'users.name', 'users.username', 'users.email', 'users.level_id', 'users.status', 'users.email_verified_at', 'levels.nama_level')
                        ->join('levels', 'users.level_id', 'levels.id')
                        ->where('users.status', '!=', 9)
                        ->orderBy('users.id', 'ASC')
                        ->get()
        ]);
    }
}
