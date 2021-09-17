@extends('layouts.admin')

@section('content')
<div class="container pt-5">
    <div class="row">
          <div class="col-12">
            @include('layouts.alerts')
           <div id="app">
            <password></password>
           </div>
           
            <!-- /.card -->
          </div>
        </div>
</div>
@endsection
