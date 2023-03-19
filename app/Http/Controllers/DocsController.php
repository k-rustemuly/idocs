<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use App\Modules\Services\External\Idocs\Idocs;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Idocs $idocs)
    {
        $idocs->getAllDocs();
        return redirect()->route('save');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Idocs $idocs)
    {
        return $idocs->saveDocs();
    }

}
