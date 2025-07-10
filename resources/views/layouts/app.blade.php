<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOA BINH RUBBER</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js">
    </script>
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <link rel="stylesheet" href="/mazer-1.0.0/dist/assets/css/bootstrap.css">

    <link rel="stylesheet" href="/mazer-1.0.0/dist/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="/mazer-1.0.0/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="/mazer-1.0.0/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="/mazer-1.0.0/dist/assets/css/app.css">
    <link rel="stylesheet" href="/FontAwesome6.4Pro/css/all.css">
    <link rel="shortcut icon" href="/imgs/favicon.ico" type="image/x-icon">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css">



    {{--
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    {{--
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script> --}}

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    {{--
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css"> --}}

    {{-- Chartjs --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <!-- Tempus Dominus Datepicker -->
    <!-- Popperjs -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js"
        crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/css/tempus-dominus.min.css"
        crossorigin="anonymous">

</head>

<body>
    <div class="loading-wrapper">
        <span class="loader"></span>
    </div>
    <style>
        .dt-type-numeric {
            text-align: left !important
        }
    </style>
    <style>
        .loading-wrapper {
            position: fixed;
            background-color: rgb(248, 248, 248);
            z-index: 1000;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center
        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            border-top: 4px solid #FFF;
            border-right: 4px solid transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after {
            content: '';
            box-sizing: border-box;
            position: fixed;
            left: 0;
            top: 0;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            border-bottom: 4px solid #750102;
            border-left: 4px solid transparent;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active"
                style="background: linear-gradient(to top, #144c0f, #306122, #6fb54cb8)">
                {{-- style="background: rgb(25 135 84)"> --}}
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="/"><img src="/imgs/lohogo_xl.png" alt="Logo" srcset=""
                                    style="width:100%; height: auto"></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <form id="logout-form" action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="BtnOut">
                                    <div class="sign">
                                        <i class="fa-solid fa-right-from-bracket text-white"
                                            style="font-size: 20px"></i>
                                    </div>
                                </button>
                            </form>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Danh mục</li>

                        <li class="sidebar-item">
                            <a href="/" class='sidebar-link' onclick="toggleActive(this)">
                                <i class="bi bi-grid-fill"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>

                        {{-- Quản Lý Nông trường --}}
                        @hasanyrole('Admin|Nông Trường|Danh Sách Nông Trường|Quản Lý Xe|Danh Sách Xe
                        |Quản Lý Nhà Máy|Danh Sách Nhà Máy|Quản Lý Thông Tin Nguyên Liệu|Danh Sách Nguyên Liệu')
                        <li
                            class="sidebar-item  has-sub {{ request()->is('add-plantingareas*') || request()->is('units*') || request()->is('edit-excel*') || request()->is('add-excel*') || request()->is('edit-plantingareas*') || request()->is('edit-ingredients*') || request()->is('save-ingredients*') || request()->is('add-ingredients*') || request()->is('import-ing*') || request()->is('factorys*') || request()->is('typeofpus*') || request()->is('ingredients*') || request()->is('farms*') || request()->is('vehicles*') || request()->is('plantingareas*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link {{ request()->is(' ingredients*') || request()->is('farms*')
                                ||
                                request()->is('units*') ||
                                request()->is('vehicles*') ||
                                request()->is('plantingareas*') ||
                                request()->is('factorys*') ||
                                request()->is('import-ing*') ||
                                request()->is('add-ingredients*') ||
                                request()->is('save-ingredients*') ||
                                request()->is('edit-ingredients*') ||
                                request()->is('edit-plantingareas*') ||
                                request()->is('add-excel*') ||
                                request()->is('edit-excel*') ||
                                request()->is('add-plantingareas*')
                                ? 'active'
                                : '' }}' onclick="toggleActive(this)">
                                <i class="fa-regular fa-farm"></i>
                                <span>Khu Vực</span>
                            </a>
                            <ul class="submenu {{ Route::is('add-plantingareas') ||
                                Route::is('edit-plantingareas') ||
                                Route::is('add-ingredients') ||
                                Route::is('edit-ingredients') ||
                                Route::is('farms.save') ||
                                Route::is('farms.edit') ||
                                Route::is('units.save') ||
                                Route::is('units.edit') ||
                                Route::is('importIng.index') ||
                                Route::is('typeofpus.index') ||
                                Route::is('typeofpus.edit') ||
                                Route::is('factorys.index') ||
                                Route::is('factorys.edit') ||
                                Route::is('units.index') ||
                                Route::is('farms.index') ||
                                Route::is('vehicles.index') ||
                                Route::is('vehicles.edit') ||
                                Route::is('ingredients.index') ||
                                Route::is('plantingareas.index') ||
                                Route::is('add-excel') ||
                                Route::is('edit-excel')
                                ? ' active' : '' }}">
                                @hasrole('Admin')
                                <li
                                    class="submenu-item d-flex d-flex align-items-center ms-3 {{ Route::is('farms.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-tree text-white"></i>
                                    <a href="{{ route('farms.index') }}">Danh Sách Khu Vực</a>
                                </li>
                                <li
                                    class="submenu-item d-flex d-flex align-items-center ms-3 {{ Route::is('units.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-building text-white"></i>
                                    <a href="{{ route('units.index') }}">Nông Trường</a>
                                </li>
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('typeofpus.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-octagon-plus text-white"></i>
                                    <a href="{{ route('typeofpus.index') }}">Tạo Mủ</a>
                                </li>
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('factorys.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-industry text-white"></i>
                                    <a href="{{ route('factorys.index') }}">Danh Sách Nhà Máy</a>
                                </li>
                                @endrole

                                @hasanyrole('Admin|Nông Trường|Quản Lý Xe|Danh Sách Xe')
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('vehicles.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-cars text-white"></i>
                                    <a href="{{ route('vehicles.index') }}">Danh Sách Xe</a>
                                </li>
                                @endhasanyrole

                                @hasanyrole('Admin|Nông Trường|Quản Lý Thông Tin Nguyên Liệu|Danh Sách Nguyên Liệu')
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('ingredients.index') ? ' active' : '' }}">
                                    <i class="fa-sharp fa-light fa-circle-info text-white"></i>
                                    <a href="{{ route('ingredients.index') }}">Thông Tin Nguyên Liệu</a>
                                </li>
                                @endhasanyrole

                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('importIng.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-file-import text-white"></i>
                                    <a href="{{ route('importIng.index') }}">File</a>
                                </li>
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('plantingareas.index') ? ' active' : '' }}">
                                    <i class="bi bi-grid-fill text-white"></i>
                                    <a href="{{ route('plantingareas.index') }}">Quản Lý Khu Vực Trồng</a>
                                </li>
                            </ul>
                        </li>
                        @endhasanyrole

                        {{-- Quản Lý Nhà Máy --}}
                        @hasanyrole('Nhà Máy XNCB|Admin|Danh Sách Nhà Máy XNCB|Quản Lý Mã Lô|Danh Sách Mã Lô
                        |Quản Lý Kết Nối TTNL|Danh Sách TTNL|Quản Lý LXH|Danh Sách LXH')
                        <li
                            class="sidebar-item  has-sub {{ request()->is('edit-orderbatchs*') || request()->is('add-orderbatchs*') || request()->is('edit-batches*') || request()->is('add-batches*') || request()->is('edit-batchesB*') || request()->is('add-batchesB*') || request()->is('qrCode*') || request()->is('import-batchIng*') || request()->is('batchesB*') || request()->is('batches*') || request()->is('orderbatch*') ? 'active' : '' }}">
                            <a href="#" class='sidebar-link {{ request()->is(' qrCode*') ||
                                request()->is('import-batchIng*') ||
                                request()->is(' batchesB*') ||
                                request()->is('batches*') ||
                                request()->is('orderbatch*') ||
                                request()->is('add-batchesB*') ||
                                request()->is('add-batches*') ||
                                request()->is('edit-batches*') ||
                                request()->is('add-orderbatchs*') ||
                                request()->is('edit-orderbatchs*')
                                ? 'active'
                                : '' }}' onclick="toggleActive(this)">
                                <i class="fa-sharp-duotone fa-thin fa-industry-windows text-white"></i>
                                <span>Nhà Máy</span>
                            </a>
                            <ul class="submenu {{ Route::is('batchesB.index') ||
                                Route::is('add-batchesB') || Route::is('edit-batchesB') ||
                                Route::is('batches.index') || Route::is('add-batches') ||
                                Route::is('edit-batches') || Route::is('orderbatchs.index') ||
                                Route::is('add-orderbatchs') || Route::is('edit-orderbatchs') ||
                                Route::is('index_qr.index') || Route::is('importBatchIng.index')
                                ? ' active' : '' }}">

                                @hasanyrole('Nhà Máy XNCB|Admin|Quản Lý Mã Lô|Danh Sách Mã Lô')
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('batchesB.index') ? ' active' : '' }}">
                                    <i class="fa-solid fa-octagon-plus text-white"></i>
                                    <a href="{{ route('batchesB.index') }}">Tạo Mã Lô Hàng</a>
                                </li>
                                @endhasanyrole

                                @hasanyrole('Nhà Máy XNCB|Admin|Danh Sách Nhà Máy XNCB|Kết Nối TTNL|Danh Sách TTNL')
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('batches.index') ? ' active' : '' }}">
                                    <i class="bi bi-list-check text-white"></i>
                                    <a href="{{ route('batches.index') }}">Danh Sách Lô Hàng</a>
                                </li>
                                @endhasanyrole
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('importBatchIng.index') ? ' active' : '' }}">
                                    <i class="fa-regular fa-cloud-arrow-down text-white"></i>
                                    <a href="{{ route('importBatchIng.index') }}">Nhập Excel KNTTNL</a>
                                </li>
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('index_qr.index') ? ' active' : '' }}">
                                    <i class="fa-regular fa-download text-white"></i>
                                    <a href="{{ route('index_qr.index') }}">Tải Mã Lô</a>
                                    {{-- <a href="{{ route('index_qr.index') }}">Nhập Nguyên Liệu (Excel)</a> --}}
                                </li>
                                @hasanyrole('Nhà Máy XNCB|Admin|Quản Lý Lệnh Xuất Hàng|Danh Sách Lệnh Xuất Hàng')
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('orderbatchs.index') ? ' active' : '' }}">
                                    <i class="bi bi-file-earmark-binary text-white"></i>
                                    <a href="{{ route('orderbatchs.index') }}">Mã Lệnh Xuất Hàng</a>
                                </li>
                                @endhasanyrole
                            </ul>
                        </li>
                        @endhasanyrole

                        {{-- Quản Lý Chất LƯợng --}}
                        @hasanyrole('Quản Lý Chất Lượng|Admin|Danh Sách Quản Lý Chất Lượng')
                        <li
                            class="sidebar-item  has-sub {{ Route::is('testing.*') || Route::is('untested') || Route::is('showun') || Route::is('import.*') ? ' active' : '' }}">
                            <a href="#" class='sidebar-link {{ Route::is(' testing.*') || Route::is('untested')
                                ? ' active' : '' }}' onclick="toggleActive(this)">
                                <i class="fa-brands fa-bandcamp"></i>
                                <span>Quản Lý Chất Lượng</span>
                            </a>
                            <ul
                                class="submenu {{ (Route::is('testing.*') && !Route::is('testing.show')) || Route::is('untested') || Route::is('import.*') || Route::is('showun') ? ' active' : '' }}">
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('testing.*') ? ' active' : '' }}">
                                    <i class="bi bi-bookmark-check text-white"></i>
                                    <a href="{{ route('testing.index') }}">Lô Đã Kiểm Nghiệm</a>
                                </li>
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('untested') || Route::is('showun') ? ' active' : '' }}">
                                    <i class="bi bi-bookmark-x text-white"></i>
                                    <a href="/untested">Lô Chưa Kiểm Nghiệm</a>
                                </li>
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('import.*') ? ' active' : '' }}">
                                    <i class="fa fa-file-text text-white"></i>
                                    <a href="{{ route('import.files') }}">File</a>
                                </li>
                            </ul>
                        </li>
                        @endhasanyrole

                        {{-- Quản Lý Hợp đồng --}}
                        @hasanyrole('Admin|Danh Sách Hợp Đồng|Quản Lý Hợp Đồng|Quản Lý Loại Hợp Đồng
                        |Danh Sách Loại Hợp Đồng|Quản Lý Khách Hàng|Danh Sách Khách Hàng')
                        <li class="sidebar-item  has-sub {{ Route::is('contract-types.*') ||
    Route::is('customers.*') ||
    Route::is('contracts.*') ||
    Route::is('contract-files.*') ||
    Route::is('edit.index') ||
    Route::is('create-file.index') ||
    Route::is('cont') ||
    Route::is('duedilistate.index')
    ? ' active'
    : '' }}">
                            <a href="#" class='sidebar-link {{ Route::is(' contract-types.*') ||
                                Route::is('customers.*') || Route::is('contract-files.*') || Route::is('edit.index') ||
                                Route::is('create-file.index') || Route::is('contracts.*') || Route::is('cont') ||
                                Route::is('duedilistate.index')
                                ? "
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        active"
                                : '' }}' onclick="toggleActive(this)">
                                <i class="bi bi-file-earmark-medical-fill text-white"></i>
                                <span>Hợp Đồng</span>
                            </a>
                            <ul class="submenu {{ Route::is('contract-types.*') ||
    Route::is('customers.*') ||
    Route::is('contracts.*') ||
    Route::is('contract-files.*') ||
    Route::is('edit.index') ||
    Route::is('create-file.index') ||
    Route::is('cont') ||
    Route::is('duedilistate.index')
    ? ' active'
    : '' }}">
                                @hasanyrole('Admin|Quản Lý Loại Hợp Đồng|Danh Sách Loại Hợp Đồng')
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('contract-types.*') ? ' active' : '' }}">
                                    <i class="fa-solid fa-copy text-white"></i>
                                    <a href="{{ route('contract-types.index') }}">Loại Hợp Đồng</a>
                                </li>
                                @endhasanyrole

                                @hasanyrole('Admin|Quản Lý Khách Hàng|Danh Sách Khách Hàng')
                                <li
                                    class="submenu-item d-flex  align-items-center ms-3 {{ Route::is('customers.*') ? ' active' : '' }}">
                                    <i class="bi bi-people text-white"></i>
                                    <a href="{{ route('customers.index') }}">Khách Hàng</a>
                                </li>
                                @endhasanyrole

                                @hasanyrole('Admin|Quản Lý Hợp Đồng|Danh Sách Hợp Đồng')
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('contracts.*') || Route::is('cont') ? ' active' : '' }}">
                                    <i class="bi bi-list-check text-white"></i>
                                    <a href="{{ route('cont') }}">Danh Sách Hợp Đồng</a>
                                </li>
                                @endhasanyrole

                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('contract-files.*') ? ' active' : '' }}">
                                    <i class="bi bi-file-earmark-binary text-white"></i>
                                    <a href="{{ route('contract-files.index') }}">Mã Lệnh
                                    </a>
                                </li>
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('duedilistate.index') ? ' active' : '' }}">
                                    <i class="bi bi-file-earmark-binary text-white"></i>
                                    <a href="{{ route('duedilistate.index') }}">Due Diligence Statement</a>
                                </li>
                            </ul>
                        </li>
                        @endhasanyrole

                        {{-- Quản Lý Thông tin khác --}}
                        @hasanyrole('Admin|Danh Sách Thông Tin Khác|Quản Lý Chứng Chỉ|Danh Sách Chứng Chỉ')
                        <li
                            class="sidebar-item  has-sub {{ Route::is('certi.*') || Route::is('report.index') ? ' active' : '' }}">
                            <a href="#" class='sidebar-link {{ Route::is(' certi.*') }}' onclick="toggleActive(this)">
                                <i class="fa-thin fa-square-info"></i>
                                <span>Thông Tin Khác</span>
                            </a>
                            <ul
                                class="submenu {{ Route::is('certi.*') || Route::is('report.index') ? ' active' : '' }}">
                                @hasanyrole('Admin|Danh Sách Thông Tin Khác|Quản Lý Chứng Chỉ|Danh Sách Chứng Chỉ')
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('certi.*') ? ' active' : '' }}">
                                    <i class="bi bi-book text-white"></i>
                                    <a href="{{ route('certi.index') }}">Chứng Chỉ</a>
                                </li>
                                @endhasanyrole
                                <li
                                    class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('report.index') ? ' active' : '' }}">
                                    <i class="fa fa-pie-chart text-white"></i>
                                    <a href="{{ route('report.index') }}">Báo Cáo</a>
                                </li>
                            </ul>
                        </li>
                        @endhasanyrole
                        {{-- <li class="sidebar-item  has-sub {{Route::is('certificates.index') ? " active" : "" }}">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Thông tin khác</span>
                            </a>
                            <ul class="submenu {{Route::is('certificates.*') ? " active" : "" }}">
                                <li class="submenu-item {{Route::is('certificates.*') ? " active" : "" }} ">
                                    <a href=" {{route('certificates.index')}}">Chứng chỉ</a>
                                </li>
                            </ul>
                        </li> --}}

                        {{-- Quản Lý Tài Khoản --}}
                        @hasanyrole('Admin|Quản Lý Tài Khoản')
                        <li
                            class="sidebar-item has-sub {{ request()->is('edit-users*') || request()->is('edit-permissions*') || request()->is('edit-roles*') || request()->is('give-permission*') || request()->is('all-permissions*') || request()->is('all-roles*') || request()->is('all-users*') ? 'active' : '' }}">
                            {{-- <a href="/account" class='sidebar-link '> --}}
                                <a href="#" class='sidebar-link {{ request()->is(' give-permission*') || request()->is('
                                    all-permissions*') ||
                                    request()->is('all-roles*') ||
                                    request()->is('all-users*') ||
                                    request()->is('edit-roles*') ||
                                    request()->is('edit-permissions*') ||
                                    request()->is('edit-users*')
                                    ? 'active'
                                    : '' }}' onclick="toggleActive(this)">
                                    <i class="fa-solid fa-user"></i>
                                    <span>Thông Tin Tài Khoản</span>
                                </a>
                                <ul class="submenu {{ Route::is('all.permissions') ||
    Route::is('show.permissions') ||
    Route::is('all.roles') ||
    Route::is('show.roles') ||
    Route::is('all.users') ||
    Route::is('show.users') ||
    Route::is('addPermissionToRole')
    ? ' active' : '' }}">
                                    <li
                                        class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('all.roles') ? ' active' : '' }}">
                                        <i class="bi bi-grid-fill text-white"></i>
                                        <a href=" {{ route('all.roles') }}">Vai Trò</a>
                                    </li>
                                    <li
                                        class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('all.permissions') ? ' active' : '' }}">
                                        <i class="bi bi-grid-fill text-white"></i>
                                        <a href=" {{ route('all.permissions') }}">Quyền</a>
                                    </li>
                                    <li
                                        class="submenu-item d-flex d-flex  align-items-center ms-3 {{ Route::is('all.users') ? ' active' : '' }}">
                                        <i class="fa-solid fa-octagon-plus text-white"></i>
                                        <a href=" {{ route('all.users') }}">Tài Khoản</a>
                                    </li>
                                </ul>
                        </li>
                        @endhasanyrole
                        @hasanyrole('Admin|Cấu Hình Trang Chủ|Cấu Hình Đăng Nhập|Cấu Hình Map')
                        <li class="sidebar-item">
                            <a href="{{ route('setting.index') }}" class='sidebar-link' onclick="toggleActive(this)">
                                <i class="fa-solid fa-gear"></i>
                                <span>Cài đặt</span>
                            </a>
                        </li>
                        @endhasanyrole
                    </ul>
                </div>

                <style>
                    .sidebar-item.has-sub .submenu {
                        display: none;
                    }

                    .sidebar-item.has-sub.active .submenu {
                        display: block !important;
                    }

                    .submenu-item.active {

                        color: #000000;
                        font-weight: bold;
                    }

                    .submenu-item.active i {
                        color: #000000;
                    }

                    #sidebar .sidebar-wrapper .menu .sidebar-link {
                        color: #ffffff;
                        border-radius: 0;
                        padding: 1rem 2rem;
                    }

                    #sidebar .sidebar-wrapper .menu .sidebar-link i,
                    .sidebar-wrapper .menu .sidebar-link svg {
                        color: #ffffff;
                    }

                    #sidebar .sidebar-wrapper .menu {
                        padding: 1rem 0;
                    }

                    #sidebar .sidebar-wrapper .menu .sidebar-item.active .sidebar-link {
                        background-color: transparent;
                    }

                    #sidebar .sidebar-wrapper .menu .sidebar-item.has-sub .sidebar-link:after {

                        content: "\f107";
                        font-weight: 600;
                        font-family: "Font Awesome 6 Pro";
                    }

                    #sidebar .sidebar-wrapper .menu .sidebar-title {
                        padding: 0 1rem;
                        margin: 0;
                        color: #fff;
                    }

                    #sidebar .sidebar-wrapper .menu .submenu .submenu-item a {
                        color: #fff;
                        padding: 0.7rem 10px;
                        font-size: 13px;
                    }

                    #main {
                        /* background: rgb(25 135 84); */
                        /* background: #fff; */
                        background: linear-gradient(to top, #a2d18ab8, #d4f6c3b8, #d4f6c3b8);
                    }

                    #sidebar .sidebar-wrapper .menu .sidebar-link {
                        padding: 0.5rem 2rem;
                    }

                    .sidebar-wrapper {
                        width: 260px;
                    }

                    #main,
                    #main2 {
                        margin-left: 260px;
                        /* padding: 10px; */


                    }

                    @media screen and (max-width: 1199px) {

                        #main,
                        #main2 {
                            margin-left: 0;
                        }
                    }

                    ul.submenu {
                        background: #292c28;
                    }

                    #sidebar .sidebar-wrapper .menu .submenu .submenu-item.active>a {
                        color: #8aff2a;
                        font-weight: 700;
                    }

                    .sidebar-wrapper .menu .sidebar-link {

                        font-size: 14px;

                    }

                    .sidebar-header.position-relative {
                        /* background: #fff; */
                        padding: 1rem;
                    }

                    .sidebar-link::after {
                        transition: transform 0.3s ease;
                        display: inline-block;
                        transform: rotate(0deg);
                    }

                    .sidebar-item.has-sub.active>.sidebar-link::after {
                        transform: translateY(-10%) rotate(180deg);
                    }
                </style>
                <button class="sidebar-toggler BtnOut x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <div class="page-content">
                {{-- <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last ">
                            <h5 class="text-dark">Xin chào, {{ Auth::user()->name }}</h5>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item text-dark">Hoa Binh Rubber Joint stock Company</li>
                                </ol>
                            </nav>

                        </div>
                    </div>
                </div> --}}
                <div class="page-title">
                    <div class="row align-items-center">
                        <a href="#" class="burger-btn d-block d-xl-none" style="margin-left: 0%">
                            <i class="bi bi-justify fs-3 text-dark"></i>
                        </a>
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <div class="dropdown-custom">
                                <h5 class="text-dark d-inline me-2">Xin chào,
                                    <button class="btn btn-sm p-0 border-0 dropdown-toggle-custom" type="button"
                                        id="userDropdownButton" onclick="toggleDropdown()">
                                        <img src="/imgs/lohogo_xl.png" alt="Avatar" class="avatar-img">
                                    </button> {{ Auth::user()->name }}
                                </h5>

                                <ul class="dropdown-menu-custom" id="userDropdownMenu">
                                    <li>
                                        <a>Thông Tin</a>
                                    </li>
                                    <li>
                                        <form id="logout-form" action="/logout" method="POST">
                                            @csrf
                                            <button type="submit">
                                                <div class="sign">
                                                    Đăng Xuất
                                                </div>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item text-dark">Quản Lý Dữ Liệu</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" id="main2">
            @yield('content')

        </div>
    </div>


    <script src="/mazer-1.0.0/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/mazer-1.0.0/dist/assets/js/bootstrap.bundle.min.js"></script>

    <script src="/mazer-1.0.0/dist/assets/vendors/apexcharts/apexcharts.js"></script>
    <script src="/mazer-1.0.0/dist/assets/js/pages/dashboard.js"></script>

    <script src="/mazer-1.0.0/dist/assets/js/main.js"></script>
    <script src="/js/certificate.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    {{-- DataTable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>

    {{-- DataTable Buttons --}}
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.2.3/js/buttons.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.dataTables.css">
</body>


