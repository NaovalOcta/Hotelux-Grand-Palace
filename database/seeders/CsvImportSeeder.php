<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CsvImportSeeder extends Seeder
{
    public function run()
    {
        // Urutan import penting karena ada foreign key (Bookings butuh RoomTypes)
        $this->importFile('hotel_profiles', 'hotelProfile_rows.csv');
        $this->importFile('room_types', 'roomTypes_rows.csv'); // Ubah properti JSON nanti
        $this->importFile('testimonials', 'testimonials_rows.csv');
        $this->importFile('promotions', 'promotions_rows.csv');
        $this->importFile('hotel_facilities', 'hotelFacilities_rows.csv');
        // $this->importFile('bookings', 'bookings_rows.csv'); // Opsional
    }

    private function importFile($table, $filename)
    {
        // OPSI 1: Hardcode Path (Gunakan double backslash untuk Windows)
        // Pastikan tidak ada slash di akhir path karena kita menambahkan DIRECTORY_SEPARATOR
        $basePath = "D:\\Downloads\\Documents\\Hotelux Database";

        // Gabungkan path folder dengan nama file
        $path = $basePath . DIRECTORY_SEPARATOR . $filename;

        if (!File::exists($path)) {
            $this->command->warn("File {$filename} not found at {$path}");
            return;
        }

        // --- Sisa kode tetap sama ---
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);

        foreach ($data as $row) {
            if (count($header) != count($row)) continue;

            $record = array_combine($header, $row);

            foreach ($record as $key => $value) {
                if (in_array($key, ['gallery_images', 'amenities', 'items', 'address', 'rate_plans'])) {
                    $cleanJson = str_replace('""', '"', $value);
                    $cleanJson = trim($cleanJson, '"');
                    if ($this->isJson($cleanJson)) {
                        $record[$key] = $cleanJson;
                    }
                }
            }

            $record['created_at'] = now();
            $record['updated_at'] = now();

            DB::table($table)->insertOrIgnore($record);
        }
    }

    private function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
