<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $x['title']     = "Item";
        $x['data']      = Item::get();
        return view('admin.item', $x);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required||unique:items',
            'item' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/item')
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'code' => $request->code,
            'item' => $request->item,
            'created_at' => now()
        ];
        try {
            Item::insert($data);
            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect('admin/item');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/item')
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'item' => $request->item
        ];
        try {
            Item::where(['id' => $request->id])->update($data);
            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect('admin/item');
    }

    public function data(Request $request)
    {
        echo json_encode(Item::where(['id' => $request->input('id')])->first());
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            Item::where(['id' => $id])->delete();
            session()->flash('notif', 'Data berhasil dihapus');
            session()->flash('type', 'success');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect('admin/item');
    }
}
