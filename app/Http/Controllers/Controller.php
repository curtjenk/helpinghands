<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return the organization id to use in a query
     * @param  Request $request [description]
     * @param  [type]  $user    [description]
     * @return [type]           [description]
     */
    public function getOrg(Request $request, $user)
    {
        if($request->session()->has('orgid')) {
            $organization_id = $request->session()->get('orgid');
        } else {
            $organization_id = $user->organization_id;
        }
        return $organization_id;
    }
}
