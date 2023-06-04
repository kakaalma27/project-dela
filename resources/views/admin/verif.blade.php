@extends('layouts.main')

@section('main')
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No Id</th>
                <th scope="col">Nama Dinas</th>
                <th scope="col">Alamat</th>
                <th scope="col">Indikator</th>
                <th scope="col">Evidence</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Evidence as $st)
                <tr>
                    <td scope="row">{{ $st->id }}</td>
                    <td scope="row">{{ $st->name }}</td>
                    <td scope="row">{{ $st->alamat }}</td>
                    <td scope="row">{{ $st->indikator }}</td>
                    <td scope="row">
                        <img src="{{ asset('/storage/uploads/'.$st->image) }}" width="70px"> |
                        <a href="{{ route('evidence.index'),$st->pdf_file }}">view</a>
                    </td>
                    <td>
                        @foreach($projects as $project)
                            @if ($project->id == $st->id)
                                @if ($project->status == '0')
                                    <button onClick="toggleStatus('{{$project->id}}')">Verifikasi</button>
                                @elseif ($project->status == '1')
                                    <button onClick="toggleStatus('{{$project->id}}')">Unverifikasi</button>
                                @endif
                                
                                @if ($project->pending == '0')
                                    <button onClick="pending('{{$project->id}}')">Pending</button>
                                @elseif ($project->pending == '1')
                                    <button onClick="pending('{{$project->id}}')">Unpending</button>
                                @endif
                                
                                @if ($project->invalid == '0')
                                    <button onClick="invalid('{{$project->id}}')">Invalid</button>
                                @elseif ($project->invalid == '1')
                                    <button onClick="invalid('{{$project->id}}')">Unvalid</button>
                                @endif
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function toggleStatus(project_id) {
            fetch("{{ route('projects.toggle') }}?project_id=" + project_id)
                .then(response => response.json())
                .then(response => {
                    document.querySelector("#project-status-" + project_id).innerHTML = response.status;
             })
        }
        function pending(project_id) {
            fetch("{{ route('projects.pending') }}?project_id=" + project_id)
                .then(response => response.json())
                .then(response => {
                    document.querySelector("#project-pending-" + project_id).innerHTML = response.pending;
             })
        }
        function invalid(project_id) {
            fetch("{{ route('projects.invalid') }}?project_id=" + project_id)
                .then(response => response.json())
                .then(response => {
                    document.querySelector("#project-invalid-" + project_id).innerHTML = response.invalid;
             })
        }
    </script>
@endsection
