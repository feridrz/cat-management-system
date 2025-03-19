<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Services\CatService;
use Illuminate\Http\Request;

class CatController extends Controller
{
    protected $catService;

    public function __construct(CatService $catService)
    {
        $this->catService = $catService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Cat::with(['mother', 'fathers']);

            if ($request->filled('gender')) {
                $query->where('gender', $request->input('gender'));
            }
            if ($request->filled('age')) {
                $query->where('age', $request->input('age'));
            }

            return datatables()->of($query)
                ->addColumn('mother', function ($cat) {
                    return $cat->mother ? $cat->mother->name : 'None';
                })
                ->addColumn('fathers', function ($cat) {
                    return $cat->fathers->pluck('name')->implode(', ') ?: 'None';
                })
                ->addColumn('actions', function ($cat) {
                    return '<a href="'.route('cats.edit', $cat).'" class="btn btn-warning btn-sm">Изменить</a>
                        <form action="'.route('cats.destroy', $cat).'" method="POST" style="display:inline;">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\');">Удалить</button>
                        </form>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('cats.index');
    }


    public function create()
    {
        $allCats = Cat::all();
        return view('cats.create', compact('allCats'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'   => ['required', 'string', 'max:255', 'regex:/^[a-zA-Zа-яА-ЯёЁ0-9\s]+$/u'],
            'gender' => ['required', 'in:male,female'],
            'age'    => ['required', 'integer', 'min:0'],
        ]);

        // Remove HTML/JS from name (extra security)
        $validatedData['name'] = strip_tags($validatedData['name']);

        $this->catService->createCat($validatedData);
        return redirect()->route('cats.index')->with('success', 'Кот добавлен!');
    }


    public function edit(Cat $cat)
    {
        $allCats = Cat::all();
        return view('cats.edit', compact('cat', 'allCats'));
    }


    public function update(Request $request, Cat $cat)
    {
        $validatedData = $request->validate([
            'name'   => ['required', 'string', 'max:255', 'regex:/^[a-zA-Zа-яА-ЯёЁ0-9\s]+$/u'],
            'gender' => ['required', 'in:male,female'],
            'age'    => ['required', 'integer', 'min:0'],
        ]);

        $validatedData['name'] = strip_tags($validatedData['name']);

        $this->catService->updateCat($cat, $validatedData);
        return redirect()->route('cats.index')->with('success', 'Кот обновлён!');
    }

    public function destroy(Cat $cat)
    {
        $cat->delete();
        return redirect()->route('cats.index')->with('success', 'Кот удалён!');
    }
}
