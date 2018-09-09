<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\Helpers\CommandExecutor;
use App\Console\Commands\Helpers\CommandExecutorInterface;

class ProductionWizard extends Command
{
    /**
     * The command executor
     * 
     * @var CommandExecutorInterface
     */
    public $commandExecutor;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:production';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the production environment';

    public function __construct()
    {
        $this->commandExecutor = new CommandExecutor($this);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Check the .env file before run artisan.
        if (! file_exists(__DIR__.'/../../../.env')) {
            $this->line('File .env need to create first and config with specified information');
            return false;
        }

        $this->commandExecutor->artisan('✓ Generate application key', 'key:generate');

        if (! file_exists(public_path('storage'))) {
            $this->commandExecutor->artisan('✓ Symlink the storage folder', 'storage:link');
        }

        $this->commandExecutor->artisan('✓ Run migrations to create tables', 'migrate', ['--force' => 'true', '--seed' => 'true']);

        $this->line("The application set up success, let's get some fun.");
    }
}
