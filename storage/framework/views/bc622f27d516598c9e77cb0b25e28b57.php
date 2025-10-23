<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Barcode - <?php echo e($barang->nama); ?></title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .barcode-label {
            width: 100%;
            max-width: 300px;
            border: 1px solid #000;
            padding: 10px;
            margin: 10px auto;
            text-align: center;
        }

        .barcode-image {
            max-width: 100%;
            height: auto;
            margin: 10px 0;
        }

        .item-info {
            font-size: 12px;
            margin: 5px 0;
        }

        .item-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .barcode-code {
            font-family: monospace;
            font-size: 10px;
            margin-top: 5px;
        }

        @media print {
            .no-print {
                display: none;
            }

            .barcode-label {
                page-break-inside: avoid;
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <h1>Print Barcode Label</h1>
        <button onclick="window.print()"
            style="padding: 10px 20px; font-size: 16px; background: #007cba; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Label
        </button>
        <button onclick="window.close()"
            style="padding: 10px 20px; font-size: 16px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>

    <div class="barcode-label">
        <div class="item-name"><?php echo e($barang->nama); ?></div>

        <img src="<?php echo e($barang->barcode_image_url); ?>" alt="Barcode" class="barcode-image">

        <div class="barcode-code"><?php echo e($barang->barcode); ?></div>

        <div class="item-info">
            <div><strong>Kategori:</strong> <?php echo e($barang->kategori->nama ?? 'N/A'); ?></div>
            <div><strong>Ruang:</strong> <?php echo e($barang->ruang->nama ?? 'N/A'); ?></div>
            <div><strong>Kondisi:</strong> <?php echo e($barang->kondisi_display); ?></div>
            <div><strong>Status:</strong> <?php echo e($barang->status); ?></div>
        </div>
    </div>

    <!-- QR Code Version -->
    <div class="barcode-label">
        <div class="item-name"><?php echo e($barang->nama); ?></div>

        <img src="<?php echo e($barang->qr_code_image_url); ?>" alt="QR Code" class="barcode-image">

        <div class="barcode-code"><?php echo e($barang->qr_code); ?></div>

        <div class="item-info">
            <div><strong>Kategori:</strong> <?php echo e($barang->kategori->nama ?? 'N/A'); ?></div>
            <div><strong>Ruang:</strong> <?php echo e($barang->ruang->nama ?? 'N/A'); ?></div>
            <div><strong>Kondisi:</strong> <?php echo e($barang->kondisi_display); ?></div>
            <div><strong>Status:</strong> <?php echo e($barang->status); ?></div>
        </div>
    </div>
</body>

</html>
<?php /**PATH E:\PROJEK  LARAVEL\ig-to-web\resources\views/sarpras/print-barcode.blade.php ENDPATH**/ ?>