@extends('layouts.master')

@section('title-page')
    Create
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Group</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('group.index') }}">Group</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Tambah Data Group</h4>
                </div>

                <div class="card-body">
                    <form id="my-form" action="{{ route('group.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">Upload File Excel <span class="text-danger">(File harus berformat: xlsx,
                                    xls, csv)</span></label>
                            <input type="file" name="file" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2" id="btnSubmit">Tambah</button>
                        <a href="{{ route('group.index') }}" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#my-form').on('submit', function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                $('#btnSubmit').prop('disabled', true).text('Loading...');

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            sessionStorage.setItem('success',
                                'Berhasil menambahkan data group');
                            window.location.href = "{{ route('group.index') }}";
                        }
                    },
                    error: function(response) {
                        if (response.responseJSON.error) {
                            sessionStorage.setItem('error', response.responseJSON.error);
                            window.location.href = "{{ route('group.index') }}";
                        }
                    },
                    complete: function() {
                        $('#btnSubmit').prop('disabled', false).text('Tambah');
                    }
                });
            });
        });
    </script>
@endpush
