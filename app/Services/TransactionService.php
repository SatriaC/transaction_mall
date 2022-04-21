<?php

namespace App\Services;

use App\Helpers\Pagination;
use App\Repositories\ItemRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\VoucherRepository;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TransactionService extends BaseService
{
    protected $repo;
    protected $repoDetail;
    protected $repoItem;
    protected $repoVoucher;

    public function __construct(
        TransactionRepository $repo,
        TransactionDetailRepository $repoDetail,
        ItemRepository $repoItem,
        VoucherRepository $repoVoucher,
    ) {
        parent::__construct();
        $this->repo = $repo;
        $this->repoDetail = $repoDetail;
        $this->repoVoucher = $repoVoucher;
        $this->repoItem = $repoItem;
    }

    public function store($request)
    {
        $db = DB::connection($this->connection);
        $db->beginTransaction();
        try {
            # code...
            $data['user_id'] = Auth::guard('api')->user()->id;
            $data['date'] = Carbon::now()->format('Y-m-d');
            $transaction = $this->repo->create($data);
            $db->commit();
            $dataDetail['transaction_id'] = $transaction->id;
            $dataDetail['item_id'] = $request->item_id;
            $dataDetail['qty'] = $request->qty;
            $dataDetail['total'] = $request->qty*$transaction->item->price;
            $transactionDetail = $this->repoDetail->create($dataDetail);
            $db->commit();
            $data['total_item'] = $transactionDetail->qty;
            $data['grand_total'] = $transactionDetail->total;
            $this->repo->update($data, $transaction->id);
            $db->commit();
            $item = $this->repo->getById($transaction->id);
            $this->voucher($item);

            return $this->responseMessage(__('content.message.create.success'), 200, true);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            $db->rollback();
            return $this->responseMessage(__('content.message.create.failed'), 400, false);
        }
    }

    public function show($id)
    {
        try {
            # code...
            $data = $this->repo->getById($id);

            return $this->responseMessage(__('content.message.read.success'), 200, true, $data);
        } catch (Exception $exc) {
            # code...
            Log::error($exc);
            return $this->responseMessage(__('content.message.read.failed'), 400, false);
        }
    }

    public function voucher($transaction)
    {
        # code...
        $item = ceil($transaction->grand_total/1000000);
        $data['user_id'] = Auth::guard('api')->user()->id;
        $data['amount'] = $item*10000;
        $voucher = $this->repoVoucher->create($data);


    }

}
