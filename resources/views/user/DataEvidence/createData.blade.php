@extends('layouts.user')
@section('title', 'From Evidence')
@section('main')
<div class="row">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <a href="{{ route('') }}" class="btn btn-success">Back</a>
                </div> --}}
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
                <form action="{{ route('create.data') }}" method="POST" enctype="multipart/form-data">
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
                      <select name="indikator" class="form-control" onchange="getData()" onmousedown="if(this.options.length>8){this.size=8;}"  onchange='this.size=0;' onblur="this.size=0;">
                        <optgroup label="Group 1">
                          <option value="1">Option 1.1</option>
                          <option value="2">Option 1.2</option>
                          <option value="3">Option 1.3</option>
                        </optgroup>
                        <optgroup label="Group 2">
                          <option value="4">Option 2.1</option>
                          <option value="5">Option 2.2</option>
                          <option value="6">Option 2.3</option>
                        </optgroup>
                      </select>
                    </div>
                    
                    <script>
                      function getData() {
                        var selectElement = document.getElementsByName("indikator")[0];
                        var selectedValue = selectElement.value;
                        
                        // Lakukan tindakan berdasarkan nilai yang dipilih
                        console.log("Anda memilih opsi dengan nilai: " + selectedValue);
                      }
                    </script>
                    <div class="mb-3">
                        <strong>Image</strong>
                        <input type="file" name="images[]" class="form-control" placeholder="image" multiple>
                    </div>
                    <div class="mb-3">
                        <strong>PDF</strong>
                        <input type="file" name="pdf[]" class="form-control" placeholder="pdf" multiple>
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
