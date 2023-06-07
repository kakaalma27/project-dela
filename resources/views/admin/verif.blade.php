@extends('layouts.main')
@section('title', 'Verification Data')
@section('main')
<div class="card">
    <div class="card-header shadow p-3">
        <p>Data Evidence</p>
    </div>
    <div class="card-body shadow p-3">
        <table class="table table-dark">
            <thead>
                <tr>
                    <th>No Id</th>
                    <th>Nama Dinas</th>
                    <th>Alamat</th>
                    <th>Indikator</th>
                    <th>Evidence</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Evidence as $st)
                    <tr>
                        <td>{{ $st->id }}</td>
                        <td>{{ $st->name }}</td>
                        <td>{{ $st->alamat }}</td>
                        <td>{{ $st->indikator }}</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#imageModal{{ $st->id }}">Show Image</a>
                            <div class="modal fade" id="imageModal{{ $st->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $st->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title text-dark text-center" id="imageModalLabel{{ $st->id }}">Image</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body text-center">
                                      <img src="{{ asset('/storage/assets/'.$st->image) }}" alt="Image" class="img-fluid">
                                      <a href="{{ route('evidence.download.image', [$st->id]) }}" class="btn btn-light mt-2">Download Image</a>
                                    </div>
                                  </div>
                                </div>
                              </div> |
                                    <a href="#" data-toggle="modal" data-target="#pdfModal{{ $st->id }}">View PDF</a>
                                    <div class="modal fade" id="pdfModal{{ $st->id }}" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel{{ $st->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text-dark text-center" id="pdfModalLabel{{ $st->id }}">PDF Viewer</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <iframe src="{{ asset('/storage/assets/' . $st->pdf) }}" frameborder="0" style="width:100%; height:600px;"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                
                        </td>
                        <td>
                            @foreach($projects as $project)
                                @if ($project->id == $st->id)
                                    @if ($project->status == '0')
                                        <button onClick="toggleStatus('{{$project->id}}')" class="btn btn-light">Verifikasi</button>
                                    @elseif ($project->status == '1')
                                        <button onClick="toggleStatus('{{$project->id}}')" class="btn btn-warning">Unverifikasi</button>
                                    @endif
                                    
                                    @if ($project->pending == '0')
                                        <button onClick="pending('{{$project->id}}')" class="btn btn-secondary">Pending</button>
                                    @elseif ($project->pending == '1')
                                        <button onClick="pending('{{$project->id}}')" class="btn btn-warning">Unpending</button>
                                    @endif
                                    
                                    @if ($project->invalid == '0')
                                        <button onClick="invalid('{{$project->id}}')" class="btn btn-success">Invalid</button>
                                    @elseif ($project->invalid == '1')
                                        <button onClick="invalid('{{$project->id}}')" class="btn btn-warning">Unvalid</button>
                                    @endif
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
    <script>
        $(document).ready(function() {
  $('#pdfModal{{ $st->id }}').on('shown.bs.modal', function() {
    var url = "{{ asset('/storage/assets/' . $st->pdf) }}";
    PDFJS.getDocument(url).promise.then(function(pdfDoc) {
      var pdfViewer = document.getElementById('pdfContainer{{ $st->id }}');
      for (var pageNum = 1; pageNum <= pdfDoc.numPages; pageNum++) {
        pdfDoc.getPage(pageNum).then(function(page) {
          var canvas = document.createElement('canvas');
          var context = canvas.getContext('2d');
          var viewport = page.getViewport({ scale: 1.5 });
          canvas.height = viewport.height;
          canvas.width = viewport.width;
          page.render({
            canvasContext: context,
            viewport: viewport
          });
          pdfViewer.appendChild(canvas);
        });
      }
    });
  });
});

    </script>
@endsection
