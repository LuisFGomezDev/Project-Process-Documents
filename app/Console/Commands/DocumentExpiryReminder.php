<?php

namespace App\Console\Commands;

use App\Http\Controllers\DocumentController;
use Illuminate\Console\Command;

class DocumentExpiryReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'document:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if any document is being expired';

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
        //
		$document_controller = new DocumentController();
		$document_controller->ldmsEmailSend();
    }
}
