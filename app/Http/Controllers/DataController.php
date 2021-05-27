<?php

namespace App\Http\Controllers;

use App\Models\Data;
use App\Models\Item;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $query = Data::orderBy('id', 'desc');
        if (isset($request->filter)) {
            $filter = explode(" - ", $request->filter);
            $start = date("Y-m-d", strtotime($filter[0]));
            $end = date("Y-m-d", strtotime($filter[1]));
            $query->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->orderBy('id', 'desc');
        }
        if (isset($request->item)) {
            $query->where('text', 'like', '%'.$request->item.'%')->orderBy('id', 'desc');
        }
        if (isset($request->item) && isset($request->filter)) {
            $query->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->where('text', 'like', '%'.$request->item.'%')->orderBy('id', 'desc');
        }
        $x['title']     = "Data";
        $x['data']      = $query->get();
        $x['item']      = Item::get();
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

    public function print(Request $request){
        $title = "Laporan semua data semua menu";
        if (isset($request->item) && isset($request->filter)) {
            $filter = explode(" - ", $request->filter);
            $start = date("Y-m-d", strtotime($filter[0]));
            $end = date("Y-m-d", strtotime($filter[1]));
            $data = Data::orderBy('id', 'asc')->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->where('text', 'like', '%'.$request->item.'%')->orderBy('id', 'asc')->get();
            if ($start == $end) {
                $title = "Laporan data menu '$request->item' tanggal " . date("d M Y", strtotime($filter[0]));
            }else{

                $title = "Laporan data '$request->item' dari tanggal " . date("d M Y", strtotime($filter[0])) . " sampai " . date("d M Y", strtotime($filter[1]));
            }
        }elseif (isset($request->filter)) {
            $filter = explode(" - ", $request->filter);
            $start = date("Y-m-d", strtotime($filter[0]));
            $end = date("Y-m-d", strtotime($filter[1]));
            if ($start == $end) {
                $title = "Laporan data semua menu tanggal " . date("d M Y", strtotime($filter[0]));
            }else{

                $title = "Laporan data semua menu dari tanggal " . date("d M Y", strtotime($filter[0])) . " sampai " . date("d M Y", strtotime($filter[1]));
            }
            $data = Data::orderBy('id', 'asc')->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->orderBy('id', 'asc')->get();
        }else if (isset($request->item)) {
            $data = Data::orderBy('id', 'asc')->where('text', 'like', '%'.$request->item.'%')->orderBy('id', 'asc')->get();
            $title = "Laporan data menu ".$request->item;
        }else{
            $data = Data::orderBy('id', 'asc')->get();
        }
        $x['title']     = $title;
        $x['data']      = $data;
        return view('admin.report.data', $x);
    }
}
