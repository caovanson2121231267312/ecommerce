<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class mobile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:cate';

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
        echo "hello";
        $bot = new \App\Crawl\Mobile();
        $bot->html();
        $bot->brand();
    }
}
