@extends('layouts.main')
@section('main')
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('evidence.index') }}" class="btn btn-success">Back</a>
                </div>
                <div class="card-body">
                <h5 class="card-title text-center">Evidence Info</h5>
                <div class="mb-3">
                <label class="form-label">Nama Dinas</label>
                <input type="text" disabled class="form-control" value="{{ $Evidence->name }}">
                </div>
                <div class="mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" disabled class="form-control" value="{{ $Evidence->alamat }}">
                </div>
                <div class="mb-3">
                <label class="form-label">indikator</label>
                <input type="text" disabled class="form-control" value="{{$Evidence->indikator}}">
                </div>
                <div class="mb-2">
                <label class="form-label">Evidence</label>
                <div class="row row-cols-2">

                    <div class="col-md-3">
                        <img src="{{ asset('/storage/uploads/'.$Evidence->image) }}" width="100%">                
                    </div>
                    <div class="col-md-3">
                        <embed src="{{ asset('/storage/uploads/' . $Evidence->pdf) }}" type="application/pdf" width="100%" height="100%">                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>      
@endsection