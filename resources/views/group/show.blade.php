@extends('layouts.master')

@section('title-page')
    Show
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Lihat Data Group</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('group.index') }}">Group</a></div>
                <div class="breadcrumb-item">Show</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Lihat Data Group</h4>
                </div>

                <div class="card-body">
                    <form>
                        @csrf

                        <div class="form-group">
                            <label for="farmer_group">Kelompok Tani</label>
                            <input type="text" class="form-control" id="farmer_group" value="{{ $group->farmer_group }}"
                                disabled>
                        </div>

                        <div class="form-group">
                            <label for="chairman">Ketua</label>
                            <input type="text" class="form-control" id="chairman" value="{{ $group->chairman }}"
                                disabled>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" class="form-control" id="address" cols="30" rows="10" disabled>{{ $group->address }}</textarea>
                        </div>

                        {{-- <div class="form-group">
                            <label for="farmer_group">Kelompok Tani</label>
                            <input type="text" id="farmer_group" value="{{ $group->farmer_group }}" disabled>
                        </div> --}}

                        <a href="{{ route('group.index') }}" class="btn btn-warning">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
