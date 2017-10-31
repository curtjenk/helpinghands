<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App;
use Log;

class Inputs
{
    public $filter;
    public $sort;
    public $direction;
    public $limit;
    public $skip;
    public $hasExportCsv;
    public $hasExportInvalid;
    public $from;
    public $until;
    private $request;
    public function __construct(Request $request, $defaults = [])
    {
        $this->request = $request;
        // from-until filter for provider's screens
        if ($request->exists('from')) {
            if ($request->input('from') == '') {
                session()->forget('from');
                $this->from = null;
            } else {
                $this->from = $request->input('from');
                session(['from'=>$this->from]);
            }
        } else {
            $this->from = session('from');
        }
        if ($request->exists('until')) {
            if ($request->input('until') == '') {
                session()->forget('until');
                $this->until = null;
            } else {
                $this->until = $request->input('until');
                session(['until'=>$this->until]);
            }
        } else {
            $this->until = session('until');
        }

        //Log::debug($request->all());
        $this->hasExportCsv = false;
        $this->hasExport = false;
        $this->hasExportInvalid = false;
        $this->filter = $request->input('filter');
        $this->filter = str_replace('*', '%', $this->filter);
        $this->filter = str_replace('?', '_', $this->filter);
        $temp = explode('|', $request->input('sort'));
        if (count($temp)==2) {
            $this->sort = $temp[0];
            $this->direction = $temp[1];
        } else {
            $this->sort = $request->input('sort');
            $this->direction = $request->input('direction');
        }
        $this->limit = $request->input(
                'limit', config('app.default_table_rows_limit'));
        if ($request->filled('per_page')) {
            $this->limit = $request->input('per_page');
        }
        $this->skip = $request->input('skip', 0);
        if (!empty($request->input('export'))) {
            switch ($request->input('export'))
            {
                case 'csv':
                    $this->hasExportCsv = true;
                    break;
                default:
                    $this->hasExportInvalid = true;
            }
        }
        //apply Defaults
        if (count($defaults) > 0) {
            foreach($defaults as $key => $value) {
                if ($key == 'sort' && empty($this->sort)) {
                    $this->sort = $value;
                } else if ($key == 'direction' && empty($this->direction)) {
                    $this->direction = $value;
                } else if ($key == 'filter' && empty($this->filter)) {
                    $this->filter = $value;
                } else if ($key == 'skip' && empty($this->skip)) {
                    $this->skip = $value;
                }
            }
        }
    }

    public static function forget_from_until()
    {
        session()->forget(['from','until']);
    }
    public function all()
    {
        return $this->request->all();
    }

}