<script>
    function toggleActive(element) {
        element.classList.toggle("active");
    }

    // document.addEventListener("click", function(event) {
    //     const sidebar = document.getElementById("sidebar"); // Sidebar chính
    //     const menuItems = sidebar.querySelectorAll('.sidebar-link'); // Tất cả menu items
    //     if (!sidebar.contains(event.target)) {
    //         menuItems.forEach(function(item) {
    //             item.classList.remove("active");
    //         });
    //     }
    // });

    // document.querySelectorAll('.sidebar-link').forEach(function(item) {
    //     item.addEventListener('click', function(e) {
    //         e.stopPropagation();
    //         toggleActive(this);
    //     });
    // });
</script>
<style>
    .dt-orderable-none .dt-column-order {
        display: none !important;
    }
</style>
<style>
    .sidebar-item .submenu {
        display: none;
    }

    .sidebar-item.active .submenu {
        display: block;
    }

    .sidebar-item.active .sidebar-link {
        background-color: #f0f0f0;
        color: #000;
    }

    .BtnOut {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 45px;
        height: 45px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition-duration: .3s;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
        background-color: #dc1225;
    }

    .sign {
        width: 100%;
        transition-duration: .3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sign svg {
        width: 17px;
    }

    .sign svg path {
        fill: white;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #dce7f1;
        border-radius: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 37px;
    }

    .swal-footer {
        text-align: center !important;
    }
</style>
<style>
    .datepicker-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .calendar-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #555;
    }

    .calendar-icon:hover {
        color: #000;
    }

    .page-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
