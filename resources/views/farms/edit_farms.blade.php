@extends('layouts.app')
@section('content')
<section>
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h4 class="page-title fw-semibold fs-18 mb-0"></h4>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0 padding">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('farms.index') }}">Danh Sách</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa</li>
                </ol>
            </nav>
        </div>
    </div>

    <style>
        .tab-content {
            border-right: 1px solid #dee2e6;
            border-left: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
            padding: 5px;
        }

        .col-xl-4 {
            padding-top: 15px;
        }

        .form-label {
            font-weight: bold;
        }
    </style>

    <div class="row">
        <div class="col-xl-12">
            <form id="form-farms" action="{{ route('farms.update', ['id' => $farms->id]) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card custom-card">
                    <div class="card-header justify-content-between d-flex">
                        {{-- <div class="card-title">Chỉnh sửa: {{ $farms->farm_name }}</div> --}}
                        <h5>Chỉnh sửa: {{ $farms->farm_name }}</h5>
                        {{-- <div class="prism-toggle d-grid gap-2 d-md-flex justify-content-md-end"> --}}
                            {{-- <button type="submit" class="btn btn-info">
                                <a href="{{ route('farms.index') }}" style="color: #ffffff;">
                                    Danh sách
                                </a></button> --}}
                            {{-- <button type="submit" class="btn btn-secondary">Lưu thay đổi</button>
                        </div> --}}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="farm_code" class="form-label">Mã</label>
                                <input type="text" class="form-control" name="farm_code" placeholder="Mã"
                                    value="{{ $farms->farm_code }}" required>
                            </div>

                            <div class="col-md-4">
                                <label for="farm_name" class="form-label">Tên</label>
                                <input type="text" class="form-control" name="farm_name" placeholder="Tên"
                                    value="{{ $farms->farm_name }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="unit" class="form-label">Đơn Vị</label>
                                <select name="unit_id" id="unit" class="form-control" required>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" @if($farms->unit_id == $unit->id) selected @endif>
                                        {{ $unit->unit_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- <div class="col-md-4">
                                <label for="unit" class="form-label">Đơn Vị</label>
                                <select name="unit" id="unit" class="form-control" required>
                                    <option value="Công ty Cổ phần Cao su Hoà Bình" @if($farms->unit === 'Công ty Cổ
                                        phần Cao su Hoà Bình') selected @endif>
                                        Công ty Cổ phần Cao su Hoà Bình
                                    </option>
                                    <option value="Công ty Cổ phần Cao su Thống Nhất" @if($farms->unit === 'Công ty Cổ
                                        phần Cao su Thống Nhất') selected @endif>
                                        Công ty Cổ phần Cao su Thống Nhất
                                    </option>
                                </select>
                            </div> --}}
                            <!-- Trạng thái -->
                            <div class="col-md-4">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Không hoạt động" @if ($farms->status == 'Không hoạt động') selected
                                        @endif>
                                        Không hoạt động</option>
                                    <option value="Hoạt động" @if ($farms->status == 'Hoạt động') selected @endif>Hoạt
                                        động</option>
                                </select>
                            </div>
                            <div class="p-t-10 col-sm-12" style="margin-top: 10px">
                                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>
@endsection