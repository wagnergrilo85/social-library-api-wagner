<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
//        return Student::all();
        return DB::table('students')->paginate(20);
    }

    public function show(Student $student)
    {
        return $student;
    }

    public function store(Request $request)
    {
        return Student::create($request->all());
    }

    public function update(Request $request, Student $student)
    {
        $student->update($request->all());
        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return $student;
    }

    public function datatables(Request $request)
    {

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 => 'id',
            1 => 'name',
            2 => 'fathers_name',
            3 => 'mothers_name',
            4 => 'cellphone',
            5 => 'numberHouse',
            6 => 'complement',
            7 => 'neighborhood',
            8 => 'city',
            9 => 'city',
            10 => 'internal_code',
            11 => 'registry',
            12 => 'status',
        );

        $totalData = Student::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if (empty($search)) {

            if (empty($limit))
                $limit = 1;

            $students = Student::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $sql_print = Student::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->toSql();

        } else {

            if (empty($limit))
                $limit = 1;

            $search = $request->input('search.value');

            $sql = Student::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('fathers_name', 'LIKE', "%{$search}%")
                ->orWhere('mothers_name', 'LIKE', "%{$search}%")
                ->orWhere('cellphone', 'LIKE', "%{$search}%")
                ->orWhere('city', 'LIKE', "%{$search}%")
                ->orWhere('internal_code', 'LIKE', "%{$search}%")
                ->orWhere('registry', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $sql_print = Student::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('fathers_name', 'LIKE', "%{$search}%")
                ->orWhere('mothers_name', 'LIKE', "%{$search}%")
                ->orWhere('cellphone', 'LIKE', "%{$search}%")
                ->orWhere('city', 'LIKE', "%{$search}%")
                ->orWhere('internal_code', 'LIKE', "%{$search}%")
                ->orWhere('registry', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->toSql();

            $students = $sql;

            $totalFiltered = Student::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('fathers_name', 'LIKE', "%{$search}%")
                ->orWhere('mothers_name', 'LIKE', "%{$search}%")
                ->orWhere('cellphone', 'LIKE', "%{$search}%")
                ->orWhere('city', 'LIKE', "%{$search}%")
                ->orWhere('internal_code', 'LIKE', "%{$search}%")
                ->orWhere('registry', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($students)) {
            foreach ($students as $currentModel) {

                $nestedData['id'] = $currentModel->id;
                $nestedData['name'] = $currentModel->name;
                $nestedData['fathers_name'] = $currentModel->fathers_name;
                $nestedData['mothers_name'] = $currentModel->mothers_name;
                $nestedData['cellphone'] = $currentModel->cellphone;
                $nestedData['numberHouse'] = $currentModel->numberHouse;
                $nestedData['complement'] = $currentModel->complement;
                $nestedData['neighborhood'] = $currentModel->neighborhood;
                $nestedData['city'] = $currentModel->city;
                $nestedData['internal_code'] = $currentModel->internal_code;
                $nestedData['registry'] = $currentModel->registry;
                $nestedData['created_at'] = $currentModel->created_at;
                $nestedData['status'] = $currentModel->status;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
            "sql" => $sql_print
        );

        echo json_encode($json_data);
    }


}