<style>
    .avatar-img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #22573E;
        transition: 0.3s;
    }

    .dropdown-custom {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle-custom {
        background: none;
        border: none;
        cursor: pointer;
        outline: none;
    }

    .dropdown-menu-custom {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        min-width: 120px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .dropdown-menu-custom.show {
        display: block;
    }

    .dropdown-menu-custom li {
        padding: 8px 12px;
    }

    .choose-file-btn {
        background-color: #E6EDF7;
        border-color: #E6EDF7;
        color: #7E8B91;
    }

    .file-name {
        background-color: white !important;
        cursor: pointer;
    }
</style>
{{-- Responsive datatable --}}
<style>
    table.dataTable td,
    table.dataTable th {
        white-space: normal !important;
        word-wrap: break-word;

    }

    table.dataTable.dtr-column>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-column>tbody>tr>th.dtr-control:before,
    table.dataTable.dtr-column>tbody>tr>td.control:before,
    table.dataTable.dtr-column>tbody>tr>th.control:before {
        box-sizing: border-box !important;
        content: "+" !important;
        background-color: #31b131 !important;
        border-radius: 50% !important;
        color: white !important;
        display: inline-block !important;
        text-align: center !important;
        width: 22px !important;
        border: .1em solid white !important;
        box-shadow: 0 0 .2em #444 !important;
        font-size: 13px !important;
    }


    table.dataTable.dtr-column>tbody>tr.dtr-expanded td.dtr-control:before,
    table.dataTable.dtr-column>tbody>tr.dtr-expanded th.dtr-control:before,
    table.dataTable.dtr-column>tbody>tr.dtr-expanded td.control:before,
    table.dataTable.dtr-column>tbody>tr.dtr-expanded th.control:before {
        content: "-" !important;
        background-color: #d33333 !important;
        box-sizing: border-box !important;
        border-radius: 50% !important;
        color: white !important;
        display: inline-block !important;
        text-align: center !important;
        width: 22px !important;
        border: .1em solid white !important;
        box-shadow: 0 0 .2em #444 !important;
        font-size: 13px !important;
    }
</style>

{{-- button-container --}}
<style>
    #buttons-container {
        visibility: hidden;
    }
</style>
{{-- custom input type file --}}
<style>
    .choose-file-btn {
        background-color: #E6EDF7;
        border-color: #E6EDF7;
        color: #7E8B91;
    }

    .file-name {
        background-color: white !important;
        cursor: pointer;
    }
</style>

@if (Session::has('message'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    swal("Thông báo", "{{ Session::get('message') }}", 'success', {
            button: true,
            button: "OK",
            timer: 3000,
            dangerMode: true,
        });
</script>
@php
Session::put('message', null);
@endphp
@elseif(Session::has('error'))
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    swal("Thông báo", "{{ Session::get('error') }}", 'error', {
            button: true,
            button: "OK",
            timer: 15000,
            dangerMode: true,
        });
</script>
@php
Session::put('error', null);
@endphp
@endif

<script>
    $(window).on('load', function () {
        $('.loading-wrapper').fadeOut('slow');
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebarLinks = document.querySelectorAll(".sidebar-item.has-sub > .sidebar-link");

        sidebarLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                const parentItem = this.parentElement;
                const isCurrentlyActive = parentItem.classList.contains('active');

                // Đóng tất cả submenu khác trước khi mở submenu đang click
                sidebarLinks.forEach(otherLink => {
                    if (otherLink.parentElement !== parentItem) {
                        otherLink.parentElement.classList.remove("active");
                    }
                });

                // Toggle submenu hiện tại
                if (isCurrentlyActive) {
                    parentItem.classList.remove("active");
                } else {
                    parentItem.classList.add("active");
                }
            });
        });
    });
