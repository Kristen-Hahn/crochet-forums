<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Pattern;
use Illuminate\Support\Facades\Storage;


class PatternController extends Controller
{

    public function uploadCoverImage(Request $request, int $id){
                if($request->hasFile('coverimage')){
            $link = Storage::disk('public')->put('photos', $request->file('coverimage'));
            Pattern::find($id)->update(['coverimage' => $link]);http://127.0.0.1:8000/5fc4f4d4-e175-4a4c-8b91-313d8b811a89
        }
    }
    public function uploadPDF(Request $request, int $id){
        if($request->hasFile('pdf')){
    $link = Storage::disk('public')->put('patterns', $request->file('pdf'));
    Pattern::find($id)->update(['pdf' => $link]);http://127.0.0.1:8000/5fc4f4d4-e175-4a4c-8b91-313d8b811a89
}
}

    public function store(Request $request)
    {
        //   dd(vars: $request->file);
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        $pattern = Pattern::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'author' => $request->user()->id,
            'datePosted' => Carbon::now()->setTimezone('EST'),
        ]);

       PatternController::uploadCoverImage($request, $pattern->id);
       PatternController::uploadPDF($request, $pattern->id);
    }

   

}
