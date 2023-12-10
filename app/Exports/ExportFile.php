<?php

namespace App\Exports;

use App\Models\Post;
use App\Models\Order;
use App\Models\User;
use App\Models\Presenter;
use App\Models\UserPost;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportFile implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Order::query()
            ->select(
                'orders.id',
                'orders.status',
                'orders.total_price',
                'orders.reference',
                'orders.user_id',
                'users.full_name',
                'users.email',
                'posts.paper_id',
                'posts.title',
                'transactions.created_at',
                'transactions.amount',
                'transactions.payment_status',
                'transactions.payment_desc',
                'transactions.deleted_at',
                'presenters.post_id',
                'presenters.extra_page',

            )
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->leftJoin('transactions', 'transactions.order_id', '=', 'orders.id')
            ->leftJoin('presenters', 'presenters.order_id', '=', 'orders.id')
            ->leftJoin('posts', 'posts.id', '=', 'presenters.post_id');
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Order Status',
            'Order Total Price',
            'Order Reference',
            'User ID',
            'User Full Name',
            'User Email',
            'Paper ID',
            'Post Title',
            'Transaction Created At',
            'Transaction Amount',
            'Transaction Payment Status',
            'Transaction Payment Description',
            'Transaction Deleted At',
            'Presenter Post ID',
            'Presenter Extra Page',
        ];
    }
}
