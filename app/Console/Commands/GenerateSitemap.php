<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generar un Sitemap para el sitio web';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Aquí puedes agregar manualmente las URL que desees incluir en tu sitemap
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        // Guarda el archivo sitemap.xml en el directorio public
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generado correctamente!');
    }
}
