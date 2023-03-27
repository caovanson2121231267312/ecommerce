<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class product extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bot = new \App\Crawl\Product();
        $bot->html();
    }
}
