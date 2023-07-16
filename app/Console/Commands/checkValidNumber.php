<?php

namespace App\Console\Commands;
use App\Models\CheckNumberValidate;
use Illuminate\Console\Command;
use DB;
class checkValidNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:wavalidnumber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $getNumberToBeCheck = DB::table('contacts')->where('status_valid','queue_to_check')->select('number')->limit(1)->get();
        $validity = new CheckNumberValidate();
        $no = null;
        if(!$getNumberToBeCheck->isEmpty())
        {
            foreach ($getNumberToBeCheck as $key => $value) 
            {
                $number = $value->number;
                $takeit = $validity->checkIt($number);
                $no = $takeit;
                
            }
            return $this->info('done '.$no);
        }
       return $this->info('not to be check!');
    }
}
