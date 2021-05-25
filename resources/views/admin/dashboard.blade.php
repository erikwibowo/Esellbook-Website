@extends('admin.layout.master')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ App\Models\Data::count() }}</h3>

            <p>Data</p>
          </div>
          <div class="icon">
            <i class="ion ion-image"></i>
          </div>
          <a href="{{ route('admin.data.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ App\Models\Item::count() }}</h3>

            <p>Item</p>
          </div>
          <div class="icon">
            <i class="ion ion-grid"></i>
          </div>
          <a href="{{ route('admin.item.index') }}" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
  </div>
@endsection