</script>


<script>
    const menu = document.querySelector("#sidebar");
    const icon = document.querySelector(".burger-btn");
    const wrapper = document.querySelector(".sidebar-wrapper");

    icon.addEventListener("click", (e) => {
        e.stopPropagation();
        menu.classList.add("active");
    });

    document.addEventListener("click", (e) => {
        if (!wrapper.contains(e.target) && menu.classList.contains("active") && window.innerWidth < 1200) {
            menu.classList.remove("active");
        }
    });
</script>
{{--
<script>
    // Định nghĩa ngôn ngữ tiếng Việt cho Datepicker
    $.datepicker.regional['vi'] = {
        closeText: 'Đóng',
        prevText: 'Trước',
        nextText: 'Sau',
        currentText: 'Hôm nay',
        monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
            'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        ],
        monthNamesShort: ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6',
            'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'
        ],
        dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
        dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        weekHeader: 'Tuần',
        dateFormat: 'dd/mm/yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['vi']); // Áp dụng mặc định tiếng Việt

    $(document).ready(function () {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "c-100:c+10",
            showButtonPanel: true,
            closeText: "Đóng",
            beforeShow: function (input, inst) {
                setTimeout(function () {
                    $(inst.dpDiv).find(".ui-datepicker-current").hide(); // Ẩn nút "Hôm nay"
                }, 1);
            }
        });
        $(".datepicker").on("keydown", function (e) {
            if (e.key === "Backspace" || e.key === "Delete") {
                $(this).val(""); // Xóa ngày
            }
            e.preventDefault();
        });
        // Khi click vào icon lịch thì mở Datepicker
        $(".calendar-icon").on("click", function () {
            $(this).prev(".datepicker").focus();
        });
    });
