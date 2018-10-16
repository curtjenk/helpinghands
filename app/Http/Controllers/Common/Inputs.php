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
    public $orgid;
    public $teamid;
    private $request;
    public function __construct(Request $request, $defaults = [])
    {
        $this->request = $request;

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

        $this->orgid = $request->input('orgid', 0);
        if ($this->orgid == 0) {$this->orgid=null;}
        
        $this->teamid = $request->input('teamid', 0);
        if ($this->teamid == 0) {$this->teamid=null;}

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

    public function all()
    {
        return $this->request->all();
    }

}
