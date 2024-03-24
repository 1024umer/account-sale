<?php

namespace App\Http\Controllers\Backend;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    public function index()
    {
        $totalCategory = Faq::count();
        return view('backend.faqs.index', compact('totalCategory'));
    }
    public function list(Request $request)
    {
        try {
            $totalData = Faq::count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = 'id';
            $dir = $request->input('order.0.dir');
            if (empty($request->input('search.value'))) {
                $results = Faq::offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $search = $request->input('search.value');

                $results = Faq::search($search)
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = count($results);
            }

            $data = array();
            if (!empty($results)) {
                foreach ($results as $row) {
                    $nestedData['id'] = $row->id;
                    $nestedData['question'] = $row->question;
                    $nestedData['answer'] = $row->answer;
                    $nestedData['action'] = view('backend.faqs._actions', [
                        'row' => $row,
                    ])->render();
                    $data[] = $nestedData;
                }
            }

            $json_data = array(
                "draw"            => intval($request->input('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval($totalFiltered),
                "data"            => $data
            );

            echo json_encode($json_data);
        } catch (\Throwable $th) {
            throw $th;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $category = new Faq();
        $category->question = $request->question;
        $category->answer = $request->answer;
        $category->created_by = Auth::user()->id;
        $category->save();

        return redirect()->back()->with('success', 'Faq added successfull!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ]);

        $category = Faq::where('id', $request->id)->first();
        $category->question = $request->question;
        $category->answer = $request->answer;
        $category->created_by = Auth::user()->id;
        $category->save();

        return redirect()->back()->with('success', 'Category updated successfull!');
    }

    public function delete($id)
    {
        $data = Faq::where('id', $id)->first();
        $data->delete();
        return response()->json('Success');
    }
}
