<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $serviceId = $request->query('service_id');
        $category = $request->query('category', 'all');
        $paymentStatus = $request->query('payment_status', 'all');

        $query = Payment::with(['order.service', 'order.user'])
            ->whereHas('order', function ($q) use ($startDate, $endDate, $serviceId, $category) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);

                if ($serviceId) {
                    $q->where('service_id', $serviceId);
                }

                if ($category !== 'all') {
                    $q->whereHas('service', fn($sq) => $sq->where('category', $category));
                }
            });

        if ($paymentStatus !== 'all') {
            $query->where('status', $paymentStatus);
        }

        $payments = (clone $query)->latest()->paginate(15);

        // Calculate summary metrics on full filtered dataset
        $allFiltered = (clone $query)->get();

        $totalRevenue = $allFiltered->where('status', 'paid')->sum('amount');
        $totalPaidCount = $allFiltered->where('status', 'paid')->count();
        $averageOrderValue = $totalPaidCount > 0 ? ($totalRevenue / $totalPaidCount) : 0;
        $totalUnpaidAmount = $allFiltered->where('status', 'unpaid')->sum('amount');
        $totalUnpaidCount = $allFiltered->where('status', 'unpaid')->count();

        // Revenue by category breakdown
        $categoryRevenue = [];
        foreach (['wisuda' => 'Foto Wisuda', 'umkm' => 'Foto Produk UMKM', 'acara' => 'Dokumentasi Acara', 'video_promosi' => 'Video Promosi'] as $catKey => $catName) {
            $catSum = $allFiltered->where('status', 'paid')
                ->filter(fn($p) => optional($p->order->service)->category === $catKey)
                ->sum('amount');
            $categoryRevenue[$catName] = $catSum;
        }

        // Revenue by payment method
        $methodRevenue = [];
        foreach ($allFiltered->where('status', 'paid')->groupBy('payment_method') as $mKey => $items) {
            $methodRevenue[$mKey] = $items->sum('amount');
        }

        $services = Service::all();

        return view('admin.reports.index', compact(
            'payments',
            'startDate',
            'endDate',
            'serviceId',
            'category',
            'paymentStatus',
            'totalRevenue',
            'totalPaidCount',
            'averageOrderValue',
            'totalUnpaidAmount',
            'totalUnpaidCount',
            'categoryRevenue',
            'methodRevenue',
            'services'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $serviceId = $request->query('service_id');
        $category = $request->query('category', 'all');
        $paymentStatus = $request->query('payment_status', 'all');

        $query = Payment::with(['order.service', 'order.user'])
            ->whereHas('order', function ($q) use ($startDate, $endDate, $serviceId, $category) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);

                if ($serviceId) {
                    $q->where('service_id', $serviceId);
                }

                if ($category !== 'all') {
                    $q->whereHas('service', fn($sq) => $sq->where('category', $category));
                }
            });

        if ($paymentStatus !== 'all') {
            $query->where('status', $paymentStatus);
        }

        $payments = $query->latest()->get();

        $filename = 'Laporan_Keuangan_Dokumentasi_' . $startDate . '_sd_' . $endDate . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($payments, $startDate, $endDate) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM for Microsoft Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Title block
            fputcsv($file, ['LAPORAN KEUANGAN & TRANSAKSI PEMESANAN JASA DOKUMENTASI']);
            fputcsv($file, ['Periode:', $startDate . ' s/d ' . $endDate]);
            fputcsv($file, ['Dicetak Pada:', now()->translatedFormat('d F Y H:i:s')]);
            fputcsv($file, []);

            // Header columns
            fputcsv($file, [
                'No.',
                'Kode Transaksi',
                'No. Invoice',
                'Nama Pelanggan',
                'Email',
                'No. Telepon',
                'Layanan',
                'Kategori',
                'Tanggal Booking',
                'Waktu',
                'Metode Bayar',
                'Status Bayar',
                'Tanggal Lunas',
                'Nominal (Rp)',
            ]);

            $totalRevenue = 0;
            foreach ($payments as $index => $payment) {
                $order = $payment->order;
                $service = $order?->service;

                if ($payment->status === 'paid') {
                    $totalRevenue += (float)$payment->amount;
                }

                fputcsv($file, [
                    $index + 1,
                    $payment->transaction_code,
                    $order?->order_code ?? '-',
                    $order?->customer_name ?? '-',
                    $order?->customer_email ?? '-',
                    $order?->customer_phone ?? '-',
                    $service?->name ?? '-',
                    $service?->category_label ?? '-',
                    $order?->booking_date?->format('d/m/Y') ?? '-',
                    $order?->booking_time ?? '-',
                    $payment->method_label,
                    $payment->status_label,
                    $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : '-',
                    (float)$payment->amount,
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, ['', '', '', '', '', '', '', '', '', '', '', 'TOTAL PENDAPATAN LUNAS (Rp):', '', $totalRevenue]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printPdf(Request $request): View
    {
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth()->toDateString());
        $serviceId = $request->query('service_id');
        $category = $request->query('category', 'all');
        $paymentStatus = $request->query('payment_status', 'all');

        $query = Payment::with(['order.service', 'order.user'])
            ->whereHas('order', function ($q) use ($startDate, $endDate, $serviceId, $category) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);

                if ($serviceId) {
                    $q->where('service_id', $serviceId);
                }

                if ($category !== 'all') {
                    $q->whereHas('service', fn($sq) => $sq->where('category', $category));
                }
            });

        if ($paymentStatus !== 'all') {
            $query->where('status', $paymentStatus);
        }

        $payments = $query->latest()->get();

        $totalRevenue = $payments->where('status', 'paid')->sum('amount');
        $totalPaidCount = $payments->where('status', 'paid')->count();
        $totalUnpaidAmount = $payments->where('status', 'unpaid')->sum('amount');
        $totalUnpaidCount = $payments->where('status', 'unpaid')->count();

        return view('admin.reports.print', compact(
            'payments',
            'startDate',
            'endDate',
            'totalRevenue',
            'totalPaidCount',
            'totalUnpaidAmount',
            'totalUnpaidCount'
        ));
    }
}
