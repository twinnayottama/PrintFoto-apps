@extends('layouts.master')

@section('title-page')
    Edit
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Tambah Data Group</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('group.index') }}">Group</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Tambah Data Group</h4>
                </div>

                <div class="card-body">
                    <form id="main-form" method="POST" action="{{ route('group.update', $group->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="farmer_group">Kelompok Tani</label>
                            <input type="text" class="form-control @error('farmer_group') is-invalid @enderror"
                                name="farmer_group" id="farmer_group"
                                value="{{ old('farmer_group', $group->farmer_group) }}">
                        </div>

                        <div class="form-group">
                            <label for="chairman">Ketua</label>
                            <input type="text" class="form-control @error('chairman') is-invalid @enderror"
                                name="chairman" id="chairman" value="{{ old('chairman', $group->chairman) }}">
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" id="address" cols="30" rows="10"
                                class="form-control @error('address') is-invalid @enderror">{{ $group->address }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="link_foto_1">Gambar 1</label> <br>

                            @if ($group->link_foto_1)
                                <img src="{{ asset($group->link_foto_1) }}" alt="Location Image"
                                    class="img-fluid rounded w-50" />
                            @else
                                <p>Tidak ada gambar yang tersedia.</p>
                            @endif

                            <input class="form-control @error('link_foto_1') is-invalid @enderror" type="file"
                                name="link_foto_1" id="link_foto_1" autofocus />
                        </div>

                        <div class="form-group">
                            <label for="link_foto_2">Gambar 2</label> <br>

                            @if ($group->link_foto_2)
                                <img src="{{ asset($group->link_foto_2) }}" alt="Location Image"
                                    class="img-fluid rounded w-50" />
                            @else
                                <p>Tidak ada gambar yang tersedia.</p>
                            @endif

                            <input class="form-control @error('link_foto_2') is-invalid @enderror" type="file"
                                name="link_foto_2" id="link_foto_2" autofocus />
                        </div>

                        <button type="submit" id="submit-btn" class="btn btn-primary mr-2">Tambah</button>
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
            // Handle form submission using AJAX
            $('#main-form').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                const form = $(this);
                const formData = new FormData(form[0]); // Use FormData to handle file uploads
                const submitButton = $('#submit-btn');
                submitButton.prop('disabled', true).text('Loading...');

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST', // Use POST for form submission
                    data: formData,
                    contentType: false, // Prevent jQuery from setting content type
                    processData: false, // Prevent jQuery from processing data
                    success: function(response) {
                        if (response.success) {
                            // Flash message sukses
                            sessionStorage.setItem('success',
                                'kelompok tani berhasil disubmit.');
                            window.location.href =
                                "{{ route('group.index') }}"; // Redirect to index page
                        } else if (response.info) {
                            // Flash message info
                            sessionStorage.setItem('info',
                                'Tidak melakukan perubahan data pada kelompok tani.');
                            window.location.href =
                                "{{ route('group.index') }}"; // Redirect to index page
                        } else {
                            // Flash message error
                            $('#flash-messages').html('<div class="alert alert-danger">' +
                                response.error + '</div>');
                        }
                    },
                    error: function(response) {
                        const errors = response.responseJSON.errors;
                        for (let field in errors) {
                            let input = $('[name=' + field + ']');
                            let error = errors[field][0];
                            input.addClass('is-invalid');
                            // Remove existing invalid feedback to avoid duplicates
                            input.next('.invalid-feedback').remove();
                            input.after('<div class="invalid-feedback">' + error + '</div>');
                        }

                        const message = response.responseJSON.message ||
                            'Terdapat kesalahan pada peta lokasi.';
                        $('#flash-messages').html('<div class="alert alert-danger">' + message +
                            '</div>');
                    },
                    complete: function() {
                        submitButton.prop('disabled', false).text('Simpan');
                    }
                });
            });

            // Remove validation error on input change
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
                $(this).next('.invalid-feedback').remove();
            });
        });
    </script>
@endpush
