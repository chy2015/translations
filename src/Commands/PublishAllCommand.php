<?php

namespace Chy2015\Translations\Commands;

use Chy2015\Translations\Models\Strings;
use Illuminate\Console\Command;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Filesystem\Filesystem;


class PublishAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish All Json Files';

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
        $fields = collect(\DB::connection('locations')->getSchemaBuilder()->getColumnListing('strings'));
        $columns = $fields->flip()->except(['code','es_ES','created_at','updated_at'])->keys();

        foreach ($columns as $lang) {
            $list = Strings::pluck($lang,'es_ES');
            $json = json_encode_prettify($list);
            $this->files->put(resource_path('lang/'.$lang.'.json'),$json);
            $this->info($lang.'.json Published!');
        }

        $this->info('All Json Files Published!');

    }
}
