@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form target="_blank" action="{{ route('admin.data.print') }}" method="GET" class="d-flex">
                        @csrf
                        <select class="form-control mr-2" id="item" name="item">
                            <option value="" {{ Request::input('item') == '' ? 'selected':'' }}>Semua Menu</option>
                            @foreach ($item as $i)
                                <option {{ Request::input('item') == $i->item ? 'selected':'' }} value="{{ $i->item }}">{{ $i->item }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="filter" id="filter" class="form-control daterange" value="{{ Request::input('filter') }}" placeholder="Semua Tanggal" readonly />
                        <button type="submit" class="btn btn-primary ml-2"><i class="fas fa-print"></i></button>
                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Foto</th>
                                <th>Text</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <img class="img img-rounded elevation-1" height="100px" src="{{ asset('storage/data/'.$i->foto) }}">
                                    </td>
                                    <td>{{ $i->text }}</td>
                                    <td>{{ date('d-m-Y H:i', strtotime($i->created_at)) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" data-id="{{ $i->id }}" data-name="{{ $i->id }}" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
        </div>
    </div>
<script>
    $(document).ready(function() {
        $(document).on("click", '.btn-delete', function() {
            let id = $(this).attr("data-id");
            let name = $(this).attr("data-name");
            $("#did").val(id);
            $("#delete-data").html(name);
            $('#modal-delete').modal({backdrop: 'static', keyboard: false, show: true});
        });
        $("#item").on('change', function(){
            window.location = '{{ route("admin.data.index") }}'+'?item='+$(this).val()+'&filter='+$(".daterange").val();
        });
        $(".daterange").on('apply.daterangepicker', function(ev, picker) {
            let tgl = picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY');
            $(this).val(tgl);
            window.location = '{{ route("admin.data.index") }}'+'?item='+$('#item').val()+'&filter='+tgl;
        });
    });
</script>
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Hapus Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.data.delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                <input type="hidden" name="id" id="did">
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
        </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection