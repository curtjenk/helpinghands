<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\Inputs;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\EventNotification;
use App;
use Auth;
use Storage;
use Cache;
use DB;
use Log;

class DocumentController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $inputs = new Inputs($request,
            [ ]
        );

    }

    /**
     * Download the requested file/attachment
     * @param  Request $request [description]
     * @param  [type]  $event_id      [description]
     * @param  [type]  $file_id [description]
     * @return [type]           [description]
     */
    // public function download(Request $request, $event_id, $file_id)
    // {
    //     $user = Auth::user();
    //     $event = App\Event::findOrFail($event_id);
    //     $this->authorize('show', $event);
    //     $file = App\EventFile::where('id', $file_id)
    //         ->where('event_id', $event->id)
    //         ->first();
    //     if(!isset($file)){
    //         Log::debug("File not found. id = ".$file_id." event=".$event_id);
    //         return;
    //     }
    //     $pathToFile =  Storage::disk('public')
    //         ->getDriver()->getAdapter()
    //         ->applyPathPrefix($file->filename);
    //     //dump($pathToFile);
    //     return response()->download($pathToFile, $file->original_filename);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug(print_r($request->all(),true));
        Log::debug($request->organization_id);

        $user = Auth::user();
        $this->authorize('create-event');
        $request->validate([
            'auth_user_id' => 'required',
            'event_id' => 'required',
            'organization_id' => 'required',
            'attachment' => 'required|file',
        ]);
        //Store to 'pubilic'
        //created sym link using php artisan storage:link
        //so files are accessible from web
        $dir = 'event_files/'.$request->organization_id;
        if ($request->has('team_id') && is_numeric($request->has('team_id'))) {
            $dir .= '/'.$request->team_id;
        }
        $upload = $request->attachment;
        $path = $upload->store($dir, 'public');
        // Log::debug(Storage::disk('public')->url($path));
        $newDoc = App\EventFile::create([
            'event_id'=>$request->event_id,
            'organization_id'=>$request->organization_id,
            'team_id'=>$request->team_id,
            'description'=>$request->description,
            'original_filename'=>$upload->getClientOriginalName(),
            'mimetype'=>$upload->getMimeType(),
            'size'=>$upload->getClientSize(),
            'path'=>$path
        ]);

        return response(['id'=>$newDoc->id,'echo'=>$request->echo]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $doc = App\EventFile::findOrFail($id);
        $organization = App\Organization::findOrFail($doc->organization_id);
        $this->authorize('show', $organization);
        $pathToFile =  Storage::disk('public')
            ->getDriver()->getAdapter()
            ->applyPathPrefix($doc->path);
        Log::debug($pathToFile);
        //
        return response()->file($pathToFile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     Log::debug(print_r($request->all(),true));
    //     $user = Auth::user();
    //     $event = App\Event::findOrFail($id);
    //     $this->authorize('update', $event);
    //     $this->validate($request, [
    //         'subject' => 'required|max:255',
    //         'description' => 'string',
    //         'date_start' => 'date',
    //         'date_end' => 'date',
    //         // 'organization_id' => 'required|exists:organizations,id',
    //         'event_type_id'=> 'required|exists:event_types,id',
    //         'status_id' => 'required|exists:statuses,id',
    //         'signup_limit'=> 'required|numeric',
    //         'cost'=> 'required|regex:/^\d*(\.\d{1,2})?$/'
    //     ]);
    //
    //     $event->subject = $request->input('subject');
    //     $event->description = $request->input('description');
    //     $event->date_start = $request->input('date_start');
    //     $event->date_end = $request->input('date_end');
    //     $event->updated_user_id = $user->id;
    //     $event->organization_id = 1;
    //     $event->status_id = $request->input('status_id');
    //     $event->event_type_id = $request->input('event_type_id');
    //     $event->signup_limit = $request->input('signup_limit');
    //     $event->cost = $request->input('cost');
    //     $event->save();
    //
    //     $dir = 'event_files/'.$event->id;
    //
    //     $uploads = $request->file('event_file');
    //     if (isset($uploads)) {
    //         //cleanup storage and db rows from previous
    //         Storage::disk('public')->deleteDirectory($dir);
    //         $event->files()->delete();
    //         //now save the uploaded
    //         foreach($uploads as $upload) {
    //             $original = $upload->getClientOriginalName();
    //             $filename = $upload->store($dir, 'public');
    //             App\EventFile::create(['event_id'=>$event->id,
    //                 'filename'=>$filename,
    //                 'original_filename'=>$original]);
    //         }
    //     }
    //     $todelete = $request->input('delete_file');
    //     if(is_array($todelete))
    //     {
    //         foreach($todelete as $id) {
    //             $eventFile = App\EventFiles::findOrFail($id);
    //             Storage::disk('public')->delete($eventFile->filename);
    //             $eventFile->delete();
    //         }
    //         //delete directory if empty
    //         $diskfiles = Storage::disk('public')->files($dir);
    //         // Log::debug(print_r($diskfiles, true));
    //         if (count($diskfiles)==0) {
    //             // Log::debug("delete directory");
    //             Storage::disk('public')->deleteDirectory($dir);
    //         }
    //     }
    //     return redirect("event/$event->id");
    //     // return view('event.show', [
    //     //     'event'=>$event,
    //     // ]);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     // $event = App\Event::findOrFail($id);
    //     // $this->authorize('destroy', $event);
    //     //
    //     // $event->delete();
    //     // return redirect('/event');
    // }

}
