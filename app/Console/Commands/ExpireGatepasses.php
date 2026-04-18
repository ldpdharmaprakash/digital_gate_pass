<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Gatepass;
use Illuminate\Support\Facades\Log;

class ExpireGatepasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gatepass:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically expire gatepasses that have passed their in_time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired gatepasses...');
        
        try {
            $expiredCount = Gatepass::expireExpiredGatepasses();
            
            if ($expiredCount > 0) {
                $this->info("Successfully expired {$expiredCount} gatepass(es).");
                Log::info("Expired {$expiredCount} gatepasses automatically.");
            } else {
                $this->info('No gatepasses to expire.');
            }
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('Error expiring gatepasses: ' . $e->getMessage());
            Log::error('Error expiring gatepasses: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
