<?php

namespace App\Console\Commands;

use App\Help\Helper;
use App\Services\Help;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Category extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'my:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $categories = array(
            'okazje' => array(
                'Solenizanci' => array(
                    '18-Nastka' => array(),
                    'Urodziny' => array(),
                    'Imieniny' => array(),
                ),
                'Swięta' => array(
                    'Mikołajki' => array(),
                    'Boże narodzenie' => array(),
                    'Wielkanoc' => array()
                ),
                'Specjalne okazje' => array(
                    'Parapetówki' => array(),
                    'Wieczór panieński' => array(),
                    'Wieczór kawalerski' => array(),
                    'Zaręczyny' => array(),
                    'Ślub' => array(),
                    'Rocznica Ślubu' => array(),
                    'Komunia' => array(),
                    'Chrzest' => array()
                ),
                'Wyjątkowe dni' => array(
                    'Dzień mamy' => array(),
                    'Dzień taty' => array(),
                    'Dzień babci' => array(),
                    'Dzień dziadka' => array(),
                    'Dzień dziecka' => array()
                )
            ),
            'co_lubi' => array(
                'Aktywność' => array(
                    'Rower' => array(),
                    'Bieganie' => array(),
                    'Góry' => array(),
                    'Zespołowa' => array(),
                    'Woda' => array(),
                    'Podróże' => array(),
                    'Ekstremalia' => array()
                ),
                'Dowcipy' => array(
                    'Obrazki' => array(),
                    'Napisy' => array()
                ),
                'Lifestyle' => array(
                    'Muzyka' => array(),
                    'Książki' => array(),
                    'Moda' => array(),
                ),
                'IT & GRY' => array(
                    'Internet' => array(),
                    'Programowanie' => array(),
                    'Gry komputerowy' => array()
                )

            ),
            'dla' => array(
                'Bliscy' => array(
                    'Mama' => array(),
                    'Tata' => array(),
                    'Brat' => array(),
                    'Siostra' => array(),
                    'Babcia' => array(),
                    'Dziadek' => array(),
                    'Dziewczyna' => array(),
                    'Chłopak' => array(),
                ),
                'Znajomi i praca' => array(
                    'Kolega' => array(),
                    'Koleżanka' => array(),
                    'Szef' => array(),
                    'Sąsiad' => array(),
                ),
                'Dzieci' => array(
                    'Dziewczynki' => array(),
                    'Chłopaki' => array(),
                    'Niemowlęta' => array(),
                )
            ),
            'produkty' => array(
                'Torby' => array(),
                'Kubki' => array(),
                'Poduszki' => array(),
                'Artykuły biurowe' => array(),
                'Plecaki' => array(),
                'Puzzle' => array(),
                'Odzież' => array(),
            )
        );
        foreach ($categories as $key => $c1){
            foreach ($c1 as $key2 => $c2){
                $category = \App\Category::create([
                    'name' => $key2,
                    'url' => Helper::slugify($key2),
                    'desc' => $key2,
                    'page_title' => $key2,
                    'page_description' => $key2,
                    'active' => true,
                    'type' => $key
                ]);
                foreach ($c2 as $key3 => $c3){
                    $category3 = \App\Category::create([
                        'name' => $key3,
                        'url' => Helper::slugify($key3),
                        'desc' => $key3,
                        'page_title' => $key3,
                        'page_description' => $key3,
                        'active' => true,
                        'parent_id' => $category->id,
                        'type' => $key
                    ]);
                    foreach ($c3 as $key4 => $c4){
                        $category3 = \App\Category::create([
                            'name' => $key4,
                            'url' => Helper::slugify($key4),
                            'desc' => $key4,
                            'page_title' => $key4,
                            'page_description' => $key4,
                            'active' => true,
                            'parent_id' => $category3->id,
                            'type' => $key
                        ]);
                    }
                }
            }
        }
    }
}
