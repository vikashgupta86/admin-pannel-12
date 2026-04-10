<?php

namespace Modules\MenuManage\Console\Commands;

use Illuminate\Console\Command;

class MenuManageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MenuManageCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'MenuManage Command description';

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
