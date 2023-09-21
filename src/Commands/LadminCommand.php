<?php

namespace LowB\Ladmin\Commands;

use Illuminate\Console\Command;

class LadminCommand extends Command
{
    public $signature = 'ladmin';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
