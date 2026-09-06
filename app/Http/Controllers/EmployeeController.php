<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // GET - Display employees with pagination, search, and filtering
    public function index(Request $request)
    {
        $query = Employee::with('department');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where(
                'department_id',
                $request->department_id
            );
        }

        return response()->json(
            $query->paginate(10),
            200
        );
    }

    // POST - Create a new employee
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'position' => 'required|string|max:255',
        ]);

        $employee = Employee::create($validated);
        $employee->load('department');

        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    // GET - Display one employee
    public function show($id)
    {
        $employee = Employee::with('department')->find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        return response()->json($employee, 200);
    }

    // PUT - Update an employee
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:employees,email,' . $id,
            'department_id' => 'sometimes|required|exists:departments,id',
            'position' => 'sometimes|required|string|max:255',
        ]);

        $employee->update($validated);
        $employee->load('department');

        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee
        ], 200);
    }

    // DELETE - Delete an employee
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}