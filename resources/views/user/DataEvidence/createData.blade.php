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
                        <div class="row align-items-start">
                        <div class="col-md-4">
                          <select id="domainSelect" name="domain" class="form-select"  onchange="updateIndicatorOptions()">
                            <option value="">Pilih Domain</option>
                            <option value="domain1">DOMAIN 1. Kebijakan Internal SPBE</option>
                            <option value="domain2">DOMAIN 2. Tata Kelola SPBE</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <select id="indicatorSelect" name="indikator" class="form-select">
                            <option value="">Pilih Indikator</option>
                          </select>
                        </div>
                      </div>
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
<script>
  function updateIndicatorOptions() {
    var domainSelect = document.getElementById("domainSelect");
    var indicatorSelect = document.getElementById("indicatorSelect");
    indicatorSelect.innerHTML = ""; // Hapus semua opsi indikator sebelumnya
    
    if (domainSelect.value === "domain1") {
      var option1 = document.createElement("option");
      option1.text = "Indikator 1 : Tingkat Kematangan Kebijakan Internal Arsitektur SPBE Instansi Pusat/Pemerintah Daerah";
      option1.value = "Indikator 1 : Tingkat Kematangan Kebijakan Internal Arsitektur SPBE Instansi Pusat/Pemerintah Daerah";
      indicatorSelect.add(option1);

      var option2 = document.createElement("option");
      option2.text = "Tingkat Kematangan 2";
      option2.value = "indicator2";
      indicatorSelect.add(option2);
    } else if (domainSelect.value === "domain2") {
      var optionX = document.createElement("option");
      optionX.text = "Indikator X";
      optionX.value = "indicatorX";
      indicatorSelect.add(optionX);
    }
  }
</script>