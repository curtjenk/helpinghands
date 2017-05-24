<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Carbon\Carbon;
use DB;

function status($msg) {
    echo (new \DateTime())->format('Y-m-d G:i:s') . ' ' . $msg . "\n";
}

class ExportImportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:exim {--export} {--import}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do a DB export or import';

    private $table_names = [
        //'statuses'=>'id,name,description,created_at,updated_at',
        //'event_types'=>'',
        //'roles'=>'id,name',
        //'permissions'=>'id,name',
        //'permission_role'=>'role_id,permission_id',
        'organizations'=>'id,name,address1,address2,city,zipcode,state,phone,created_at,updated_at',
        'users'=>'id,name,nickname,email,password,birth_mm,birth_dd,birth_yyyy,mobilephone,homephone,role_id,organization_id,opt_show_email,opt_receive_evite,opt_show_mobilephone,opt_show_homephone,remember_token,created_at,updated_at',
        'events'=>'id,user_id,organization_id,subject,description,date_start,date_end,evite_sent,updated_user_id,status_id,created_at,updated_at',
        'responses'=>'id,event_id,user_id,helping,token,created_at,updated_at',
        'notes'=>'id,note,event_id,user_id,created_at,updated_at',
    ];
    private $tables_with_ids = [
        'organizations',
        'users',
        'events',
        'responses',
        'notes'
    ];

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
        $dir = storage_path('dbexport');
        if(!is_dir($dir)){
            mkdir($dir, 0755);
        }
        if ($this->option('export')){
            $this->doExport($dir);
        } else if ($this->option('import')){
            $this->doImport($dir);
        } else {
            status("ERROR: Please run with either --export or --import option");
        }
    }

    private function doImport($dir)
    {
        status(" ... Begin import tables ... ");

        $label = config('database.default');
        $host = config("database.connections.$label.host");
        $port = config("database.connections.$label.port");
        $db = config("database.connections.$label.database");
        $user = config("database.connections.$label.username");
        $pw = config("database.connections.$label.password");
        //load data
        foreach ($this->table_names as $table=>$cols)
        {
            $csv_file = $dir.'/'.$table.'.csv';
            if (empty($cols)){
                continue;
            }
            $cmd = "psql -h $host -p $port -U $user $db -c"
                . " \"\\copy $table ($cols) FROM '$csv_file' "
                . " WITH (delimiter ',', HEADER 1, FORMAT csv);\"";
            $process = new Process($cmd);
            $process->run();
            // executes after the command finishes
            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }
            echo $process->getOutput();
            //unlink($csv_file);
        }
        //Set the sequence
        foreach($this->tables_with_ids as $table) {
            DB::select(DB::raw("SELECT setval('$table".
                "_id_seq', (SELECT max(id) FROM $table))"));
        }

        status(" ... End import tables ...");
    }

    private function doExport($dir)
    {
        status(" ... Begin export tables ... ");

        foreach ($this->table_names as $table=>$cols)
        {
            $fname = $dir.'/'.$table.'.csv';
            $fp = fopen($fname, 'w');
            fputcsv($fp, explode(',',$cols));
            // echo $table. ' '.$cols."\n";
            if (empty($cols)){
                continue;
            }
            $query = DB::table($table)->selectRaw($cols);
            foreach ($query->cursor() as $row)
            {
                //dump(collect($row)->toArray());
                fputcsv($fp, collect($row)->toArray());
            }
            fclose($fp);
        }

        status(" ... End export tables ...");
    }
}
