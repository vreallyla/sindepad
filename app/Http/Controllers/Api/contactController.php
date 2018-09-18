<?php

namespace App\Http\Controllers\Api;

use App\Mail\feedbackMail;
use App\mstFeedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class contactController extends Controller
{
    private $data;

    public function __construct(Request $r)
    {
        try{
            $this->data=$r->only('uname','umail','sub','msg');
        }catch (\Exception $exception){
            abort('404');
        }
    }
    public function sendFromUser()
    {
        $this->store($this->data);
        return response()->json('success');
    }

    private function store($set)
    {
        $feedback=mstFeedback::create([
            'name'=>$set['uname'],
            'email'=>$set['umail'],
            'subj'=>$set['sub'],
            'msg'=>$set['msg'],
        ]);
        Mail::to($set['umail'])->send(new feedbackMail($feedback->name));
    }
}
