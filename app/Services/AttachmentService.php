<?php

namespace App\Services;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AttachmentService {

    public function destroyPhoto($id){
        $file = Attachment::find($id);
        $image_name = $file->server_name;
        $image_path = Storage_path() ."\app\public\user\\". auth::user()->name. "\\" . $image_name;
        Storage::disk('public')->delete($image_path);
        $file->delete();
        return redirect(route('chirps.index'));
    }

}

?>