@extends('layouts.main')
@section('main')
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                <a href="{{ route('evidence.index') }}" class="btn btn-success">Back</a>
                </div>
                <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h5 class="card-title text-center">Edit Evidence</h5>
                <form action="{{ route('evidence.update', $Evidence->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label  class="form-label">Nama Dinas</label>
                        <input type="text" value="{{$Evidence->name}}"  name="name"  class="form-control" placeholder="Nama Dinas">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Alamat</label>
                        <input type="text" value="{{$Evidence->alamat}}" name="alamat"  class="form-control" placeholder="Alamat">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">indikator</label>
                        <select class="form-select" name="indikator">
                            @if($Evidence->indikator == "male")
                            <option value ="male" selected>Male</option>
                            <option value ="female">Female</option>
                            @else
                            <option value ="male">Male</option>
                            <option value ="female" selected>Female</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Evidence</label>
                        <input type="date" value="{{$Evidence->evidence}}"  name="evidence"  class="form-control">
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>      
@endsection