<?php

namespace Modules\RRDR\Console\Commands;

use Illuminate\Console\Command;

class RRDRCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:RRDRCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'RRDR Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
