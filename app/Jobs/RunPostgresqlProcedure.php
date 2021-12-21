<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RunPostgresqlProcedure implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $procedureName;
    protected $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $procedureName, array $params = [])
    {
        $this->procedureName = $procedureName;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $placeholders = [];
        for ($i = 0; $i < count($this->params); $i++) {
            $placeholders[] = '?';
        }

        $query = 'CALL ' . $this->procedureName . '(' . implode(', ', $placeholders) . ')';

        DB::connection('tbd')
            ->statement($query, $this->params);
    }
}
