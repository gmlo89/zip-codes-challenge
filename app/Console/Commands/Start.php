<?php

namespace App\Console\Commands;

use App\Models\FederalEntity;
use App\Models\Municipality;
use App\Models\Settlement;
use App\Models\SettlementType;
use App\Models\ZipCode;
use Illuminate\Console\Command;
use Illuminate\Support\LazyCollection;

class Start extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip-codes:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load data from a txt file to populate the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        LazyCollection::make(function () {

            $path = database_path("imports/zip_codes.txt");

            $this->info("Reading file from {$path}");
            $handle = fopen($path, 'r');

            $field_names = [
                "d_codigo",
                "d_asenta",
                "d_tipo_asenta",
                "D_mnpio",
                "d_estado",
                "d_ciudad",
                "d_CP",
                "c_estado",
                "c_oficina",
                "c_CP",
                "c_tipo_asenta",
                "c_mnpio",
                "id_asenta_cpcons",
                "d_zona",
                "c_cve_ciudad"
            ];
            
            while (($line = fgets($handle)) !== false) {
                
                $data = collect(str_getcsv($line, '|'));

                yield $data->mapWithKeys(function ($item, $key) use ($field_names) {
                    
                    return [$field_names[$key] => utf8_encode( $item )];
                });
            }
        })
        ->skip(2)
        ->each(function ($item) {
            $this->processItem($item);
        });

    }

    /**
     * Insert the new information on the database
     *
     * @param Array $item
     * @return void
     */
    protected function processItem($item)
    {
        $federal_entity = FederalEntity::firstOrCreate(
            ['key' => $item['c_estado']],
            [
                'name' => $item['d_estado'],
                'code' => null
            ]
        );
    
        $municipality = $federal_entity->municipalities()->firstOrCreate(
            ['key' => $item['c_mnpio']],
            ['name' => $item['D_mnpio']]
        );


        $zip_code = $municipality->zipcodes()->firstOrCreate(
            ['zip_code' => $item['d_codigo']],
            [
                'locality' => $item['d_ciudad'],
                'federal_entity_key' => $federal_entity->key
            ]
        );

        $settlement_type = SettlementType::firstOrCreate([
            'name' => $item['d_tipo_asenta']
        ]);

        $zip_code->settlements()->firstOrCreate(
            [
                'key' => $item['id_asenta_cpcons'], 
                'zip_code' => $zip_code->zip_code
            ],
            [
                'key' => $item['id_asenta_cpcons'], 
                'name' => $item['d_asenta'], 
                'zone_type' => $item['d_zona'], 
                'settlement_type_id' => $settlement_type->id
            ]
        );
    }
}
