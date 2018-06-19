<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


    public function index()
    {
//        return Category::all();
        return DB::table('categories')->paginate(3);
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $category;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>   'id',
            1 =>   'name',
            5 =>   'status',
        );

        $totalData = Category::count();

        $totalFiltered = $totalData;

        $search     = $request->input('search.value');
        $limit      = $request->input('length');
        $start      = $request->input('start');
        $dir        = $request->input('order.0.dir');
        $order      = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {

            if(empty($limit))
                $limit = 1;

            $categories = Category::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = Category::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

        }else {

            if(empty($limit))
                $limit = 1;

            $search = $request->input('search.value');

            $sql =  Category::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = Category::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $categories = $sql;

            $totalFiltered = Category::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($categories))
        {
            foreach ($categories as $currentModel)
            {
                $nestedData['id']               = $currentModel->id;
                $nestedData['name']             = $currentModel->name;
                $nestedData['created_at']       = $currentModel->created_at;
                $nestedData['status']           = $currentModel->status;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
            "sql"             => $sql_print
        );

        echo json_encode($json_data);
    }
}
