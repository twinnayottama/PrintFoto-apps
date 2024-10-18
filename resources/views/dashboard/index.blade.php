@extends('layouts.master')

@section('title-page')
    Dashboard
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Dashboard</h1>
        </div>

        <div class="row">
            {{-- @foreach ($cards as $card)
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-{{ $card['bg_color'] }}">
                            <i class="{{ $card['icon'] }}"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ $card['title'] }}</h4>
                            </div>
                            <div class="card-body mt-3">
                                {{ $card['value'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}
        </div>

        <div class="section-body">
            {{-- <div class="card card-primary">
                <div class="card-header">
                    <h4>Tabel Data Label</h4>
                </div>

                <div class="card-body">
                    <div style="overflow-x: auto">
                        <table id="example" class="ui selectable celled table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor lot</th>
                                    <th>Jumlah Label</th>
                                    <th>Nomor seri label</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lots as $lot)
                                    <tr>
                                        <td>{{ ++$loop->index }}</td>
                                        <td>{{ $lot->lot_number }}</td>
                                        <td>{{ $lot->label_count ?? '' }}</td>
                                        <td>{{ $lot->firstLabel ? $lot->firstLabel->serial_number : '' }} -
                                            {{ $lot->lastLabel ? $lot->lastLabel->serial_number : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('#example').DataTable({
            rowReorder: true,
            layout: {
                topStart: {
                    pageLength: {
                        menu: [10, 25, 50, 100]
                    }
                },
                topEnd: {
                    search: {
                        placeholder: 'Type search here'
                    }
                },
                bottomEnd: {
                    paging: {
                        numbers: 3
                    }
                }
            },
            columnDefs: [{
                    className: "dt-head-center",
                    targets: [0, 1, 2, 3]
                },
                {
                    className: "dt-body-center",
                    targets: [0, 1, 2, 3]
                },
            ]
        });
    </script>
@endpush
