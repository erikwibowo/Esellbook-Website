<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index()
    {
        $x['title']     = "Data";
        $x['data']      = Data::get();
        return view('admin.data', $x);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $old = Data::where(['id' => $id])->first();
        try {
            Data::where(['id' => $id])->delete();
            File::delete('storage/data/' . $old->foto);
            session()->flash('notif', 'Data berhasil dihapus');
            session()->flash('type', 'success');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect('admin/data');
    }
}
