<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PublishingCompany;
use Illuminate\Support\Facades\DB;

class PublishingCompanyController extends Controller
{
    public function index()
    {
        return DB::table('publishing_companies')->paginate(10);
//        return PublishingCompany::all();
    }

    public function store(Request $request)
    {
        return PublishingCompany::create($request->all());
    }

    public function show(PublishingCompany $publishingCompany)
    {
        return $publishingCompany;
    }

    public function update(Request $request, PublishingCompany $publishingCompany)
    {
        $publishingCompany->update($request->all());
        return $publishingCompany;
    }

    public function destroy(PublishingCompany $publishingCompany)
    {
        $publishingCompany->delete();
        return $publishingCompany;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>   'id',
            1 =>   'name',
            2 =>   'website',
            3 =>   'email',
            4 =>   'address',
            5 =>   'status',
        );

        $totalData = PublishingCompany::count();

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

            $publishings = PublishingCompany::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = PublishingCompany::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

        }else {

            if(empty($limit))
                $limit = 1;

            $search = $request->input('search.value');

            $sql =  PublishingCompany::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('website', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('address', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = PublishingCompany::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('website', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('address', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $publishings = $sql;

            $totalFiltered = PublishingCompany::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('website', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('address', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($publishings))
        {
            foreach ($publishings as $currentModel)
            {
                $nestedData['id']               = $currentModel->id;
                $nestedData['name']             = $currentModel->name;
                $nestedData['website']          = $currentModel->website;
                $nestedData['email']            = $currentModel->email;
                $nestedData['address']          = $currentModel->address;
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
