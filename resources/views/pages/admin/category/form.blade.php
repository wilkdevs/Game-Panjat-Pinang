@extends('layouts.layout-admin')

@section('content')
    <div class="row" style="min-height: 74vh">
        <div class="col-lg-6 col-md-8 col-12 mx-auto px-lg-4 px-0">
            <h3 class="mt-3 mb-0 text-center">{{ isset($detail) ? 'Ubah' : 'Tambah' }} Kategori</h3>
            <p class="lead font-weight-normal opacity-8 mb-5 text-center"></p>
            <div class="card z-index-0">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Form</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form" id="form" class="text-start"
                        action="{{ isset($detail) ? '/admin/gift/category/update' : '/admin/gift/category/create' }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Kategori Name -->
                        <p class="m-0 p-0 mt-3">Nama Kategori</p>
                        <div class="input-group input-group-outline">
                            <input class="form-control" placeholder="Ketik Nama Kategori"
                                value="{{ isset($detail) ? $detail->name : '' }}" name="name">
                        </div>

                        @if (isset($detail))
                            <input type="hidden" name="id" value="{{ $detail->id }}">
                        @endif

                        <div class="text-center mb-3">
                            <button type="submit" class="btn bg-gradient-success w-100 my-4 mb-2">
                                {{ isset($detail) ? 'Ubah' : 'Simpan' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
