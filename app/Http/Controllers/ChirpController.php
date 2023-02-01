<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChirpRequest;
use App\Http\Requests\updateChirpRequest;
use App\Services\AttachmentService;
use App\Models\chirp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ChirpController extends Controller
{

    protected $attachmentService;
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chirps = chirp::with('user')->latest()->paginate(2);
        return view('chirps.index')->with('chirps', $chirps);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChirpRequest $request)
    {

        $validated = $request->validated();
        
        $user_id = Auth::user()->id;
        
        $chirp =  chirp::create([
            'message' =>$validated['message'],
            'user_id'=> $user_id
        ]);
        
        $path = self::uplaodfile($request , $chirp);
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(chirp $chirp)
    {
        $this->authorize('update', $chirp);
        
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(updateChirpRequest $request, chirp $chirp)
    {
        $this->authorize('update',$chirp);

        $validated = $request->validated();
        $chirp->update($validated);
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\chirp  $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(chirp $chirp)
    {
        $this->authorize('delete',$chirp);
        $photo_id = $chirp->attachments()->first()?->id;
        $chirp->delete();
        $this->attachmentService->destroyPhoto($photo_id);
        return redirect(route('chirps.index'));
    }

    public function uplaodfile ($request, chirp $chirp){
        $OriginalName = $request->file('photo')->getClientOriginalName();
        $extension = $request->file('photo')->extension();
        
        $user_name = Auth::user()->name;
        
        $filedbname =  self::dbname (). '.' . $extension;
        $path = $request->file('photo')->storeAs('user/'.$user_name, $filedbname ,'chirper');
    
        $chirp->attachments()->create([
            'server_name' => $filedbname,
            'db_name'     => $OriginalName
        ]);
        return $path;
    }
 
    public function dbname (){
        $str = Str::random();
        $name = $str.'_'. now()->toDateString();
        return $name;
    }
}