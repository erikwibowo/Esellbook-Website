<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DataController extends Controller
{
    public function create(Request $request){
        $foto = base64_decode($request->foto);
        $imageName = time() . '.jpg';
        Storage::disk('public')->put("data/" . $imageName, $foto);
        $img = Image::make(public_path('storage/data/'. $imageName));
        $img->text(date('d-m-Y H:i'), 0, 0, function ($font) {
            $font->file(public_path('font/SFMono-Bold.otf'));
            $font->size(60);
            $font->color('#f4d442');
            $font->align('right');
            $font->valign('top');
            $font->angle(90);
        });
        $img->save(public_path('storage/data/'.$imageName));
        
        $data = [
            'foto'          => $imageName,
            'text'          => $request->text,
            'created_at'    => now()
        ];
        Data::insert($data);
        return response()->json([
            'success'   => true,
            'message'   => "Success",
            'data'      => []
        ], 200);
    }

    public function show(Request $request)
    {
        $ar = [];
        foreach (Data::orderBy('id', 'desc')->get() as $k) {
            $a['foto']  = asset('storage/data/' . $k->foto);
            $a['text']  = $k->text;
            $a['created_at']    = date('d m Y H:i:s', strtotime($k->created_at));
            array_push($ar, $a);
        }
        return response()->json([
            'success'   => true,
            'message'   => 'Success',
            'data'      => $ar
        ], 200);
    }

    public function item(Request $request)
    {
        return response()->json([
            'success'   => true,
            'message'   => 'Success',
            'data'      => Item::get()
        ], 200);
    }
}
