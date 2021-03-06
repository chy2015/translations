<?php

namespace Chy2015\Translations\Commands;

use Chy2015\Translations\Models\Strings;
use Illuminate\Console\Command;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Filesystem\Filesystem;


class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
     public function __construct(Filesystem $filesystem)
     {
         parent::__construct();

         $this->files = $filesystem;
     }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $directory = storage_path('locations');

        if (!$this->files->isDirectory( $directory )) {
            $this->files->makeDirectory($directory);
        }
        if (! $this->files->isFile($directory.'/locations.sqlite')) {
            $this->files->put($directory.'/locations.sqlite', '');
            $this->createSchema();
        }
        $this->createSchema();
        $this->line('');
        $this->info('Database Created!');

        if ($this->confirm('Do you want to import arrays strings from lang folder?')) {
            $this->importArraysStrings();
            $this->line('Arrays strings imported!');
        }

        if ($this->confirm('Do you want to import json strings from lang folder?')) {
            $this->importJsonStrings();
            $this->info('Json strings imported!');
        }
        $this->line('Package installed!');
        $this->info('');

        if ($this->confirm('Do you want to publish json files? This will overwrite existing json files')) {

            $fields = collect(\DB::connection('locations')->getSchemaBuilder()->getColumnListing('strings'));
            $columns = $fields->flip()->except(['code','es_ES','created_at','updated_at'])->keys();

            foreach ($columns as $lang) {
                $list = Strings::pluck($lang,'es_ES');
                $json = json_encode($list, JSON_PRETTY_PRINT);
                $this->files->put(resource_path('lang/'.$lang.'.json'),$json);
                $this->line($lang.'.json Published!');
            }

            $this->info('All Json Files Published!');
        }


    }

    public function importArraysStrings()
    {
        /**
         * Array Strings
         */
        $files = $this->files->directories(base_path('resources/lang'));
        $all = [];
        $langs = [];
        $codes = [];
        foreach ($files as $key => $value) {
            $lang = array_last(explode('/',$value));
            if ($lang !== 'vendor' ) {
                array_push($langs,$lang);
                $a = $this->files->allFiles($value);
                $array = [];
                foreach ($a as $k => $v) {
                    $m = explode('.php',array_last(explode('/',$v)))[0];
                    array_push($array,array_dot([$m => include($v)]));
                }

                list($keys, $values) = array_divide(array_collapse($array));

                array_push($codes,$keys);
                array_push($all,[$lang => array_collapse($array)]);
            }
        }
        $languages = array_collapse($all);
        $codigos = collect(array_collapse($codes))->unique();

        $this->isInTable($langs);

        $collect = collect();

        foreach ($codigos as $key => $codigo) {
            $fila = [];
            foreach ($languages as $key => $arr) {
                if (array_has($arr, $codigo)) {
                    array_push($fila,[$key => array_get($arr, $codigo)]);
                }
            }
            $collect->push(array_collapse($fila));
        }
        $this->fill($collect);
        // return 'ok';
    }

    public function importJsonStrings()
    {
        /**
         * Json Strings
         */
         $json_files = $this->files->files(base_path('resources/lang'));
         $all = [];
         $langs = [];
         $codes = [];
         foreach ($json_files as $key => $json_file) {
             if (str_contains($json_file, '.json')) {
                 $lang = array_first(explode('.json',array_last(explode('/',$json_file))));
                 array_push($langs,$lang);

                 $array = json_decode($this->files->get($json_file));

                 $keys = collect($array)->keys();

                 array_push($codes,$keys);

                 array_push($all,[$lang => $array ]);
             }
         }
         $languages = array_collapse($all);
         $codigos = collect(array_collapse($codes))->unique();

         $this->isInTable($langs);
        $collect = collect();

        foreach ($codigos as $key => $codigo) {
            $fila = [];
            array_push($fila,['es_ES' => $codigo]);

            foreach ($languages as $key => $arr) {
                if (array_has($arr, $codigo)) {
                    // dd(array_get($arr, $codigo));
                    array_push($fila,[$key => $arr->$codigo]);
                }
            }
            $collect->push(array_collapse($fila));
        }

        $this->fill($collect);
    }

    public function fill($collect)
    {
        foreach ($collect as $key => $value) {
            // dd($value['es_ES']);
            if (!array_has($value,'es_ES')) {
                $array = collect($value);
                $array->prepend(array_first($value),'es_ES');

                $string = Strings::where('es_ES',$array['es_ES'])->first();
                if (!isset($string->code)) {
                    Strings::create($array->toArray());
                }
            } else {
                $string = Strings::where('es_ES',$value['es_ES'])->first();
                if (!isset($string->code)) {
                    Strings::create($value);
                }
            }
        }
    }

    public function createSchema()
    {

        if (!Schema::connection('locations')->hasTable('strings')) {

            Schema::connection('locations')->create('strings', function (Blueprint $table) {
                $langs = \Config::get('location.languages');
                $table->increments('code')->unsigned();
                $table->text('es_ES')->unique();
                foreach ($langs as $lang)
                {
                    $table->text($lang)->nullable();

                }




                $table->timestamps();
            });
        }
    }

    public function isInTable($langs)
    {
        $fields = \DB::connection('locations')->getSchemaBuilder()->getColumnListing('strings');
        foreach ($langs as $key => $value) {
            if (! in_array( $value, $fields )) {
                Schema::connection('locations')->table('strings', function (Blueprint $table) use($value){
                        $table->text($value)->nullable();
                    });
            }
        }
    }

}
