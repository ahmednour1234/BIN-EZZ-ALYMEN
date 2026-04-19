<?php

namespace App\Services;

use App\Models\StockTransfer;
use App\Repositories\Contracts\StockTransferRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StockTransferService
{
    public function __construct(protected StockTransferRepositoryInterface $stockTransferRepository)
    {
    }

    public function getById(int $id)
    {
        return $this->stockTransferRepository->getById($id);
    }

    public function paginateWithFilters(int $perPage, ?string $search, ?string $status, ?int $branchId)
    {
        return $this->stockTransferRepository->paginateWithFilters($perPage, $search, $status, $branchId);
    }

    public function createTransfer(array $data, array $items): StockTransfer
    {
        return DB::transaction(function () use ($data, $items) {
            $transfer = $this->stockTransferRepository->create($data);

            foreach ($items as $item) {
                $transfer->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            return $transfer->load('items');
        });
    }

    public function approveTransfer(int $id, int $adminId): StockTransfer
    {
        return DB::transaction(function () use ($id, $adminId) {
            $transfer = $this->stockTransferRepository->getById($id);

            if ($transfer->status !== 'pending') {
                throw new \Exception('لا يمكن الموافقة على هذا التحويل');
            }

            // Deduct from source branch
            foreach ($transfer->items as $item) {
                $branchProduct = DB::table('branch_product')
                    ->where('branch_id', $transfer->from_branch_id)
                    ->where('product_id', $item->product_id)
                    ->first();

                if (!$branchProduct || $branchProduct->quantity < $item->quantity) {
                    throw new \Exception("الكمية غير كافية للمنتج: {$item->product->name}");
                }

                DB::table('branch_product')
                    ->where('branch_id', $transfer->from_branch_id)
                    ->where('product_id', $item->product_id)
                    ->decrement('quantity', $item->quantity);
            }

            $transfer->update([
                'status' => 'approved',
                'approved_by' => $adminId,
                'approved_at' => now(),
            ]);

            return $transfer;
        });
    }

    public function rejectTransfer(int $id, int $adminId): StockTransfer
    {
        $transfer = $this->stockTransferRepository->getById($id);

        if ($transfer->status !== 'pending') {
            throw new \Exception('لا يمكن رفض هذا التحويل');
        }

        $transfer->update([
            'status' => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => now(),
        ]);

        return $transfer;
    }

    public function receiveTransfer(int $id, int $adminId): StockTransfer
    {
        return DB::transaction(function () use ($id, $adminId) {
            $transfer = $this->stockTransferRepository->getById($id);

            if ($transfer->status !== 'approved') {
                throw new \Exception('لا يمكن استلام هذا التحويل');
            }

            // Add to destination branch
            foreach ($transfer->items as $item) {
                DB::table('branch_product')->updateOrInsert(
                    [
                        'branch_id' => $transfer->to_branch_id,
                        'product_id' => $item->product_id,
                    ],
                    [
                        'quantity' => DB::raw("COALESCE(quantity, 0) + {$item->quantity}"),
                        'updated_at' => now(),
                        'created_at' => DB::raw("COALESCE(created_at, '" . now() . "')"),
                    ]
                );
            }

            $transfer->update([
                'status' => 'received',
                'received_by' => $adminId,
                'received_at' => now(),
            ]);

            return $transfer;
        });
    }
}
