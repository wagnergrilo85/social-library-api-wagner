<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Author;

class AuthorController extends Controller
{
    public function index()
    {
        return DB::table('authors')->paginate(5);
//        return Author::all();
    }

    public function store(Request $request)
    {
        return Author::create($request->all());
    }

    public function show(Author $author)
    {
        return $author;
    }

    public function update(Request $request, Author $author)
    {
        $author->update($request->all());
        return $author;
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return $author;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>   'id',
            1 =>   'name',
            2 =>   'nationality',
            3 =>   'status',
        );

        $totalData = Author::count();

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

            $authors = Author::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = Author::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

        }else {

            if(empty($limit))
                $limit = 1;

            $search = $request->input('search.value');

            $sql =  Author::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = Author::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $authors = $sql;

            $totalFiltered = Author::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($authors))
        {
            foreach ($authors as $currentModel)
            {
                $nestedData['id']               = $currentModel->id;
                $nestedData['name']             = $currentModel->name;
                $nestedData['nationality']      = $currentModel->nationality;
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
