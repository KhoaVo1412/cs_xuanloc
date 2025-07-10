<?php

namespace App\Http\Controllers\Import;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use Illuminate\Http\Request;
use App\Imports\UpdatePlaningAreaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Units;
use Illuminate\Support\Facades\File;
class UpdatePlantingAreaImportController extends Controller
{

    public function importExcel(Request $request)
    {

        if (session()->has('temp_uploaded_pdfs_edit')) {
            $tempFiles = session()->get('temp_uploaded_pdfs_edit');

            foreach ($tempFiles as $filename) {
                $path = public_path('tmp_pdfs_edit/' . $filename);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            session()->forget('temp_uploaded_pdfs_edit'); // clear luôn session
        }


        try {
            $import = new UpdatePlaningAreaImport();

            Excel::import($import, $request->file("excel_file"));
            $datas = $import->getData();
            $hasPdf = collect($datas)->contains(function ($row) {
                return !empty($row['tap_tin_pdf']);
            });

            if (!empty($import::$errors)) {
                $errors = $import::$errors;
                // dd($errors);
                $errorMessages = [];
                // foreach ($errors as $error) {
                $unknownErrors = array_column($errors, 'Error');
                // dd($errors);
                if (!empty($unknownErrors)) {
                    $errorMessages[] = implode(", ", $unknownErrors);
                } else {
                    $emptyCty = $errors['empty_cty'] ?? [];
                    if (!empty($emptyCty)) {
                        $errorMessages[] = "Cột Cong_ty không được để trống tại các dòng: " . implode(', ', $emptyCty);
                    }
                    $unitsInvalid = $errors['units_invalid'] ?? [];
                    if (!empty($unitsInvalid)) {
                        $errorMessages[] = "Cột Cong_ty không hợp lệ tại các dòng: " . implode(', ', $unitsInvalid);
                    }
                    $plantationError = $errors['plantation_invalid'] ?? [];
                    if (!empty($plantationError)) {
                        $errorMessages[] = "Cột Plantation không hợp lệ tại các dòng: " . implode(', ', $plantationError);
                    }
                    // dd($$plantationError);
                    $emptyplareaError = $errors['empty_plantation'] ?? [];

                    if (!empty($emptyplareaError)) {
                        $errorMessages[] = "Cột Plantation không được để trống tại các dòng: " . implode(', ', $emptyplareaError);
                    }
                    $findError = $errors['find'] ?? [];

                    if (!empty($findError)) {
                        $errorMessages[] = "Cột Find không được để trống tại các dòng: " . implode(', ', $findError);
                    }
                    $geojsonError = $errors['geojson'] ?? [];
                    // dd($geojsonError);
                    if (!empty($geojsonError)) {
                        $errorMessages[] = "Cột Geo.json không được để trống tại các dòng: " . implode(', ', $geojsonError);
                    }


                    $invaildpy1Error = $errors['invalid_planting_year'] ?? [];
                    if (!empty($invaildpy1Error)) {
                        $errorMessages[] = "Cột Planting_y không được lớn hơn năm hiện tại tại các dòng: " . implode(', ', $invaildpy1Error);
                    }

                    $emptypyError = $errors['empty_planting_year'] ?? [];
                    // dd($emptypyError);
                    if (!empty($emptypyError)) {
                        $errorMessages[] = "Cột Planting_y không được để trống tại các dòng: " . implode(', ', $emptypyError);
                    }

                    $invaildpyError = $errors['planting_year'] ?? [];
                    if (!empty($invaildpyError)) {
                        $errorMessages[] = "Cột Planting_y không hợp lệ tại các dòng: " . implode(', ', $invaildpyError);
                    }

                    $exitFindPlant = $errors['exit_find_plant'] ?? [];
                    if (!empty($exitFindPlant)) {
                        $errorMessages[] = "Cột Find và Plantation bị trùng tại các dòng " . implode(', ', $exitFindPlant);
                    }


                    $notFoundPlantingAreaError = $errors['not_found_plating_area'] ?? [];
                    if (!empty($notFoundPlantingAreaError)) {
                        $errorMessages[] = "Không tìm thấy Khu Vực Trồng tại các dòng: " . implode(', ', $notFoundPlantingAreaError);
                    }
                    $invailuserError = $errors['farm_and_unit_not_allowed'] ?? [];
                    if (!empty($invailuserError)) {
                        $errorMessages[] = "Cột Cong_ty và Plantation không hợp lệ tại các dòng: " . implode(', ', $invailuserError);
                    }

                    $duplicatepdfError = $errors['duplicate_pdf'] ?? [];
                    if (!empty($duplicatepdfError)) {
                        $errorMessages[] = "Cột Tap_tin (Pdf) bị trùng tại các dòng: " . implode(', ', $duplicatepdfError);
                    }
                }

                // dd(implode("<br>", $errorMessages));

                return redirect()->route('edit-excel')->with('error', 'File excel không hợp lệ:\n' . implode('\n', $errorMessages));
            } else if (!$hasPdf) {
                $import->savePlantingArea($datas); // bạn đã có hàm này rồi

                return redirect()->route('plantingareas.index')->with("message", "Tạo khu vực thành công!");
            } else {
                // ✅ Không có lỗi → Preview dữ liệu
                $data = $import->getImportedData();
                // $farms = implode(', ', Farm::pluck('farm_name')->toArray());

                foreach ($data as &$row) {
                    $find = $row['find'] ?? '';
                    $plantation = $row['plantation'] ?? '';
                    $nam_trong = $row['planting_y'] ?? '';
                    $cty = $row['cong_ty'] ?? '';

                    // Chuyển NT thành NONG TRUONG
                    if (str_starts_with($plantation, 'NT')) {
                        $plantation = str_replace('NT', 'NONG TRUONG', $plantation);
                    }

                    $unit = Units::where('unit_name', $cty)->first();
                    $farm = Farm::where('farm_name', $plantation)->where('unit_id', $unit?->id)->first();

                    if ($unit && $farm) {
                        $farmShort = app(UpdatePlaningAreaImport::class)->shortenFarmName($farm->farm_name);
                        $unitShort = app(UpdatePlaningAreaImport::class)->shortenFactoryName($unit->unit_name);
                        $maLo = "{$nam_trong}.{$farmShort}-{$unitShort}.{$find}";
                    } else {
                        $maLo = 'Không xác định';
                    }

                    // Thêm ma_lo vào mảng
                    $row['ma_lo'] = $maLo;
                }

                // return view('planting_areas.add_excel', compact('data'));
                return redirect()->route('edit-excel')->with('preview_data_edit', $data);

            }

            // return redirect()->route('plantingareas.index')->with("message", "Tạo khu vực thành công!");

        } catch (\Exception $e) {
            return redirect()->route('plantingareas.index')->with('error', 'Lỗi khi nhập dữ liệu: ' . $e->getMessage());
        }
    }
    public function edit_excel()
    {
        // $farms = implode(', ', Farm::pluck('farm_name')->toArray());
        // dd($farms);
        $data = session('preview_data_edit', []);

        // Nếu không có dữ liệu preview => dọn toàn bộ thư mục tmp_pdfs
        if (empty($data)) {
            $tmpPath = public_path('tmp_pdfs_edit');
            if (File::exists($tmpPath)) {
                File::cleanDirectory($tmpPath); // Xóa toàn bộ file PDF tạm
            }
            session()->forget('temp_uploaded_pdfs_edit');
        }
        return view('planting_areas.edit_excel', compact('data'));
    }

    public function saveData(Request $request)
    {
        $data = unserialize(base64_decode($request->input('data')));
        $uploadedPdfs = $request->input('uploaded_pdfs', []);

        foreach ($data as &$row) {
            $pdfName = $row['tap_tin_pdf'] ?? null;

            if ($pdfName && isset($uploadedPdfs[$pdfName])) {
                $storedName = $uploadedPdfs[$pdfName]; // vd: MALO_abc123.pdf
                $maLo = explode('_', $storedName)[0];  // Lấy mã lô từ tên file

                $tempPath = public_path('tmp_pdfs_edit/' . $storedName);
                $finalPath = public_path('uploads/pdf/' . $storedName);

                // ✅ XÓA FILE CŨ nếu có
                $existingFiles = File::glob(public_path("uploads/pdf/{$maLo}_*.pdf"));
                foreach ($existingFiles as $oldFile) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                // ✅ DI CHUYỂN FILE MỚI TỪ tmp → uploads
                if (file_exists($tempPath)) {
                    rename($tempPath, $finalPath);
                }

                $row['stored_pdf'] = $storedName;
            }
        }

        // Gọi hàm lưu dữ liệu chính thức
        $import = new UpdatePlaningAreaImport();
        $import->savePlantingArea($data);
        session()->forget('temp_uploaded_pdfs_edit');

        return redirect()->route('plantingareas.index')->with("message", "Cập nhật khu vực thành công!");
    }

    public function uploadPdf(Request $request)
    {
        $uploaded = [];
        $rejected = [];

        $validNames = collect(json_decode($request->input('valid_names', '[]')))
            ->map(fn($name) => strtolower(pathinfo($name, PATHINFO_FILENAME)))
            ->toArray();

        if ($request->hasFile('pdfs')) {
            $mapPdfMaLo = collect(json_decode($request->input('pdf_ma_lo_map', '{}'), true));

            // ✅ Tạo thư mục nếu chưa tồn tại
            $destinationPath = public_path('tmp_pdfs_edit');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('pdfs') as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fullOriginal = strtolower($originalName);

                if (!in_array($fullOriginal, $validNames)) {
                    $rejected[] = $file->getClientOriginalName();
                    continue;
                }

                $maLo = $mapPdfMaLo[$fullOriginal] ?? 'unknown';
                $newFileName = $maLo . '_' . $originalName . '.' . $extension;

                $file->move($destinationPath, $newFileName);

                $uploaded[] = [
                    'original' => $file->getClientOriginalName(),
                    'stored' => $newFileName,
                ];

                $existing = session()->get('temp_uploaded_pdfs_edit', []);
                $merged = array_merge($existing, collect($uploaded)->pluck('stored')->toArray());
                session()->put('temp_uploaded_pdfs_edit', $merged);
            }

            return response()->json([
                'status' => 'success',
                'uploaded' => $uploaded,
                'rejected' => $rejected,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Không tìm thấy file'
        ]);
    }

}