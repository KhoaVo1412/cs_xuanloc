@extends('layouts.app')
@section('content')
<section>
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h4 class="page-title fw-semibold fs-18 mb-0"></h4>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0 padding">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('units.index') }}">Danh Sách</a></li>
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
            <form id="form-units" action="{{ route('units.update', ['id' => $units->id]) }}" method="POST"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card custom-card">
                    <div class="card-header justify-content-between d-flex">
                        <h5>Chỉnh sửa: {{ $units->unit_name }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="unit_name" class="form-label">Tên Đơn Vị</label>
                                <input type="text" class="form-control" name="unit_name" placeholder="Tên"
                                    value="{{ $units->unit_name }}" required>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-md-4">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="Không hoạt động" @if ($units->status == 'Không hoạt động') selected
                                        @endif>
                                        Không hoạt động</option>
                                    <option value="Hoạt động" @if ($units->status == 'Hoạt động') selected @endif>Hoạt
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