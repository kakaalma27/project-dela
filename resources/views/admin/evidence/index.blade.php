@extends('layouts.main')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                <a href="{{ route('evidence.create') }}" class="btn btn-primary">Insert</a>
                </div>
                <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif                
                <table class="table table-bordered">
                    <tr>
                        <th style="background-color: var(--bs-dark-text); var(--bs-body-bg);">No Id</th>
                        <th color: var(--bs-body-bg);>Nama Dinas</th>
                        <th color: var(--bs-body-bg);>Alamat</th>
                        <th color: var(--bs-body-bg);>Indikator</th>
                        <th color: var(--bs-body-bg);>Evidence</th>
                        <th width="280px" color=var(--light)>Aksi</th>
                    </tr>
                    @foreach ($Evidence as $st)
                    <tr>
                        <td class="text-primary">{{ $st->id }}</td>
                        <td class="text-primary">{{ $st->name }}</td>
                        <td class="text-primary">{{ $st->alamat }}</td>
                        <td class="text-primary">{{ $st->indikator }}</td>
                        <td class="text-primary">
                            <img src="{{ asset('/storage/uploads/'.$st->image) }}" width="70px"> | 
                            <a href="{{ route('evidence.index'),$st->pdf_file }}">view</a>                
                        </td>
                        
                        <td>
                        <form action="{{ route('evidence.destroy',$st->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('evidence.show',$st->id) }}">Hapus</a>
                            <a class="btn btn-primary" href="{{ route('evidence.edit',$st->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex">
    {!! $Evidence->links() !!}
    </div>
    

@endsection