</script> --}}

<script>
    function initDateTimePicker(selector) {
        const input = document.querySelector(selector);
        console.log("Selector:", selector); // Kiểm tra giá trị trước khi truyền vào
        if (!input) return; // Kiểm tra nếu không tìm thấy input

        const wrapper = input.closest(".datepicker-wrapper"); // Tìm div bọc input
        const icon = wrapper?.querySelector(".calendar-icon"); // Tìm icon trong wrapper

        // Khởi tạo DateTimePicker
        const picker = new tempusDominus.TempusDominus(input, {
            localization: {
                format: "dd/MM/yyyy", // Hiển thị ngày/tháng/năm
                locale: "vi",
                dayViewHeaderFormat: {
                    month: '2-digit',
                    year: 'numeric'
                }
            },
            display: {
                viewMode: "calendar",
                components: {
                    clock: false,
                    date: true,
                    month: true,
                    year: true
                }
            }
        });

        // Khi click vào icon -> Mở DatePicker
        if (icon) {
            icon.addEventListener("click", function (event) {
                event.stopPropagation(); // Ngăn sự kiện lan ra ngoài
                if (picker.display.isVisible) {
                    picker.hide();
                } else {
                    picker.show();
                }
            });
        }
    }
    document.addEventListener("DOMContentLoaded", function () {
        // // Khởi tạo DatePicker cho tất cả input có class .datetimepicker
        document.querySelectorAll(".datetimepicker").forEach((element) => {
            initDateTimePicker(`#${element.id}`);
        });
    });
    document.querySelectorAll(".datetimepicker").forEach(function (input) {
        input.addEventListener("keydown", function (event) {
            if (event.key === "Backspace" || event.key === "Delete") {
                this.value = "";
                this.dispatchEvent(new Event("change"));
            }
        });
    });
