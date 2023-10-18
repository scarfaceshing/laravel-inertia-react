<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Events\ImportEmployeesEvent;
use Illuminate\Support\Facades\Redirect;

class TestController extends Controller
{
 public function index(Request $request)
 {
  $limit = $request->query('limit');
  $search = $request->query('search');
  $sort_by = $request->query('sortBy');
  $order_by = $request->query('orderBy');

  $data = Permission::where('name', 'LIKE', "%{$search}%")
   ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
   ->paginate($limit);

  return Inertia::render('Test/Index', [
      'response' => $data,
  ]);
 }

 public function trigger()
 {
    ImportEmployeesEvent::dispatch('test');
    
    return Redirect::route('test.index');
 }
}
