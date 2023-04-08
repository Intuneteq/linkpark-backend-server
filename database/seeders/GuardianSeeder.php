<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('guardians');
        Guardian::factory(10)->create();
        $this->enableForeignKeys();
    }
}
