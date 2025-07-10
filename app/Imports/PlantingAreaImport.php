<?php
namespace App\Imports;

use Illuminate\Support\Facades\Log;
use App\Models\PlantingArea;
use App\Models\Farm;
use App\Models\Units;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class PlantingAreaImport implements ToCollection, WithHeadingRow, SkipsOnFailure, WithEvents
{
    use SkipsFailures;

    public static $errors = [];
    // private $rowNumber = 2;
    // private $rowNumber = 1;
    protected $importedRows = [];
    protected $datas = [];
    public function getImportedData()
    {
        return $this->importedRows;
    }
    public function getData()
    {
        return $this->datas;
    }
    public function collection(Collection $rows)
    {

        try {
            $errors = $this->validateRow($rows);
            // dd($errors);
            if (empty($errors)) {
                $this->importedRows = $rows->toArray();
                $this->datas = $rows->toArray();
            } else {
                self::$errors = array_merge(self::$errors, $errors);
                // dd(self::$errors);
            }

        } catch (\Exception $e) {
            self::$errors[] = [
                'Error' => $e->getMessage(),
            ];
        }
    }

    private function validateRow($rows)
    {

        $errors = [];
        $currentYear = now()->year;
        $rowNumber = 1;
        $exitFindPlant = [];

        // Lấy danh sách các Units trước để tránh truy vấn nhiều lần
        $allUnits = Units::where('status', "Hoạt động")->get()->keyBy('unit_name');
        $user = Auth::user();
        // dd($user->farms);
        $userFarmNames = $user->farms
            ? $user->farms->pluck('farm_name')->map(fn($name) => Str::ascii(mb_strtolower(trim($name))))->toArray()
            : [];

        $userUnitNames = $user->farms
            ? $user->farms->pluck('unitRelation.unit_name')->map(fn($name) => Str::ascii(mb_strtolower(trim($name))))->toArray()
            : [];

        $pdfNamesSeen = [];

        foreach ($rows as $row) {
            $rowNumber++;
            $find = $row['find'] ?? null;
            $plantation = $row['plantation'] ?? null;
            $geo = $row['geojson'] ?? null;
            $nam_trong = $row['planting_y'] ?? null;
            $cty = $row['cong_ty'] ?? null;
            $taptinpdf = $row['tap_tin_pdf'] ?? null;

            if ($taptinpdf) {
                $taptinpdf = trim($taptinpdf);

                if (!Str::endsWith(Str::lower($taptinpdf), '.pdf')) {
                    $taptinpdf .= '.pdf'; // thêm đuôi .pdf
                }

                // Gán lại vào $row nếu bạn còn dùng $row['tap_tin_pdf'] sau này
                $row['tap_tin_pdf'] = $taptinpdf;
                $lowerPdf = Str::lower($taptinpdf);

                if (in_array($lowerPdf, $pdfNamesSeen)) {
                    $errors['duplicate_pdf'][] = $rowNumber;
                } else {
                    $pdfNamesSeen[] = $lowerPdf;
                }
            }

            if (!$find) {
                $errors['find'][] = $rowNumber;
            }

            if (!$geo) {
                $errors['geojson'][] = $rowNumber;
            }

            if (!$nam_trong) {
                $errors['empty_planting_year'][] = $rowNumber;
            } elseif (!filter_var($nam_trong, FILTER_VALIDATE_INT) || strlen($nam_trong) !== 4) {
                $errors['planting_year'][] = $rowNumber;
            } elseif ($nam_trong > $currentYear) {
                $errors['invalid_planting_year'][] = $rowNumber;
            }

            if (!$cty) {
                $errors['empty_cty'][] = $rowNumber;
                continue;
            }

            $units = $allUnits[$cty] ?? null;
            if (!$units) {
                $errors['units_invalid'][] = $rowNumber;
                continue;
            }

            if (!$plantation) {
                $errors['empty_plantation'][] = $rowNumber;
                continue;
            }

            if (str_starts_with($plantation, 'NT')) {
                $plantation = str_replace('NT', 'NONG TRUONG', $plantation);
            }

            // Kiểm tra farm, tối ưu bằng cách lấy danh sách farm trước
            $farm = Farm::where('farm_name', $plantation)
                ->where('unit_id', $units->id)
                ->first();

            if (!$farm) {
                $errors['plantation_invalid'][] = $rowNumber;
                continue;
            }


            $plantationNormalized = Str::ascii(mb_strtolower(trim($plantation)));
            $ctyNormalized = Str::ascii(mb_strtolower(trim($cty)));
            if ($user->farms->isNotEmpty()) {
                if (!in_array($plantationNormalized, $userFarmNames) || !in_array($ctyNormalized, $userUnitNames)) {
                    $errors['farm_and_unit_not_allowed'][] = $rowNumber;
                    continue;
                }
            }

            // Kiểm tra trùng lặp
            $existingArea = PlantingArea::where('find', (string) $find)
                ->where('farm_id', $farm->id)
                ->exists();

            if ($existingArea) {
                $errors['duplicate_find_farm'][] = $rowNumber;
            }

            if ($find && $plantation) {
                $exitFindPlant[] = [
                    "find" => $find,
                    "plantation" => $plantation,
                    "row" => $rowNumber
                ];
            }
        }

        // Kiểm tra trùng lặp trong danh sách
        $duplicateRows = $this->findDuplicateRows($exitFindPlant);
        if (!empty($duplicateRows)) {
            foreach ($duplicateRows as $row) {
                $errors['exit_find_plant'][] = $row;
            }
        }

        return $errors;
    }

    private function findDuplicateRows($data)
    {
        $countFind = [];
        $duplicates = [];

        // Đếm số lần xuất hiện của từng giá trị `find`
        foreach ($data as $item) {
            $findValue = $item['find'];

            if (!isset($countFind[$findValue])) {
                $countFind[$findValue] = [];
            }

            $countFind[$findValue][] = $item; // Lưu lại toàn bộ dòng có `find` này
        }

        // Lọc ra những giá trị `find` bị trùng (xuất hiện > 1 lần)
        foreach ($countFind as $findValue => $rows) {
            // dd($rows);
            if (count($rows) > 1) { // Chỉ lấy các `find` bị trùng
                foreach ($rows as $row) {
                    $duplicates[] = $row['row'];
                }

            }
        }

        return $duplicates; // Trả về danh sách các dòng bị trùng
    }

    public function savePlantingArea($rows)
    {
        foreach ($rows as $row) {
            $find = $row['find'];
            $plantation = $row['plantation'];
            $nam_trong = $row['planting_y'];
            $cty = $row['cong_ty'] ?? null;
            if (str_starts_with($plantation, 'NT')) {
                $plantation = str_replace('NT', 'NONG TRUONG', $plantation);
            }
            $unit = Units::where('unit_name', $cty)->first();
            $farm = Farm::where('farm_name', $plantation)->where('unit_id', $unit->id)->first();
            $plantingArea = PlantingArea::where('farm_id', $farm->id)->first();
            $farmShortName = $this->shortenFarmName($farm->farm_name);
            $factoryShortName = $this->shortenFactoryName($unit->unit_name);
            $maLo = "{$nam_trong}.{$farmShortName}-{$factoryShortName}.{$find}";
            $pdfPathToSave = null;
            if (isset($row['stored_pdf']) && !empty($row['stored_pdf'])) {
                $pdfPathToSave = 'uploads/pdf/' . $row['stored_pdf'];
            } else {
                // Giữ nguyên giá trị pdf hiện tại nếu không có file mới
                $pdfPathToSave = $plantingArea->pdf;
            }
            if ($plantingArea) {
                $plantingArea->updateOrCreate([
                    "fid" => $row["fid"],
                    "idmap" => $row["idmap"],
                    "nha_sx" => $row["producer"],
                    "quoc_gia" => $row["country"],
                    "ma_lo" => $maLo,
                    "farm_id" => $farm->id,
                    "plot" => $row["plot"],
                    "nam_trong" => $nam_trong,
                    "chi_tieu" => $row["clone_spec"],
                    "dien_tich" => $row["area_ha"],
                    "tapping_y" => $row["tapping_y"],
                    "repl_time" => $row["repl_time"],
                    "find" => $find,
                    "webmap" => $row['webmap'],
                    "gwf" => $row["gwf"],
                    "xa" => $row["xa"],
                    "huyen" => $row["huyen"],
                    "nguon_goc_lo" => $row["nguon_goc_lo"],
                    "nguon_goc_dat" => $row["nguon_goc_dat"],
                    "hang_dat" => $row["hang_dat"],
                    "hien_trang" => $row["hien_trang"],
                    "layer" => $row["layer"],
                    "chu_thich" => "chu_thich",
                    "x" => $row["x"],
                    "y" => $row["y"],
                    "geo" => $row["geojson"],
                    "pdf" => $pdfPathToSave,
                ]);
            } else {
                PlantingArea::create([
                    "fid" => $row["fid"],
                    "idmap" => $row["idmap"],
                    "ma_lo" => $maLo,
                    "nha_sx" => $row["producer"],
                    "quoc_gia" => $row["country"],
                    "farm_id" => $farm->id,
                    "plot" => $row["plot"],
                    "nam_trong" => $nam_trong,
                    "chi_tieu" => $row["clone_spec"],
                    "dien_tich" => $row["area_ha"],
                    "tapping_y" => $row["tapping_y"],
                    "repl_time" => $row["repl_time"],
                    "find" => $find,
                    "webmap" => $row['webmap'],
                    "gwf" => $row["gwf"],
                    "xa" => $row["xa"],
                    "huyen" => $row["huyen"],
                    "nguon_goc_lo" => $row["nguon_goc_lo"],
                    "nguon_goc_dat" => $row["nguon_goc_dat"],
                    "hang_dat" => $row["hang_dat"],
                    "hien_trang" => $row["hien_trang"],
                    "layer" => $row["layer"],
                    "chu_thich" => "chu_thich",
                    "x" => $row["x"],
                    "y" => $row["y"],
                    "geo" => $row["geojson"],
                    "pdf" => $pdfPathToSave,
                ]);
            }
        }

    }


    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            self::$errors[] = [
                'Error' => $failure->errors()[0],
            ];
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                self::$errors = []; // Xóa danh sách lỗi trước khi import
            },
            AfterImport::class => function (AfterImport $event) {
                if (!empty(self::$errors)) {
                    Log::error('Import có lỗi:', self::$errors);
                }
            },
        ];
    }

    public function shortenFarmName($farmName)
    {
        // Loại bỏ tiền tố "Nông Trường" hoặc "NT" nếu có
        $farmName = preg_replace('/^(NT|Nông Trường)\s+/i', '', trim($farmName));

        // Chia farm_name thành các từ
        $words = explode(' ', $farmName);

        // Nếu tên bắt đầu bằng "Đội X" (ví dụ: "Đội 3"), thì lấy "D3"
        if (count($words) == 2 && mb_strtolower($words[0]) == "đội" && is_numeric($words[1])) {
            return 'D' . $words[1];
        }

        // Lấy chữ cái đầu của mỗi từ còn lại
        $shortName = '';
        foreach ($words as $word) {
            $shortName .= mb_substr($word, 0, 1);
        }

        return strtoupper($shortName);
    }
    public function shortenFactoryName($factoryName)
    {
        // Loại bỏ các tiền tố phổ biến của công ty
        $factoryName = preg_replace('/\b(Công Ty Cổ Phần Cao Su|Công Ty TNHH|Công Ty)\b\s*/i', '', trim($factoryName));

        // Chia factory_name thành các từ
        $words = explode(' ', $factoryName);

        // Lấy chữ cái đầu của mỗi từ để tạo viết tắt
        $shortName = '';
        foreach ($words as $word) {
            $shortName .= mb_substr($word, 0, 1);
        }

        return strtoupper($shortName);
    }
}