<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

class PageController extends Controller
{
    public function index(Request $request)
    {


        $lang = $request->header('lang');
        $pages = Page::select('id', 'name_' . $lang, 'description_' . $lang)->get();
        if ($pages->isEmpty()) {
            $not_exist = collect(['Page' => ['Page table data not exist.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_exist
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'All menus.',
            'data' => $pages,
            'errors' => false
        ],200);
    }

    public function single(Request $request, $id)
    {
        $lang = $request->header('lang');
        $page = Page::select('id', 'name_' . $lang, 'description_' . $lang)
            ->where('id', $id)->first();

        if ($page == null) {
            $not_exist = collect(['Page' => ['Page table data not exist.']]);
            return response()->json([
                'success' => false,
                'message' => 'Error',
                'data' => [],
                'errors' => $not_exist
            ],202);
        }

        return response()->json([
            'success' => true,
            'message' => 'Single menu data.',
            'data' => $page,
            'errors' => false
        ],200);
    }


}
