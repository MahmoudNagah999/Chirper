<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Services\AttachmentService;




class attachmentController extends Controller
{
    protected $attachmentService;
    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }
    
    public function destroy($id){
        $this->attachmentService->destroyPhoto($id);
    }
}