</script>
@if (session('toast_error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
            Toast.fire({
                icon: 'error',
                title: '{{ session('toast_error') }}'
            });
            // Hoặc dùng SweetAlert2:
            // Swal.fire('Lỗi', '{{ session('toast_error') }}', 'error');
        });
</script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Khởi tạo Tempus Dominus với hỗ trợ mobile tốt hơn
        const id = document.getElementById("delivery_month");
        if (!id) return;
        const picker = new tempusDominus.TempusDominus(id, {
            localization: {
                format: 'MM/yyyy',
                locale: 'vi',

            },
            display: {
                viewMode: 'months', // Chỉ hiển thị tháng
                components: {
                    clock: false, // Ẩn giờ phút
                    date: false, // Ẩn ngày, chỉ chọn tháng
                    month: true, // Hiển thị tháng
                    year: true // Hiển thị năm
                }
            }
        });
        const icon = document.querySelector(".calendar-icon");

        if (icon) {
            icon.addEventListener("click", function (event) {
                event.stopPropagation(); // Ngăn sự kiện lan ra ngoài
                if (picker.display.isVisible) {
                    picker.hide();
                } else {
                    picker.show();
                }
            });
        }
        document.getElementById("delivery_month").addEventListener("keydown", function (event) {
            if (event.key === "Backspace" || event.key === "Delete") {
                this.value = "";
                this.dispatchEvent(new Event("change"));
            }
        });
    });
