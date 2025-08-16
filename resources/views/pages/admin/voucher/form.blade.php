@extends('layouts.layout-admin')

@section('content')
    <div class="row" style="min-height: 74vh">
        <div class="col-lg-6 col-md-8 col-12 mx-auto px-lg-4 px-0">
            <h3 class="mt-3 mb-0 text-center">{{ isset($detail) ? 'Ubah' : 'Tambah' }} Voucher</h3>
            <p class="lead font-weight-normal opacity-8 mb-5 text-center"></p>
            <div class="card z-index-0">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-success shadow-primary border-radius-lg py-3 pe-1">
                        <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Form</h4>
                    </div>
                </div>
                <div class="card-body">
                    <form role="form" id="form" class="text-start"
                        action="{{ isset($detail) ? '/admin/voucher/update' : '/admin/voucher/create' }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <p class="m-0 p-0 mt-3">Hadiah</p>
                        <div class="input-group input-group-outline">
                            <select name="gift_id" class="form-control">
                                <option value="">-- Hadiah Dipilih Dengan Persen Kemungkinan --</option>
                                @foreach ($gifts as $gift)
                                    <option value="{{ $gift->id }}"
                                        {{ (isset($detail) && $detail->gift_id == $gift->id) ? 'selected' : '' }}>
                                        {{ $gift->name }} | {{ $gift->probability }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <p class="m-0 p-0 mt-3">Nama</p>
                        <div class="input-group input-group-outline">
                            <input class="form-control" placeholder="Ketik Nama"
                                value="{{ isset($detail) ? $detail->name : '' }}" name="name">
                        </div>

                        <p class="m-0 p-0 mt-3">Info</p>
                        <div class="input-group input-group-outline">
                            <input class="form-control" placeholder="Ketik Info"
                                value="{{ isset($detail) ? $detail->info : '' }}" name="info">
                        </div>

                        @if (!isset($detail))
                            <p class="m-0 p-0 mt-3 font-weight-bold">Masukkan Jumlah Tiket</p>
                            <div class="input-group input-group-outline">
                                <input type="number" value="1" class="form-control" placeholder="Masukkan Jumlah Tiket" name="bulk">
                            </div>
                        @endif

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

@section('script')
    <script>
        function togglePattern() {
            const section = document.getElementById('pattern-section');
            const button = document.getElementById('toggle-pattern-btn');

            const isHidden = section.style.display === 'none' || section.style.display === '';
            section.style.display = isHidden ? 'block' : 'none';
            button.textContent = isHidden ? '− Sembunyikan Pola Game' : '+ Tambah Pola Game (Opsional)';
        }
    </script>
@endsection
