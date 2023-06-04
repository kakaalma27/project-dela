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
                <h5 class="card-title text-center">Insert New Student</h5>
                <form action="{{ route('evidence.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label  class="form-label">Nama Dinas</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama Dinas">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Alamat">
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">Indikator</label>
                        <select class="form-select" name="indikator">
                            <option selected value ="male">Male</option>
                            <option value ="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <strong>Image</strong>
                        <input type="file" name="image" class="form-control" placeholder="image">
                    </div>
                    <div class="mb-3">
                        <strong>PDF</strong>
                        <input type="file" name="pdf" class="form-control" placeholder="image">
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