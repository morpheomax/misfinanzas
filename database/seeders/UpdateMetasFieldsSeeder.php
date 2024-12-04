<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateMetasFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('metas')->update([
            'monto' => DB::raw('FLOOR(monto)'),
            'monto_ahorrado' => DB::raw('FLOOR(monto_ahorrado)'),
        ]);
    }
}
