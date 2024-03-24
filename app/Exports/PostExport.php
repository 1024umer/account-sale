<?php

namespace App\Exports;

use App\Models\GamingAccount;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GamingAccount::all();
    }
}
