<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        return $this->categoryRepository->getAll();
    }

    public function show(Category $category)
    {
        $courses = $this->categoryRepository->getCoursesInCategory($category);

        return view('pages.category', [
            'courses' => $courses,
            'category' => $category
        ]);
    }

    public function store(Request $request)
    {
        return $this->categoryRepository->create($request->all());
    }

    public function update(Request $request, $id)
    {
        return $this->categoryRepository->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->categoryRepository->delete($id);
    }

}
