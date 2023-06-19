@extends('layouts.main')
@section('title', 'Verification Data')
@section('main')
<div class="card">
    <div class="card-header shadow p-3">
        <p>Data Evidence</p>
    </div>
    <div class="card-body shadow p-2">
        <table class="table">
            <thead class="thead">
                <tr>
                    <th>No_Id</th>
                    <th>Nama Dinas</th>
                    <th>Alamat</th>
                    <th style="width: 350px;">Indikator</th>
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
                            @if ($st->image)

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
                                    @foreach ($st->image as $image)
                                    <div class="modal-body text-center">
                                        <img src="{{ asset('/storage/assets/'.$image) }}" alt="Image" class="img-fluid">
                                        <a class="btn btn-light mt-2" href="{{ route('data.download.image', $st->id) }}">Download PDF</a>
                                    </div>
                                    @endforeach
                                  </div>
                                </div>
                              </div> 
                              @endif
                              
                              @if ($st->pdf)
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
                                                @foreach ($st->pdf as $pdf)
                                                <div class="modal-body text-center">
                                                    <iframe src="{{ asset('/storage/assets/'.$pdf) }}" frameborder="0" style="width:100%; height:600px;"></iframe>
                                                    <a class="btn btn-light mt-2" href="{{ route('data.download.pdf', $st->id) }}">Download PDF</a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>        
                                @endif
                        </td>
                        <td>
                            @foreach($projects as $project)
                            @if ($project->id == $st->id)
                                @if ($project->status == '0')
                                    <button onClick="status('{{$project->id}}')" class="btn btn-light" id="statusButton{{$project->id}}">Verifikasi</button>
                                @elseif ($project->status == '1')
                                    <button onClick="status('{{$project->id}}')" class="btn btn-warning" id="statusButton{{$project->id}}">Unverifikasi</button>
                                @endif
                        
                                @if ($project->pending == '0')
                                    <button onClick="pending('{{$project->id}}')" class="btn btn-secondary" id="pendingButton{{$project->id}}">Pending</button>
                                @elseif ($project->pending == '1')
                                    <button onClick="pending('{{$project->id}}')" class="btn btn-warning" id="pendingButton{{$project->id}}">Unpending</button>
                                @endif
                        
                                @if ($project->invalid == '0')
                                    <button onClick="invalid('{{$project->id}}')" class="btn btn-success" id="invalidButton{{$project->id}}">Invalid</button>
                                @elseif ($project->invalid == '1')
                                    <button onClick="invalid('{{$project->id}}')" class="btn btn-warning" id="invalidButton{{$project->id}}">Unvalid</button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function status(project_id) {
        fetch("{{ route('projects.status') }}?project_id=" + project_id)
            .then(response => response.json())
            .then(response => {
                document.querySelector("#project-status-" + project_id).innerHTML = response.status;
         })
         var button = $("#statusButton" + project_id);
        button.toggleClass("btn-light btn-warning");
        var buttonText = button.text().trim();
        if (buttonText === "Verifikasi") {
            button.text("Unverifikasi");
        } else {
            button.text("Verifikasi");
        }
    }
    function pending(project_id) {
        fetch("{{ route('projects.pending') }}?project_id=" + project_id)
            .then(response => response.json())
            .then(response => {
                document.querySelector("#project-pending-" + project_id).innerHTML = response.pending;
         })
         var button = $("#pendingButton" + project_id);
        button.toggleClass("btn-secondary btn-warning");
        var buttonText = button.text().trim();
        if (buttonText === "Pending") {
            button.text("Unpending");
        } else {
            button.text("Pending");
        }
    }
    function invalid(project_id) {
        fetch("{{ route('projects.invalid') }}?project_id=" + project_id)
            .then(response => response.json())
            .then(response => {
                document.querySelector("#project-invalid-" + project_id).innerHTML = response.invalid;
         })
         var button = $("#invalidButton" + project_id);
        button.toggleClass("btn-success btn-warning");
        var buttonText = button.text().trim();
        if (buttonText === "Invalid") {
            button.text("Unvalid");
        } else {
            button.text("Invalid");
        }
    }
</script>
{{-- <script>
    function status(project_id) {
        var button = $("#statusButton" + project_id);
        button.toggleClass("btn-light btn-warning");
        var buttonText = button.text().trim();
        if (buttonText === "Verifikasi") {
            button.text("Unverifikasi");
        } else {
            button.text("Verifikasi");
        }
    }

    function pending(project_id) {
        var button = $("#pendingButton" + project_id);
        button.toggleClass("btn-secondary btn-warning");
        var buttonText = button.text().trim();
        if (buttonText === "Pending") {
            button.text("Unpending");
        } else {
            button.text("Pending");
        }
    }

    function invalid(project_id) {
        var button = $("#invalidButton" + project_id);
        button.toggleClass("btn-success btn-warning");
        var buttonText = button.text().trim();
        if (buttonText === "Invalid") {
            button.text("Unvalid");
        } else {
            button.text("Invalid");
        }
    }
</script> --}}
<script>
    $(document).ready(function() {
        @isset($st)
        $('#pdfModal{{ $st->id }}').on('shown.bs.modal', function() {
            @foreach ($st->pdf as $pdf)
    var url = "{{ asset('/storage/assets/'.$pdf) }}";
    // Gunakan variabel url untuk tujuan yang sesuai di sini
@endforeach

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
        @endisset
    });
</script>
@endsection
