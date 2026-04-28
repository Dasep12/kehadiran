<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoreDataController extends Controller
{
    // Master Data - Education
    public function education()
    {
        $data = [
            'title' => 'Education',
        ];
        return view('coredata.education', $data);
    }


    public function getEducationData(Request $request)
    {
        $data = DB::table('mst_education')
            ->select('id', 'education_name', 'created_at', 'updated_at', 'updated_by');


        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('education_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudEducation(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'id'            => $request->action == 'create' ? 'required|unique:mst_education,id' : 'required',
            'education_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'education_name' => $request->education_name,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_education')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_education')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    // Tambahkan pengecekan: Apakah posisi ini punya bawahan (children)?
                    $hasChildren = DB::table('mst_employee_education')->where('education_id', $request->id)->exists();
                    if ($hasChildren) {
                        throw new \Exception('Gagal menghapus! Posisi ini masih memiliki bawahan.');
                    }

                    DB::table('mst_education')->where('id', $request->id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }
    // end of Master Data - Education

    // Master Data - Work Status
    public function workStatus()
    {
        $data = [
            'title' => 'Work Status',
        ];
        return view('coredata.work-status', $data);
    }

    public function getWorkStatusData(Request $request)
    {
        $data = DB::table('mst_working_status')
            ->select('id', 'working_name', 'working_code', 'created_at', 'updated_at', 'updated_by');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('working_name', 'like', '%' . $request->search . '%')
                ->orWhere('working_code', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function CrudWorkStatus(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'id'            => $request->action == 'create' ? 'required|unique:mst_working_status,id' : 'required',
            'working_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'working_code'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'working_name' => $request->working_name,
            'working_code' => $request->working_code,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_working_status')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_working_status')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    // Tambahkan pengecekan: Apakah posisi ini punya bawahan (children)?
                    $hasChildren = DB::table('mst_employee_grade')->where('grade_id', $request->id)->exists();
                    if ($hasChildren) {
                        throw new \Exception('Gagal menghapus! Posisi ini masih memiliki bawahan.');
                    }

                    DB::table('mst_working_status')->where('id', $request->id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }
    // end of Master Data - Work Status


    // Master Data - Position
    public function position()
    {
        $data = [
            'title' => 'Position',
        ];
        return view('coredata.position', $data);
    }

    public function getPositionData(Request $request)
    {
        $data = DB::table('mst_position')
            ->select('id', 'position_name', 'created_at', 'updated_at', 'updated_by');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('position_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    public function getTreePosition()
    {
        $rows = DB::table('mst_position')
            ->select('id', 'position_name', 'parent_id')
            ->get();

        $tree = $rows->map(function ($row) {

            return [
                "id" => $row->id,
                "parent" => $row->parent_id ? $row->parent_id : "#",
                "text" => "[" . $row->id . "] " . $row->position_name,
            ];
        });

        return response()->json($tree);
    }

    public function getTreePositionDetail(Request $request)
    {

        switch ($request->action) {
            case 'getParent':
                $data = DB::table('mst_position')
                    ->select('id', 'position_name', 'level', 'parent_id', 'created_at', 'updated_at', 'updated_by')
                    ->where('level', $request->level)
                    ->get();
                return response()->json($data);
                break;
            default:
                $data = DB::table('mst_position')
                    ->select('id', 'position_name', 'level', 'parent_id', 'created_at', 'updated_at', 'updated_by')
                    ->where('id', $request->id)
                    ->first();
                break;
        }
        return response()->json($data);
    }

    public function getPositionEmployee(Request $request)
    {
        $today = now()->format('Y-m-d');
        $data = DB::table('vw_employee as a')
            ->select('a.employee_id', 'a.employee_name', 'a.gender', 'a.photo', 'a.photo_path', 'a.employee_code', 'a.position_name', 'b.created_at')
            ->leftJoin('vw_employee_position as b', 'a.employee_id', '=', 'b.employee_id')
            ->where('b.position_id', $request->position_id)
            ->where(function ($query) use ($today) {
                $query->where('b.end_date', '>=', $today)
                    ->orWhereNull('b.end_date'); // Penting jika posisi aktif end_date-nya kosong
            });
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('a.position_name', 'like', '%' . $request->search . '%')
                ->orWhere('a.employee_name', 'like', '%' . $request->search . '%')
                ->orWhere('a.employee_code', 'like', '%' . $request->search . '%');
        }

        return response()->json($data->get());
    }

    public function CrudPosition(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'id'            => $request->action == 'create' ? 'required|unique:mst_position,id' : 'required',
            'position_name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'level'         => $request->action != 'delete' ? 'required|integer' : 'nullable',
            'parent_id'     => 'nullable|exists:mst_position,id',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'position_name' => $request->position_name,
            'level'         => $request->level,
            'parent_id'     => $request->parent_id,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_position')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_position')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    // Tambahkan pengecekan: Apakah posisi ini punya bawahan (children)?
                    $hasChildren = DB::table('mst_position')->where('parent_id', $request->id)->exists();
                    if ($hasChildren) {
                        throw new \Exception('Gagal menghapus! Posisi ini masih memiliki bawahan.');
                    }

                    DB::table('mst_position')->where('id', $request->id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    // end of Master Data - Position

    // Master Data - Organization
    public function organization()
    {
        $data = [
            'title' => 'Organization',
        ];
        return view('coredata.organization', $data);
    }

    public function getTreeOrganization()
    {
        // ambil semua company (root)
        $companies = DB::table('mst_company')
            ->select('company_id as id', 'company_name as text')
            ->get()
            ->map(function ($row) {
                return [
                    "id" => $row->id,
                    "parent" => "#", // root
                    "text" => $row->text,
                    "type" => "company",

                ];
            });

        // ambil semua organization
        $orgs = DB::table('mst_organization as o')
            ->select(
                'o.organization_id as id',
                'o.organization_name as text',
                'o.parent_id',
                'o.company_id'
            )
            ->get()
            ->map(function ($row) {

                return [
                    "id" => $row->id,
                    "parent" => $row->parent_id
                        ? $row->parent_id
                        : $row->company_id, // kalau root org → parent ke company
                    "text" => $row->text,
                    "type" => $row->parent_id != null || $row->parent_id != ''  ? "organization" : "company"
                ];
            });

        // merge company + org
        $tree = $companies->merge($orgs)->values();

        return response()->json($tree);
    }

    public function getTreeOrganizationDetail(Request $request)
    {
        switch ($request->action) {

            case 'getParent':
                $data = DB::table('mst_organization')
                    ->select('*')
                    ->where('level', $request->level)
                    ->get();
                break;

            default:
                $data = DB::table('mst_organization')
                    ->select('*')
                    ->where('organization_id', $request->id)
                    ->first();
                break;
        }

        return response()->json($data);
    }

    public function getOrganizationEmployee(Request $request)
    {
        $today = now()->format('Y-m-d');
        $data = DB::table('vw_employee as a')
            ->select('a.employee_id', 'a.employee_name', 'a.gender', 'a.photo', 'a.photo_path', 'a.employee_code', 'a.organization_name', 'b.created_at')
            ->leftJoin('vw_employee_organization as b', 'a.employee_id', '=', 'b.employee_id')
            ->where('b.organization_id', $request->organization_id)
            ->where(function ($query) use ($today) {
                $query->where('b.end_date', '>=', $today)
                    ->orWhereNull('b.end_date'); // Penting jika posisi aktif end_date-nya kosong
            });
        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('a.organization_name', 'like', '%' . $request->search . '%')
                ->orWhere('a.employee_name', 'like', '%' . $request->search . '%')
                ->orWhere('a.employee_code', 'like', '%' . $request->search . '%');
        }

        return response()->json($data->get());
    }

    public function CrudOrganization(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'organization_name' => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
            'level'         => $request->action != 'delete' ? 'required|integer' : 'nullable',
            'parent_id'     => 'nullable|exists:mst_organization,organization_id',
            'company_id'     => 'nullable|exists:mst_company,company_id',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'organization_name' => $request->organization_name,
            'level'         => $request->level,
            'sort'         => $request->sort,
            'initial'         => $request->initial,
            'parent_id'     => $request->parent_id,
            'company_id'     => $request->company_id,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    // $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_organization')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_organization')->where('organization_id', $request->organization_id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    // Tambahkan pengecekan: Apakah posisi ini punya bawahan (children)?
                    $hasChildren = DB::table('mst_organization')->where('parent_id', $request->organization_id)->exists();
                    if ($hasChildren) {
                        throw new \Exception('Gagal menghapus! Posisi ini masih memiliki bawahan.');
                    }

                    DB::table('mst_organization')->where('organization_id', $request->organization_id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function getParentOrganizationLevel(Request $request)
    {
        $data = DB::table('vw_organization_tree')
            ->select('*')
            ->where('company_id', $request->company_id)
            ->where('level', $request->level)
            ->get();
        return response()->json($data);
    }
    // end of Master Data - Organization

    // Master Data - Company

    public function getCompanyData(Request $request)
    {
        $data = DB::table('mst_company')
            ->select('*');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('company_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('company_name', 'desc')->get();
        return response()->json($data);
    }
    // end of Master Data - Company

    // Master Data - Job Grade
    public function jobGrade()
    {
        $data = [
            'title' => 'Job Grade',
        ];
        return view('coredata.job-grade', $data);
    }

    public function getJobGradeData(Request $request)
    {
        $data = DB::table('mst_grade')
            ->select('id', 'grade_name', 'created_at', 'created_by', 'updated_at', 'updated_by');

        if ($request->has('search') && !empty($request->search)) {
            $data = $data->where('grade_name', 'like', '%' . $request->search . '%');
        }
        $data = $data->orderBy('grade_name', 'desc')->get();
        return response()->json($data);
    }


    public function CrudJobGrade(Request $request)
    {
        // 1. Validasi dilakukan di awal (sebelum Transaction)
        // Supaya jika gagal, Laravel otomatis mengembalikan pesan error 422
        $rules = [
            'action'        => 'required|in:insert,update,delete,create',
            'id'            => $request->action == 'create' ? 'required|unique:mst_grade,id' : 'required',
            'grade_name'    => $request->action != 'delete' ? 'required|string|max:255' : 'nullable',
        ];

        $request->validate($rules);

        // 2. Siapkan data (Hanya untuk insert & update)
        $data = [
            'grade_name' => $request->grade_name,
            'updated_by'    => auth()->id() ?? 'system',
            'updated_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            switch ($request->action) {
                case 'create':
                    $data['id'] = $request->id;
                    $data['created_at'] = now();
                    DB::table('mst_grade')->insert($data);
                    $message = 'Data berhasil ditambahkan';
                    break;

                case 'update':
                    DB::table('mst_grade')->where('id', $request->id)->update($data);
                    $message = 'Data berhasil diupdate';
                    break;

                case 'delete':
                    // Tambahkan pengecekan: Apakah posisi ini punya bawahan (children)?
                    $hasChildren = DB::table('mst_employee_grade')->where('grade_id', $request->id)->exists();
                    if ($hasChildren) {
                        throw new \Exception('Gagal menghapus! Posisi ini masih memiliki bawahan.');
                    }

                    DB::table('mst_grade')->where('id', $request->id)->delete();
                    $message = 'Data berhasil dihapus';
                    break;
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => $message, 'success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'success' => false, 'message' => $e->getMessage()], 400);
        }
    }
    //end of Master Data - Job Grade


}