</script>
{{-- custom input type file --}}
<script>
    // Lấy tất cả các phần tử theo class
    let fileInputs = document.querySelectorAll(".import_excel");
    let fileNameInputs = document.querySelectorAll(".file-name");
    let chooseFileBtns = document.querySelectorAll(".choose-file-btn");

    // Cập nhật tên file vào ô text sau khi người dùng chọn tệp
    fileInputs.forEach((fileInput, index) => {
        fileInput.addEventListener("change", function () {
            let fileName = this.files.length > 0 ? this.files[0].name : "Không có tệp nào được chọn";
            fileNameInputs[index].value = fileName;
        });
    });

    // Khi click vào ô text, sẽ tự động kích hoạt input file
    fileNameInputs.forEach((fileNameInput, index) => {
        fileNameInput.addEventListener("click", function () {
            fileInputs[index].click();
        });
    });

    // Khi click vào label "Chọn tệp", kích hoạt input file
    chooseFileBtns.forEach((chooseFileBtn, index) => {
        chooseFileBtn.addEventListener("click", function () {
            fileInputs[index].click();
        });
    });
</script>
<!-- Tải ngôn ngữ tiếng Việt của Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/vi.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const dropdownButton = document.getElementById('userDropdownButton');
    const dropdownMenu = document.getElementById('userDropdownMenu');

    // Toggle dropdown khi click vào nút
    dropdownButton.addEventListener('click', function (event) {
        event.stopPropagation(); // Ngăn sự kiện click lan ra ngoài
        dropdownMenu.classList.toggle('show');
    });

    // Ẩn dropdown khi click ra ngoài
    document.addEventListener('click', function (event) {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});
</script>

</html>