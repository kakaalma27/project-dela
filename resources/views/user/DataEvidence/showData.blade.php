@extends('layouts.user')
@section('main')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                <a href="{{ route('create-data') }}" class="btn btn-primary">Insert</a>
                </div>
                <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif                
                <table class="table table-bordered">
                    <tr>
                        <th>No Id</th>
                        <th>Nama Dinas</th>
                        <th>Alamat</th>
                        <th>Indikator</th>
                        <th>Evidence</th>
                        <th width="280px">Aksi</th>
                    </tr>
                    @foreach ($Evidence as $st)
                    <tr>
                        <td>{{ $st->id }}</td>
                        <td>{{ $st->name }}</td>
                        <td>{{ $st->alamat }}</td>
                        <td>{{ $st->indikator }}</td>
                        <td>
                            <img src="{{ asset('/storage/uploads/'.$st->image) }}" width="70px"> | 
                            <a href="{{ route('evidence.index'),$st->pdf_file }}">view</a>                
                        </td>

                        {{-- <td>
                            <button>a</button>
                        </td> --}}
                    </tr>
                    @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="d-flex">
    {!! $Evidence->links() !!}
    </div> --}}
    

@endsection