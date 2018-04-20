<?php

/*
 * \Moharrum\LaravelGeoIPWorldCities for Laravel 5
 *
 * Copyright (c) 2015 - 2017 LaravelGeoIPWorldCities
 *
 * @copyright  Copyright (c) 2015 - 2017 \Moharrum\LaravelGeoIPWorldCities
 * 
 * @license http://opensource.org/licenses/MIT MIT license
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Moharrum\LaravelGeoIPWorldCities\Helpers\Config;

/**
 * @author Khalid Moharrum <khalid.moharram@gmail.com>
 */
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->dumpFiles() as $dumpPart) {

            $driver_name = DB::connection()->getDriverName();
            switch($driver_name) {
                case 'sqlite':
                    if (($handle = fopen($dumpPart, "r")) !== FALSE) {
                        $first = true;
                        $records = [];
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if ($first) {
                                $first = false;
                                continue;
                            }
                            $record = [
                                'country' => $data[0],
                                'city_ascii' => $data[1],
                                'city' => $data[2],
                                'region' => $data[3],
                                'population' => $data[4],
                                'latitude' => $data[5],
                                'longitude' => $data[6],
                            ];
                            $records []= $record;

                            if (count($records) > 100) {
                                DB::table(Config::citiesTableName())->insert($records);
                                $records = [];
                            }
                        }
                        //-- Add in any remaining records
                        DB::table(Config::citiesTableName())->insert($records);
                        fclose($handle);
                    }
                    break;
                default:
                    $query = "LOAD DATA LOCAL INFILE '"
                        . str_replace('\\', '/', $dumpPart) . "'
                    INTO TABLE `" . Config::citiesTableName() . "` 
                        FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"'
                        LINES TERMINATED BY '\n' IGNORE 1 LINES
                        (country,
                        city_ascii,
                        city,
                        region,
                        population,
                        latitude,
                        longitude
                    )";

                    DB::connection()->getpdo()->exec($query);
                    break;
            }



        }
    }

    /**
     * Returns an array containing the full path to each dump file.
     * 
     * @return array
     */
    private function dumpFiles()
    {
        $files = [];

        foreach(File::allFiles(Config::dumpPath()) as $dumpFile) {
            $files[] = $dumpFile->getRealpath();
        }

        sort($files);

        return $files;
    }
}
