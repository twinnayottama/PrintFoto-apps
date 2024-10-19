@extends('layouts.master')

@section('title-page')
    Group
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Data Group</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Group</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Tabel Data Group</h4>
                    <div class="card-header-action">
                        <a href="{{ route('group.create') }}" class="btn btn-primary">
                            Tambah Data
                        </a>
                        <form action="{{ route('group.deleteAll') }}" method="POST" id="delete-all-form">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-danger mr-2" id="delete-all-button">Hapus semua
                                Data</button>
                        </form>
                        <a href="{{ route('group.exportToWord') }}" class="btn btn-success">Download Data</a>
                    </div>
                </div>

                <div class="card-body">
                    <div style="overflow-x: auto;">
                        <table id="example" class="ui selectable celled table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kelompok Tani</th>
                                    <th>Ketua</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groups as $group)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $group->farmer_group ?? '' }}</td>
                                        <td>{{ $group->chairman ?? '' }}
                                        </td>
                                        <td>{{ $group->address ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('group.show', $group->id) }}"
                                                class="btn btn-warning mr-2 mb-2"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('group.destroy', $group->id) }}"
                                                class="btn btn-danger mr-2 mb-2 delete-item"><i
                                                    class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('#example').DataTable({
            "pageLength": 10, // Tampilkan 10 data per halaman
            "ordering": false, // Optional: Disable sorting if not needed
            "searching": true, // Enable search
            "paging": true, // Enable pagination
            "info": true, // Show information about number of entries
            rowReorder: true,
            columnDefs: [{
                    className: "dt-head-center",
                    targets: [0, 1, 2, 3, 4]
                },
                {
                    className: "dt-body-center",
                    targets: [0, 1, 2, 3, 4]
                },
            ]
        });
    </script>

    <script>
        document.getElementById('delete-all-button').addEventListener('click', function() {
            if (confirm('Apakah anda ingin menghapus semua data label?')) {
                document.getElementById('delete-all-form').submit();
            }
        });
    </script>
@endpush
