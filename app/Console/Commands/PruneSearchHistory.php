<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SearchHistory;
use Illuminate\Support\Facades\DB;

class PruneSearchHistory extends Command
{
    protected $signature = 'search-history:prune';

    protected $description = 'Remove search history records whose session no longer exists';

    public function handle(): int
    {
        $deleted = SearchHistory::whereNotIn(
            'session_id',
            DB::table('sessions')->select('id')
        )->delete();

        $this->info("Deleted {$deleted} orphaned search history record(s).");

        return self::SUCCESS;
    }
}
