<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function showImportForm()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Sử dụng transaction để đảm bảo dữ liệu được xử lý an toàn
        DB::beginTransaction();

        try {
            Excel::import(new ProductImport, $request->file('file'));
            // Commit dữ liệu nếu không có lỗi xảy ra
            DB::commit();
            return redirect()->back()->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            Log::error('Import error: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Error importing data. Check logs for details.');
        }
    }
}
