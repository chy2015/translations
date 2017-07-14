<?php

namespace Busup\Locations\Commands;

use App\Models\Strings;
use Illuminate\Console\Command;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Filesystem\Filesystem;


class SearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:search';

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

        $needles = ["trans('", "__('",'trans("','__("'];
        $result = array();
        $dir = 'resources/views';
        $result = $this->dirToArray($dir);
        $files = $this->dir_scan('resources/views');

         $literal = [];
        foreach($files as $filename)
        {
            foreach(file($filename) as $fli=>$fl)
            {
                foreach ($needles as $needle)
                {
                    if(strpos($fl, $needle)!==false)
                    {
                        $r = explode("$needle", $fl);
                        if (isset($r[1])){
                            $r = explode(")", $r[1]);
                            $r[0] = str_replace("'", '', $r[0]);
                            $r[0] = str_replace('"', '', $r[0]);
                            array_push($literal,$r[0]) ;
                        }

                    }
                }

            }
        }

        $literales = array_unique($literal);
        $languages = [];
        $collect = collect();
        foreach ($literales as $key => $codigo) {
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

        $this->info('Todos los literales fueron encontrados y almacenados');
    }


    public function dir_scan($folder) {
        $files = glob($folder);
        foreach ($files as $f) {
            if (is_dir($f)) {
                $files = array_merge($files,$this->dir_scan($f .'/*')); // scan subfolder
            }
        }
        return $files;
    }

    public function dirToArray($dir) {

        $result = array();

        $cdir = scandir($dir);
        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                {
                    $result[$key] =
                        $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                }
                else
                {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }

}
