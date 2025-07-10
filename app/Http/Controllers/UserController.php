<?php

namespace App\Http\Controllers;

use App\Models\ActionHistory;
use App\Models\Farm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function all_users(Request $request)
    {
        $farm = Farm::where('status', 'Hoạt động')->get();
        $data = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Khách Hàng');
        });
        $user_email = User::select('email')->get();
        // $roles = Role::where('name', '!=', 'Khách Hàng')->pluck('name', 'name');
        $roles = Role::where('name', '!=', 'Khách Hàng')->pluck('name')->toArray();
        $groupedRoles = [
            'Cấu Hình Hệ Thống' => [
                'Admin',
                'Cấu Hình Đăng Nhập',
                'Cấu Hình Map',
                'Cấu Hình Trang Chủ',
                'Cấu Hình Trang Chủ'
            ],
            'Khách hàng & Thị trường' => [
                'Khách Hàng', // Sẽ bị lọc ra ở bước dưới
                'Thị Trường Kinh Doanh'
            ],
            'Quản Lý Nông Trường' => [
                'Nông Trường',
                'Danh Sách Nông Trường',
                'Tạo Nông Trường',
                'Cập Nhật Nông Trường',
                'Xóa Nông Trường',
            ],
            'Quản Lý Xe' => [
                'Quản Lý Xe',
                'Danh Sách Xe',
                'Tạo Xe',
                'Cập Nhật Xe',
                'Xóa Xe',
            ],
            'Quản Lý Thông Tin Nguyên Liệu' => [
                'Quản Lý Thông Tin Nguyên Liệu',
                'Danh Sách Nguyên Liệu',
                'Tạo Thông Tin Nguyên Liệu',
                'Cập Nhật Thông Tin Nguyên Liệu',
                'Xóa Thông Tin Nguyên Liệu',
            ],
            'Quản Lý Vùng Trồng' => [
                'Quản Lý Khu Vực Trồng',
                'Danh Sách Khu Vực Trồng',
                'Tạo Khu Vực Trồng',
                'Cập Nhật Khu Vực Trồng',
                'Xóa Khu Vực Trồng',
            ],
            'Quản Lý Chất Lượng' => [
                'Quản Lý Chất Lượng',
                'Danh Sách Quản Lý Chất Lượng',
            ],
            'Quản Lý Mã Lô (Nhà Máy XNCB)' => [
                'Quản Lý Mã Lô',
                'Danh Sách Mã Lô',
                'Tạo Mã Lô',
                'Cập Nhật Mã Lô',
                'Xóa Mã Lô',
            ],
            'Quản lý Kết Nối TTNL (Nhà Máy XNCB)' => [
                'Quản Lý Kết Nối TTNL',
                'Danh Sách Kết Nối TTNL',
                'Tạo Kết Nối TTNL',
                'Cập Nhật Kết Nối TTNL',
                'Xóa Kết Nối TTNL',
            ],
            'Quản lý Lệnh Xuất Hàng (Nhà Máy XNCB)' => [
                'Quản Lý Lệnh Xuất Hàng',
                'Danh Sách Lệnh Xuất Hàng',
                'Gắn Mã Lô Vào Lệnh Xuất Hàng',
                'Xóa mã Lệnh Xuất Hàng',
                'Cập Nhật Mã Lệnh Xuất Hàng',
            ],

            'Quản lý Hợp Đồng' => [
                'Quản Lý Hợp Đồng',
                'Danh Sách Hợp Đồng',
                'Tạo Hợp Đồng',
                'Cập Nhật Hợp Đồng',
                'Xóa Hợp Đồng',
            ],
            'Quản lý Loại Hợp Đồng' => [
                'Quản Lý Loại Hợp Đồng',
                'Danh Sách Loại Hợp Đồng',
                'Tạo Loại Hợp Đồng',
                'Cập Nhật Loại Hợp Đồng',
                'Xóa Loại Hợp Đồng',
            ],
            'Quản lý Khách Hàng' => [
                'Quản Lý Khách Hàng',
                'Danh Sách Khách Hàng',
                'Tạo Khách Hàng',
                'Cập Nhật Khách Hàng',
                'Xóa Khách Hàng',
            ],
            'Quản lý Chứng Chỉ' => [
                'Quản Lý Chứng Chỉ',
                'Danh Sách Chứng Chỉ',
                'Tạo Chứng Chỉ',
                'Cập Nhật Chứng Chỉ',
                'Xóa Chứng Chỉ',
            ],
            // 'Khác' => [
            //     'Danh Sách Thông Tin Khác'
            // ]
        ];
        foreach ($groupedRoles as $group => $roleList) {
            $groupedRoles[$group] = array_values(array_filter($roleList, function ($role) use ($roles) {
                return in_array($role, $roles);
            }));
        }
        $groupedRoles = array_filter($groupedRoles);

        if ($request->has('filter_select') && $request->filter_select != null) {
            $data->where('email', $request->filter_select);
        }
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('stt', function ($row) {
                    static $stt = 0;
                    $stt++;
                    return $stt;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->editColumn('password', function ($row) {
                    return $row->password;
                })
                ->editColumn('role', function ($row) {
                    $roles = $row->getRoleNames()->map(function ($rolename) {
                        return '<label class="btn btn-info mx-2 mt-1 mb-1">' . $rolename . '</label>';
                    })->join(' ');

                    return $roles;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value']) {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                    }
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('edit.users', $row->id);

                    $actionBtn =
                        '<div class="d-flex">
                        <a href="' . $editUrl . '" style="padding: 0 2px 0 0;">
                            <button class="btn btn-primary btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                        </a>
                    </a>
                    <button class="btn btn-sm btn-danger btn-wave" type="button" data-bs-toggle="modal"
                    data-bs-target="#exampleModal' . $row->id . '">
                    <i class="fas fa-trash-alt"></i>
                    </button>
                    </div>

                    <div class="modal fade" id="exampleModal' . $row->id . '" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Xác nhận</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="font-size:14px;text-align:center;">
                                    Bạn chắc chắn muốn xóa tài khoản <span style="color: red">' . $row->name . ' </span>?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <form action="' . route('delete.users', $row->id) . '" method="POST" style="display: inline;">
                                        ' . csrf_field() . '
                                        ' . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-primary">Xóa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                    return $actionBtn;
                })
                ->rawColumns(['stt', 'name', 'email', 'password', 'role', 'action'])
                ->make(true);
        }
        return view('role-permission.users.list', [
            'user_email' => $user_email,
            'roles' => $groupedRoles,
            'farm' => $farm,
        ]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $isFarmRole = in_array('Nông Trường', $request->roles);

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:1',
            'roles' => 'required|array',
        ];

        if ($isFarmRole) {
            $validationRules['farms'] = 'required|array';
        }

        $request->validate($validationRules, [
            'email.unique' => 'Tài khoản đã tồn tại.',
            'roles.required' => 'Vui lòng chọn ít nhất một vai trò.',
            'password.min' => 'Mật khẩu phải ít nhất 1 ký tự.',
            'farms.required' => 'Vui lòng chọn ít nhất một nông trường.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->syncRoles($request->roles);

            if ($isFarmRole) {
                $validFarmIds = Farm::whereIn('id', $request->farms)->pluck('id')->toArray();
                if (!empty($validFarmIds)) {
                    $user->farms()->attach($validFarmIds);
                }
            }
            ActionHistory::create([
                'user_id' => Auth::id(),
                'action_type' => 'Tạo',
                'model_type' => 'Người Dùng',
                'details' => "Đã tạo tài khoản: " . $user->name,
            ]);

            Session::put('message', 'Tạo tài khoản thành công');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra khi tạo tài khoản: ' . $e->getMessage()])
                ->withInput();
        }
    }

    // public function store(Request $request)
    // {
    //     $data = $request->all();
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|string|min:1',
    //         'roles' => 'required|array',
    //         'farms' => 'required|array',
    //     ], [
    //         'email.unique' => 'Tài khoản đã tồn tại.',
    //         'roles.required' => 'Vui lòng chọn ít nhất một vai trò.',
    //         'password.min' => 'Mật khẩu phải ít nhất 1 ký tự.',
    //         'farms.required' => 'Vui lòng chọn ít nhất một nông trường.'
    //     ]);
    //     try {

    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => $request->password,
    //             // 'farm_id' => $request->farm_id,
    //         ]);
    //         $user->syncRoles($request->roles);
    //         $validFarmIds = Farm::whereIn('id', $request->farms)->pluck('id')->toArray();
    //         if (!empty($validFarmIds)) {
    //             $user->farms()->attach($validFarmIds);
    //         }
    //         Session::put('message', 'Tạo tài khoản thành công');
    //         return redirect()->back();
    //     } catch (\Exception $e) {
    //         return redirect()->back()
    //             ->withErrors(['error' => 'Có lỗi xảy ra khi tài khoản: ' . $e->getMessage()])
    //             ->withInput();
    //     }
    // }
    public function show(User $users)
    {
        $farm = Farm::where('status', 'Hoạt động')->get();
        $groupFarm = $farm->groupBy(function ($farm) {
            return $farm->unitRelation->unit_name;
        });

        $permissions = Permission::all();
        $users = User::with('farms.unitRelation')->findOrFail($users->id);

        $isFarmsNull = $users->farms->isEmpty();
        $roles = Role::where('name', '!=', 'Khách Hàng')->pluck('name', 'name');

        $userRoles = $users ? $users->roles->pluck('name')->toArray() : [];
        $userPermissions = $users ? $users->permissions->pluck('name')->toArray() : [];
        $groupedRoles = $roles->groupBy(function ($role) {
            if (strpos($role, 'Nông Trường') !== false) {
                return 'Nông Trường';
            } elseif (strpos($role, 'Xe') !== false) {
                return 'Quản Lý Xe';
            } elseif (strpos($role, 'Thông Tin Nguyên Liệu') !== false) {
                return 'Quản Lý Thông Tin Nguyên Liệu';
            } elseif (strpos($role, 'Khu Vực Trồng') !== false) {
                return 'Quản Lý Khu Vực Trồng';
            } elseif (strpos($role, 'Nhà Máy') !== false) {
                return 'Nhà Máy XNCB';
            } elseif (strpos($role, 'Mã Lô') !== false) {
                return 'Quản Lý Mã Lô';
            } elseif (strpos($role, 'Kết Nối TTNL') !== false) {
                return 'Quản Lý Kết Nối Thông Tin Nguyên Liệu';
            } elseif (strpos($role, 'Lệnh Xuất Hàng') !== false) {
                return 'Quản Lý Lệnh Xuất Hàng ';
            } elseif (strpos($role, 'Quản Lý Chất Lượng') !== false) {
                return 'Quản Lý Chất Lượng';
            } elseif (strpos($role, 'Hợp Đồng') !== false) {
                return 'Hợp Đồng';
            } elseif (strpos($role, 'Hợp Đồng') !== false) {
                return 'Hợp Đồng';
            } elseif (strpos($role, 'Chứng Chỉ') !== false) {
                return 'Quản Lý Chứng Chỉ';
            }
            return 'Khác';
        });
        return view('role-permission.users.edit', [
            'user' => $users,
            'roles' => $roles,
            'groupedRoles' => $groupedRoles,
            'userRoles' => $userRoles,
            'permissions' => $permissions,
            'userPermissions' => $userPermissions,
            'farm' => $groupFarm,
            'isFarmsNull' => $isFarmsNull,
        ]);
    }

    // public function update(Request $request, User $users)
    // {
    //     $request->validate([
    //         'name' => 'nullable|max:255',
    //         'email' => 'nullable|email|max:255',
    //         'password' => 'nullable|string|max:25',
    //         'roles' => 'required',
    //         'farms' => 'nullable|array',
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //         'email' => $request->email,
    //     ];

    //     if (!empty($request->password)) {
    //         $data += [
    //             'password' => $request->password,
    //         ];
    //     }

    //     $users->update($data);
    //     $users->syncRoles($request->roles);
    //     // if ($request->has('farms')) {
    //     //     $users->farms()->sync($request->farms);
    //     // }
    //     if (!$users->hasRole('Admin')) {
    //         if ($request->has('farms') && is_array($request->farms)) {
    //             $users->farms()->sync($request->farms);
    //         } else {
    //             $users->farms()->detach();
    //         }
    //     } else {
    //         $users->farms()->detach();
    //     }
    //     Session::put('message', 'Cập nhật thành công.');
    //     return redirect()->route('all.users');
    // }
    public function update(Request $request, User $users)
    {
        $request->validate([
            'name' => 'nullable|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'nullable|string|max:25',
            'roles' => 'required',
            'farms' => 'nullable|array',
        ]);
        $oldData = $users->getOriginal();

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => $request->password,
            ];
        }
        $users->update($data);

        $users->syncRoles($request->roles);
        if ($users->hasanyRole('Nông Trường|Admin')) {
            if ($request->has('farms') && is_array($request->farms)) {
                $users->farms()->sync($request->farms);
            } else {
                $users->farms()->detach();
            }
        } else {
            $users->farms()->detach();
        }
        $details = "Đã chỉnh sửa tài khoản: " . $users->name . "\n";

        foreach ($data as $key => $newValue) {
            $oldValue = isset($oldData[$key]) ? $oldData[$key] : 'Không thay đổi';
            if ($oldValue !== $newValue) {
                $details .= " Tên cũ: " . $oldValue . " => Tên mới: " . $newValue . "\n";
            }
        }
        ActionHistory::create([
            'user_id' => Auth::id(),
            'action_type' => 'Cập Nhật',
            'model_type' => 'Người Dùng',
            'details' => $details,
        ]);
        Session::put('message', 'Cập nhật thành công.');
        return redirect()->route('all.users');
    }

    public function delete(Request $request)
    {

        $user = User::find($request->users);
        // dd($user);
        ActionHistory::create([
            'user_id' => Auth::id(),
            'action_type' => 'delete',
            'model_type' => 'Người Dùng',
            'details' => "Đã xóa tài khoản: " . $user->name,
        ]);
        $user->delete();
        Session::put('message', 'Xóa thành công');
        return redirect()->back();
    }
    public function index()
    {
        return view("users.index");
    }
    // public function update(Request $request)
    // {
    //     $user = User::find(Auth::user()->id);

    //     $validatedData = $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email|unique:users,email,' . $user->id,
    //         'password' => 'nullable|confirmed',
    //     ], [
    //         'name.required' => 'Vui lòng nhập tên.',
    //         'email.required' => 'Vui lòng nhập email.',
    //         'email.email' => 'Email không đúng định dạng.',
    //         'email.unique' => 'Email này đã tồn tại.',
    //         'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
    //     ]);

    //     $user->name = $validatedData['name'];
    //     $user->email = $validatedData['email'];

    //     if (!empty($validatedData['password'])) {
    //         $user->password = bcrypt($validatedData['password']);
    //     }

    //     $user->save();

    //     return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    // }

    public function resetPass()
    {
        return view("auth.passwordreset");
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        // $status = Password::reset(
        //     $request->only('email', 'password', 'password_confirmation', 'token'),
        //     function ($user, $password) {
        //         $user->forceFill([
        //             'password' => Hash::make($password),
        //         ])->save();

        //         $user->setRememberToken(Str::random(60));

        //         event(new PasswordReset($user));
        //     }
        // );

        // return $status === Password::PASSWORD_RESET
        //             ? redirect()->route('login')->with('status', __($status))
        //             : back()->withErrors(['email' => [__($status)]]);
    }

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $exists = User::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }
}
