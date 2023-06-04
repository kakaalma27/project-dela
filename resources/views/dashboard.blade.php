@extends('layouts.main')

@section('main')
<div>
    Total Documents: {{ $totalDocuments }}
</div>
<div>
    Valid Documents: {{ $validDocuments }}
</div>
<div>
    Pending Documents: {{ $pendingDocuments }}
</div>
<div>
    Invalid Documents: {{ $invalidDocuments }}
</div>


@endsection