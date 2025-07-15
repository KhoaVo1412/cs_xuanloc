@extends('layouts.app')

@section('content')
<div class="page-title my-1">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h5></h5>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end" style="font-size: 16px;">
                <ol class="breadcrumb padding">
                    <li class="breadcrumb-item"><a href="/">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="/testing">Lô Đã Kiểm Nghiệm</a></li>
                    <li class="breadcrumb-item">Cập Nhật Kiểm Nghiệm</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('layouts.alert')
</div>

<div class="card">
    <div class="card-body">
        <h5 style="margin-bottom: 15px;">Cập Nhật Kiểm Nghiệm</h5>

        <form method="POST" action="{{ route('testing.update', $batch->id) }}" class="row">
            @csrf
            @method('PUT')

            <input type="hidden" name="id" value="{{ $batch->id }}">

            <div class="form-group col-lg-4">
                <label for="batch_code" class="text-dark">Mã Lô Hàng</label>
                <input type="text" class="form-control" id="batch_code" name="batch_code"
                    value="{{ $batch->batch_code }}" disabled>
            </div>

            <!-- <div class="form-group col-lg-4">
                <label for="ngay_gui_mau" class="text-dark">Ngày Gửi Mẫu</label>
                <div class="datepicker-wrapper">
                    <input type="text" class="form-control datetimepicker datepicker" name="ngay_gui_mau"
                        id="ngay_gui_mau" placeholder="dd/mm/yyyy"
                        value="{{ \Carbon\Carbon::parse($batch->testingResult->ngay_gui_mau)->format('d/m/Y') }}"
                        required autocomplete="off" onkeydown="return false;">
                    <i class="fa fa-calendar calendar-icon" style="cursor: pointer;"></i>
                </div>
            </div> -->
            <div class="form-group col-lg-4">
                <label for="date_sx" class="text-dark">Ngày Sản Xuất</label>
                <div class="datepicker-wrapper">
                    <input type="text" class="form-control datetimepicker datepicker" name="date_sx" id="date_sx"
                        placeholder="dd/mm/yyyy" value="{{ \Carbon\Carbon::parse($batch->date_sx)->format('d/m/Y') }}"
                        autocomplete="off" onkeydown="return false;">
                    <i class="fa fa-calendar calendar-icon" style="cursor: pointer;"></i>
                </div>
            </div>

            <div class="form-group col-lg-4">
                <label for="ngay_kiem_nghiem" class="text-dark">Ngày Kiểm Nghiệm</label>
                <div class="datepicker-wrapper">
                    <input type="text" class="form-control datetimepicker datepicker" name="ngay_kiem_nghiem"
                        id="ngay_kiem_nghiem" placeholder="dd/mm/yyyy"
                        value="{{ \Carbon\Carbon::parse(old('ngay_kiem_nghiem', $batch->testingResult->ngay_kiem_nghiem))->format('d/m/Y') }}"
                        required autocomplete="off" onkeydown="return false;">
                    <i class="fa fa-calendar calendar-icon" style="cursor: pointer;"></i>
                </div>
            </div>
            <div class="form-group col-lg-4">
                <label for="rank" class="text-dark">Xếp Hạng</label>
                {{-- <select class="form-control" id="rank" name="rank" required>
                    <option value="CV60" {{ old('rank', $batch->testingResult->rank) == 'CV60' ? 'selected' : '' }}>
                        CV60</option>
                    <option value="CV50" {{ old('rank', $batch->testingResult->rank) == 'CV50' ? 'selected' : '' }}>
                        CV50</option>
                    <option value="3L" {{ old('rank', $batch->testingResult->rank) == '3L' ? 'selected' : '' }}>3L
                    </option>
                    <option value="5" {{ old('rank', $batch->testingResult->rank) == '5' ? 'selected' : '' }}>5
                    </option>
                    <option value="10" {{ old('rank', $batch->testingResult->rank) == '10' ? 'selected' : '' }}>10
                    </option>
                    <option value="20" {{ old('rank', $batch->testingResult->rank) == '20' ? 'selected' : '' }}>15
                    </option>
                </select> --}}

                <select class="form-control" id="rank" name="rank" required>
                    <option value="cv60" {{ old('rank', $batch->testingResult->rank) == 'cv60' ? 'selected' : '' }}>
                        CV60
                    </option>
                    <option value="cv50" {{ old('rank', $batch->testingResult->rank) == 'cv50' ? 'selected' : '' }}>
                        CV50
                    </option>
                    <option value="3l" {{ old('rank', $batch->testingResult->rank) == '3l' ? 'selected' : '' }}>3L
                    </option>
                    <option value="5" {{ old('rank', $batch->testingResult->rank) == '5' ? 'selected' : '' }}>5
                    </option>
                    <option value="10" {{ old('rank', $batch->testingResult->rank) == '10' ? 'selected' : '' }}>10
                    </option>
                    <option value="20" {{ old('rank', $batch->testingResult->rank) == '20' ? 'selected' : '' }}>20
                    </option>
                </select>
            </div>



            <div class="form-group col-lg-4">
                <label for="type" class="text-dark">Loại Kiểm Nghiệm</label>
                <select id="contract_type_id" name="type" class="form-select" disabled>
                    <option value="svr" {{ $batch->type == 'svr' ? 'selected' : '' }}>SVR</option>
                    {{-- <option value="latex" {{ $batch->type == "latex" ? 'selected' : '' }}>Latex</option> --}}
                    {{-- <option value="rss" {{ $batch->type == "rss" ? 'selected' : '' }}>RSS</option> --}}
                </select>
            </div>
            <div class="form-group col-lg-4">
                <label for="factory_id" class="text-dark">Nhà Máy</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="factory_name" value="{{ $factory->factory_name }}"
                        readonly>
                </div>
            </div>
            <style>
                #svr {
                    padding: 0;
                    margin: 0;
                }
            </style>
            <div id="svr" class="row">
                <div class="fs-5 fw-bold my-3">Kết Quả Kiểm Nghiệm SVR</div>
                <div
                    class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                    <label for="svr_impurity" class="text-dark">Tạp Chất</label>
                    <input type="number" min="0" step="any" class="form-control" id="svr_impurity" name="svr_impurity"
                        value="{{ old('svr_impurity', $batch->testingResult->svr_impurity) }}" placeholder="Tạp Chất">
                </div>
                <div
                    class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                    <label for="svr_ash" class="text-dark">Tro</label>
                    <input type="number" min="0" step="any" class="form-control" id="svr_ash" name="svr_ash"
                        value="{{ old('svr_ash', $batch->testingResult->svr_ash) }}" placeholder="Tro">
                </div>
                <div
                    class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                    <label for="svr_volatile" class="text-dark">Bay Hơi</label>
                    <input type="number" min="0" step="any" class="form-control" id="svr_volatile" name="svr_volatile"
                        value="{{ old('svr_volatile', $batch->testingResult->svr_volatile) }}" placeholder="Bay hơi">
                </div>
                <div
                    class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                    <label for="svr_nitrogen" class="text-dark">Nitơ</label>
                    <input type="number" min="0" step="any" class="form-control" id="svr_nitrogen" name="svr_nitrogen"
                        value="{{ old('svr_nitrogen', $batch->testingResult->svr_nitrogen) }}" placeholder="Nitơ">
                </div>
                <div class="form-group col-lg-3 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                    <label for="svr_po" class="text-dark">Po</label>
                    <input type="text" class="form-control" id="svr_po" name="svr_po"
                        value="{{ old('svr_po', $batch->testingResult->svr_po) }}" placeholder="PO">
                    <!-- <input type="number" min="0" step="any" class="form-control" id="svr_po"
                        name="svr_po" value="{{ old('svr_po', $batch->testingResult->svr_po) }}" placeholder="PO"> -->
                </div>
                <div
                    class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                    <label for="svr_pri" class="text-dark">PRI</label>
                    <input type="text" class="form-control" id="svr_pri" name="svr_pri"
                        value="{{ old('svr_pri', $batch->testingResult->svr_pri) }}" placeholder="PRI">
                    <!-- <input type="number" min="0" step="any" class="form-control" id="svr_pri"
                        name="svr_pri" value="{{ old('svr_pri', $batch->testingResult->svr_pri) }}"
                        placeholder="PRI"> -->
                </div>
                <div class="form-group col-lg-3 toggle-on-3l">
                    <label for="svr_vr" class="text-dark">Lovibond</label>
                    <input type="number" min="0" step="any" class="form-control" id="svr_vr" name="svr_vr"
                        value="{{ old('svr_vr', $batch->testingResult->svr_vr) }}" placeholder="Lovibond">
                </div>
                {{-- <div class="form-group col-lg-3 toggle-on-3l">
                    <label for="svr_width">Độ Rộng</label>
                    <input type="number" min="0" step="any" class="form-control" id="svr_width" name="svr_width"
                        value="{{ old('svr_width', $batch->testingResult->svr_width) }}" placeholder="Độ rộng">
                </div> --}}

                <div class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50">
                    <label for="svr_viscous" class="text-dark">Độ Nhớt</label>
                    <input type="text" class="form-control" id="svr_viscous" name="svr_viscous"
                        value="{{ old('svr_viscous', $batch->testingResult->svr_viscous) }}" placeholder="Độ Nhớt">
                    <!-- <input type="number" min="0" step="any" class="form-control" id="svr_viscous"
                    name="svr_viscous" value="{{ old('svr_viscous', $batch->testingResult->svr_viscous) }}"
                    placeholder="Độ Nhớt"> -->
                </div>

                <div class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l">
                    <label for="svr_vul" class="text-dark">Lưu Hóa</label>
                    <input type="text" class="form-control" id="svr_vul" name="svr_vul"
                        value="{{ old('svr_vul', $batch->testingResult->svr_vul) }}" placeholder="Lưu Hóa">
                </div>

                <!-- <div
                class="form-group col-lg-3 toggle-on-cv60 toggle-on-cv50 toggle-on-3l toggle-on-5 toggle-on-10 toggle-on-20">
                <label for="svr_color" class="text-dark">Màu</label>
                <select class="form-control" id="svr_color" name="svr_color">
                    <option value="">-- Chọn Màu --</option>
                    <option value="dacam"
                        {{ old('svr_color', $batch->testingResult->svr_color) == 'dacam' ? 'selected' : '' }}>
                        Da
                        cam</option>
                    <option value="xanhlacaynhat"
                        {{ old('svr_color', $batch->testingResult->svr_color) == 'xanhlacaynhat' ? 'selected' : '' }}>
                        Xanh lá cây nhạt</option>
                    <option value="nau"
                        {{ old('svr_color', $batch->testingResult->svr_color) == 'nau' ? 'selected' : '' }}>
                        Nâu
                    </option>
                    <option value="do"
                        {{ old('svr_color', $batch->testingResult->svr_color) == 'do' ? 'selected' : '' }}>
                        Đỏ
                    </option>
                </select>
            </div> -->

            </div>

            <div id="latex" class="row">
                <div class="fs-5 fw-bold my-3">Kết Quả Kiểm Nghiệm LATEX</div>
                <div class="form-group col-lg-3">
                    <label for="latex_tsc">TSC</label>
                    <input type="text" class="form-control" id="latex_tsc" name="latex_tsc"
                        value="{{ old('latex_tsc', $batch->testingResult->latex_tsc) }}" placeholder="TSC">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_drc">DRC</label>
                    <input type="text" class="form-control" id="latex_drc" name="latex_drc"
                        value="{{ old('latex_drc', $batch->testingResult->latex_drc) }}" placeholder="DRC">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_nrs">Non Rubber Solids</label>
                    <input type="text" class="form-control" id="latex_nrs" name="latex_nrs"
                        value="{{ old('latex_nrs', $batch->testingResult->latex_nrs) }}"
                        placeholder="Non Rubber Solids">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_nh3">NH3</label>
                    <input type="text" class="form-control" id="latex_nh3" name="latex_nh3"
                        value="{{ old('latex_nh3', $batch->testingResult->latex_nh3) }}" placeholder="NH3">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_mst">MST</label>
                    <input type="text" class="form-control" id="latex_mst" name="latex_mst"
                        value="{{ old('latex_mst', $batch->testingResult->latex_mst) }}" placeholder="MST">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_vfa">VFA</label>
                    <input type="text" class="form-control" id="latex_vfa" name="latex_vfa"
                        value="{{ old('latex_vfa', $batch->testingResult->latex_vfa) }}" placeholder="VFA">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_koh">KOH</label>
                    <input type="text" class="form-control" id="latex_koh" name="latex_koh"
                        value="{{ old('latex_koh', $batch->testingResult->latex_koh) }}" placeholder="KOH">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_ph">pH</label>
                    <input type="text" class="form-control" id="latex_ph" name="latex_ph"
                        value="{{ old('latex_ph', $batch->testingResult->latex_ph) }}" placeholder="pH">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_coagulant">Đông kết</label>
                    <input type="text" class="form-control" id="latex_coagulant" name="latex_coagulant"
                        value="{{ old('latex_coagulant', $batch->testingResult->latex_coagulant) }}"
                        placeholder="Đông kết">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_residue">Cặn</label>
                    <input type="text" class="form-control" id="latex_residue" name="latex_residue"
                        value="{{ old('latex_residue', $batch->testingResult->latex_residue) }}" placeholder="Cặn">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_mg">Mg</label>
                    <input type="text" class="form-control" id="latex_mg" name="latex_mg"
                        value="{{ old('latex_mg', $batch->testingResult->latex_mg) }}" placeholder="Mg">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_mn">Mn</label>
                    <input type="text" class="form-control" id="latex_mn" name="latex_mn"
                        value="{{ old('latex_mn', $batch->testingResult->latex_mn) }}" placeholder="Mn">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_cu">Cu</label>
                    <input type="text" class="form-control" id="latex_cu" name="latex_cu"
                        value="{{ old('latex_cu', $batch->testingResult->latex_cu) }}" placeholder="Cu">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_acid_boric">Acid Boric</label>
                    <input type="text" class="form-control" id="latex_acid_boric" name="latex_acid_boric"
                        value="{{ old('latex_acid_boric', $batch->testingResult->latex_acid_boric) }}"
                        placeholder="Acid Boric">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_surface_tension">Sức căng bề mặt</label>
                    <input type="text" class="form-control" id="latex_surface_tension" name="latex_surface_tension"
                        value="{{ old('latex_surface_tension', $batch->testingResult->latex_surface_tension) }}"
                        placeholder="Sức căng bề mặt">
                </div>
                <div class="form-group col-lg-3">
                    <label for="latex_viscosity">Độ nhớt Brookfield</label>
                    <input type="text" class="form-control" id="latex_viscosity" name="latex_viscosity"
                        value="{{ old('latex_viscosity', $batch->testingResult->latex_viscosity) }}"
                        placeholder="Độ nhớt Brookfield">
                </div>
            </div>

            <div id="rss" class="row">
                <div class="fs-5 fw-bold my-3">Kết Quả Kiểm Nghiệm RSS</div>
                <div class="form-group col-lg-3">
                    <label for="rss_impurity">Chất bẩn</label>
                    <input type="text" class="form-control" id="rss_impurity" name="rss_impurity"
                        value="{{ old('rss_impurity', $batch->testingResult->rss_impurity) }}" placeholder="Chất bẩn">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_ash">Tro</label>
                    <input type="text" class="form-control" id="rss_ash" name="rss_ash"
                        value="{{ old('rss_ash', $batch->testingResult->rss_ash) }}" placeholder="Tro">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_volatile">Bay hơi</label>
                    <input type="text" class="form-control" id="rss_volatile" name="rss_volatile"
                        value="{{ old('rss_volatile', $batch->testingResult->rss_volatile) }}" placeholder="Bay hơi">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_nitrogen">Nitơ</label>
                    <input type="text" class="form-control" id="rss_nitrogen" name="rss_nitrogen"
                        value="{{ old('rss_nitrogen', $batch->testingResult->rss_nitrogen) }}" placeholder="Nitơ">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_po">PO</label>
                    <input type="text" class="form-control" id="rss_po" name="rss_po"
                        value="{{ old('rss_po', $batch->testingResult->rss_po) }}" placeholder="PO">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_pri">PRI</label>
                    <input type="text" class="form-control" id="rss_pri" name="rss_pri"
                        value="{{ old('rss_pri', $batch->testingResult->rss_pri) }}" placeholder="PRI">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_vr">VR</label>
                    <input type="text" class="form-control" id="rss_vr" name="rss_vr"
                        value="{{ old('rss_vr', $batch->testingResult->rss_vr) }}" placeholder="VR">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_aceton">Aceton</label>
                    <input type="text" class="form-control" id="rss_aceton" name="rss_aceton"
                        value="{{ old('rss_aceton', $batch->testingResult->rss_aceton) }}" placeholder="Aceton">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_tensile_strength">Lực kéo đứt</label>
                    <input type="text" class="form-control" id="rss_tensile_strength" name="rss_tensile_strength"
                        value="{{ old('rss_tensile_strength', $batch->testingResult->rss_tensile_strength) }}"
                        placeholder="Lực kéo đứt">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_elongation">Độ dãn dài</label>
                    <input type="text" class="form-control" id="rss_elongation" name="rss_elongation"
                        value="{{ old('rss_elongation', $batch->testingResult->rss_elongation) }}"
                        placeholder="Độ dãn dài">
                </div>
                <div class="form-group col-lg-3">
                    <label for="rss_vulcanization">Lưu hóa</label>
                    <input type="text" class="form-control" id="rss_vulcanization" name="rss_vulcanization"
                        value="{{ old('rss_vulcanization', $batch->testingResult->rss_vulcanization) }}"
                        placeholder="Lưu hóa">
                </div>
            </div>

            <script>
                $(document).ready(function() {
            $('#svr, #latex, #rss').hide();
            $('#contract_type_id').change(function() {
                var selectedValue = $(this).val();
                $('#svr, #latex, #rss').hide();
                if (selectedValue === 'svr') {
                    $('#svr').show();
                } else if (selectedValue === 'latex') {
                    $('#latex').show();
                } else if (selectedValue === 'rss') {
                    $('#rss').show();
                }
            });
            $('#contract_type_id').change();
        });
            </script>

            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Lưu Thay Đổi</button>
            </div>
        </form>

    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rankSelect = document.getElementById('rank');
        const allToggleFields = document.querySelectorAll('[class*="toggle-on-"]');
        let previousRank = rankSelect.value.toLowerCase(); // Lưu rank ban đầu

        function updateRequiredFields() {
            const selectedRank = rankSelect.value.toLowerCase();

            allToggleFields.forEach(field => {
                const input = field.querySelector('input, select, textarea');
                const classes = field.className.toLowerCase();

                if (previousRank !== selectedRank) {
                    if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    } else {
                        input.value = '';
                    }
                }

                if (input) {
                    if (classes.includes(`toggle-on-${selectedRank}`)) {
                        input.required = true; // bắt buộc nhập
                    } else {
                        input.required = false; // không bắt buộc
                    }
                }
            });
            previousRank = selectedRank; // Cập nhật lại rank cũ
        }

        // Lần đầu và khi chọn mới
        updateRequiredFields();
        rankSelect.addEventListener('change', updateRequiredFields);
    });
</script>
@endsection