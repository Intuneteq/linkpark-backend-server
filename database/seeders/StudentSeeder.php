<?php

namespace Database\Seeders;

use App\Models\Student;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate('students');
        Student::factory(5)->create();
        $this->enableForeignKeys();
    }
}
