@extends('layouts.user')
@section('title','Data Evidence')
@section('main')
<div class="card">
    <div class="card-header shadow p-3">
        <p>Data Evidence</p>
    </div>
    <div class="card-body shadow p-3">
        <table class="table">
            <thead class="thead">
                <tr>
                    <th>No_Id</th>
                    <th>Nama Dinas</th>
                    <th>Alamat</th>
                    <th style="width: 350px;">Indikator</th>
                    <th>Evidence</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($data['Evidence'] as $st)
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
                                            <h5 class="modal-title" id="imageModalLabel{{ $st->id }}">Image</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @foreach ($st->image as $image)
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('/storage/assets/'.$image) }}" alt="Image" class="img-fluid">
                                                <a class="btn btn-light mt-2" href="{{ route('data.download.image', $st->id) }}">Download Image</a>
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
                                            <h5 class="modal-title" id="pdfModalLabel{{ $st->id }}">PDF Viewer</h5>
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
                          @if ($st->document->status == '0')
                          {{-- <button class="btn btn-light">Unverifikasi</button> --}}
                      @elseif ($st->document->status == '1')
                        <button class="btn btn-success">Diterima</button>
                      @endif
          
                      @if ($st->document->invalid == '0')
                          {{-- <button class="btn btn-secondary">Unpending</button> --}}
                      @elseif ($st->document->invalid == '1')
                         <button class="btn btn-secondary">Ditolak</button>
                      @endif
          
                      @if ($st->document->pending == '0')
                          {{-- <button class="btn btn-success">Unvalid</button> --}}
                      @elseif ($st->document->pending == '1')
                          <button class="btn btn-danger">Sedang ditinjau</button>
                      @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        @isset($st)
        $('#pdfModal{{ $st->id }}').on('shown.bs.modal', function() {
            @if ($st->pdf && is_array($st->pdf))
                @foreach ($st->pdf as $pdf)
                    var url = "{{ asset('/storage/assets/'.$pdf) }}";
                @endforeach
            @endif


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


