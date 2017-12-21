<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use DB;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('organization.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $this->authorize('create-organization');
    //     return view('organization.create');
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     // $user = Auth::user();
    //     $this->authorize('create-organization');
    //     $this->validate($request, [
    //         'name' => 'required|max:255',
    //         'phone' => 'max:15',
    //         'address1' => 'required|max:255',
    //         'address2' => 'max:255',
    //         'city' => 'max:80',
    //         'state' => 'max:40',
    //         'zipcode' => 'required|max:10',
    //     ]);
    //     $organization = App\Organization::create([
    //         'name'=>$request->input('name'),
    //         'phone'=>$request->input('phone'),
    //         'address1'=>$request->input('address1'),
    //         'address2'=>$request->input('address2'),
    //         'city'=>$request->input('city'),
    //         'state'=>$request->input('state'),
    //         'zipcode'=>$request->input('zipcode')
    //     ]);
    //     return view('organization.show', [
    //         'organization'=>$organization,
    //     ]);
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $organization = App\Organization::findOrFail($id);
        $this->authorize('show', $organization);

        return view('organization.show', [
            'organization'=>$organization,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $organization = App\Organization::findOrFail($id);
    //     $this->authorize('update', $organization);
    //     return view('organization.create', [
    //         'organization'=>$organization,
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $organization = App\Organization::findOrFail($id);
        $this->authorize('update', $organization);
        $this->validate($request, [
            'name' => 'required|max:255',
            'phone' => 'max:15',
            'address1' => 'required|max:255',
            'address2' => 'max:255',
            'city' => 'max:80',
            'state' => 'max:40',
            'zipcode' => 'required|max:10',
        ]);

        $organization->name = $request->input('name');
        $organization->phone = $request->input('phone');
        $organization->address1 = $request->input('address1');
        $organization->address2 = $request->input('address2');
        $organization->city = $request->input('city');
        $organization->state = $request->input('state');
        $organization->zipcode = $request->input('zipcode');
        $organization->save();

        return view('organization.show', [
            'organization'=>$organization,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
