<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $barangs;

    public function __construct($barangs)
    {
        $this->barangs = $barangs;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->barangs;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Barang',
            'Kode Barang',
            'Kategori',
            'Ruang',
            'Jumlah',
            'Kondisi',
            'Status',
            'Harga',
            'Tanggal Pembelian',
            'Supplier',
            'Deskripsi',
            'Barcode',
            'QR Code',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * @param Barang $barang
     * @return array
     */
    public function map($barang): array
    {
        return [
            $barang->nama,
            $barang->kode_barang,
            $barang->kategori->nama ?? '',
            $barang->ruang->nama ?? '',
            $barang->jumlah,
            $barang->kondisi,
            $barang->status,
            $barang->harga,
            $barang->tanggal_pembelian ? $barang->tanggal_pembelian->format('Y-m-d') : '',
            $barang->supplier,
            $barang->deskripsi,
            $barang->barcode,
            $barang->qr_code,
            $barang->created_at?->format('Y-m-d H:i:s'),
            $barang->updated_at?->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 15,
            'C' => 20,
            'D' => 20,
            'E' => 10,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 15,
            'J' => 20,
            'K' => 30,
            'L' => 15,
            'M' => 15,
            'N' => 20,
            'O' => 20,
        ];
    }
}
