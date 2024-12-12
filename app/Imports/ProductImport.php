<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Group;
use App\Models\Unit;
use App\Models\Storage;
use App\Models\Prices;
use App\Models\ProductUnit;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Xử lý danh mục (Phân loại)
        $category = null;
        if (!empty($row['phan_loai'])) {
            $category = Category::firstOrCreate(['name' => $row['phan_loai']]);
        }

        // Xử lý nhóm hàng
        $group = null;
        if (!empty($row['nhom_hang'])) {
            $group = Group::firstOrCreate(['name' => $row['nhom_hang']]);
        }

        // Xử lý đơn vị tính
        $units = [];
        foreach (['dv_tinh1', 'dv_tinh2', 'dv_tinh3'] as $unitKey) {
            if (!empty($row[$unitKey])) {
                // Tạo đơn vị nếu chưa có
                $units[] = Unit::firstOrCreate(['name' => $row[$unitKey]]);
            }
        }

        // Tạo hoặc cập nhật sản phẩm
        $product = Product::updateOrCreate(
            ['name' => $row['ten_hang']], // Điều kiện kiểm tra sản phẩm tồn tại
            [
                'short_name' => $row['ten_tat'] ?? null, // Tên tắt
                'specification' => $row['quy_cach'] ?? null, // Quy cách
                'category_id' => $category?->id, // Gán category_id
                'group_id' => $group?->id, // Gán group_id
                'registration_number' => $row['so_dkcl'] ?? null, // Số ĐKCL
                'notes' => $row['loai_hang'] ?? null, // Loại hàng
            ]
        );

        // Lưu giá vào bảng prices
        Prices::create([
            'product_id' => $product->id,
            'purchase_price' => $row['gia_nhap'] ?? null, // Giá nhập
            'sale_price' => $row['gia_ban'] ?? null, // Giá bán
            'declared_price' => $row['gia_ke_khai'] ?? null, // Giá kê khai
            'cost_price' => $row['gia_von'] ?? null, // Giá nhập giá vốn
            'listed_price' => $row['gia_niem_yet'] ?? null, // Giá niêm yết
            'specific_cost' => $row['gia_dich_danh'] ?? null, // Giá vốn đích danh
            'hapu_price' => $row['gia_hapu'] ?? null, // Giá Hapu
            'hapu_price_updated' => $row['ngay_cap_nhat_gia_hapu'] ?? null, // Ngày cập nhật giá Hapu
            'min_sale_price' => $row['gia_ban_toi_thieu'] ?? null, // Giá bán tối thiểu
            'max_sale_price' => $row['gia_ban_toi_da'] ?? null, // Giá bán tối đa
        ]);

        // Gán đơn vị tính cho sản phẩm
        foreach ($units as $index => $unit) {
            ProductUnit::create([
                'product_id' => $product->id,
                'unit_id' => $unit->id,
                'conversion_rate' => $row["he_so_quy_doi_" . ($index + 1)] ?? 1, // Hệ số quy đổi
            ]);
        }

        // Xử lý vị trí lưu trữ
        if (!empty($row['noi_de'])) {
            $storage = Storage::firstOrCreate(
                ['name' => $row['noi_de']],
                ['code' => $row['ma_noi_de'] ?? Str::random(5)] // Mã vị trí lưu trữ
            );
            $product->storages()->syncWithoutDetaching([$storage->id]); // Gán vị trí lưu trữ cho sản phẩm
        }

        return $product;
    }
}
