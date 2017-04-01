<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use App;
use Log;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

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
     * @return mixed
     */
    public function handle()
    {
        App\User::where('role_id', '>', 2)->delete();

        $delimiter = ',';
        $fname = storage_path().'/data/contacts.csv';
        $handle = fopen($fname, 'r');
        $fields = fgetcsv($handle, 0, $delimiter);
        $lines = 0;
        $dropped = 0;
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            ++$lines;
            $row = $this->array_combine_special($fields, $data);
            try {
                App\User::create([
                    'password'=>bcrypt($row['E-mail Address']),
                    'name'=>ucwords($row['First Name'].' '.$row['Last Name']),
                    'email'=>$row['E-mail Address'],
                    'homephone'=>$row['Home Phone'],
                    'mobilephone'=>$row['Mobile Phone'],
                    'role_id'=>App\Role::where('name','Organization User')->first()->id,
                    'organization_id'=>1,
                    'opt_receive_evite'=>true,
                    'opt_show_email'=>true,
                    'opt_show_mobilephone'=>false,
                    'opt_show_homephone'=>false,
                ]);

            } catch (QueryException $qe) {
                ++$dropped;
                echo "$dropped Dropped ". $row['First Name'].' '.$row['E-mail Address']."\n";
            }
            // dump($row);
            // break;
        }
        fclose($handle);
    }
/**
 * array_combine() throws an error when num of column
 * @param  [type]  $a   Array of fields/columns
 * @param  [type]  $b   Array of data
 * @param  boolean $pad Pad the results to the larger of num fields or data
 * @return [type]       Combined associative array
 */
    private function array_combine_special($a, $b, $pad = TRUE) {
        $acount = count($a);
        $bcount = count($b);
        // more elements in $a than $b but we don't want to pad either
        if (!$pad) {
            $size = ($acount > $bcount) ? $bcount : $acount;
            $a = array_slice($a, 0, $size);
            $b = array_slice($b, 0, $size);
        } else {
            // more headers than row fields
            if ($acount > $bcount) {
                $more = $acount - $bcount;
                // how many fields are we missing at the end of the second array?
                // Add empty strings to ensure arrays $a and $b have same number of elements
                $more = $acount - $bcount;
                for($i = 0; $i < $more; $i++) {
                    $b[] = "";
                }
            // more fields than headers
            } else if ($acount < $bcount) {
                $more = $bcount - $acount;
                // fewer elements in the first array, add extra keys
                for($i = 0; $i < $more; $i++) {
                    $key = 'extra_field_0' . $i;
                    $a[] = $key;
                }
            }
        }

        return array_combine($a, $b);
    }
}
