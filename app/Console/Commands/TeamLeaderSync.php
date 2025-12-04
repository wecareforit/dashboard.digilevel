<?php

namespace App\Console\Commands;

use App\Services\TeamleaderService;

use Illuminate\Console\Command;

class TeamLeaderSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:team-leader-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $teamleader = new TeamleaderService(config('services.teamleader.client_id'), config('services.teamleader.client_secret'), config('services.teamleader.redirect_url'), config('services.teamleader.state'));
        $teamleader->setAuthorizationCode(cache()->get('teamLeaderCode'));  
        $teamleader->setAccessToken(cache()->get('teamLeaderAccessToken'));
        $teamleader->setRefreshToken(cache()->get('teamLeaderRefreshToken'));
        $teamleader->setTokenExpiresAt(cache()->get('teamLeaderExpiresAt'));
        $teamleader->shouldRefreshToken();
        dd($teamleader->get('deals.list')); 
    }
}
