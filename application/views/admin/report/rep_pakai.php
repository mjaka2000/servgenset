<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/style/paper.css">

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
        }


        @page {
            size: A4
        }

        h4 {
            font-weight: bold;
            font-size: 13pt;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .horizontal_center {
            border-top: 3px solid black;
            height: 2px;
            line-height: 30px;
        }

        .kanan {
            float: right;
        }
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">

        <h4 style="margin-bottom: 5px;">Data Pakai</h4>
        <?php echo $label ?>
        <table class="table" width="100%">
            <tr>
                <th style="width :20px">No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Tanggal Update</th>
            </tr>
            <?php
            $no = 1;
            if (empty($pakai)) { // Jika data tidak ada            
                echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
            } else { // Jika jumlah data lebih dari 0 (Berarti jika data ada)           
                foreach ($pakai as $data) { // Looping hasil data transaksi                
                    $tgl = date('d-m-Y', strtotime($data->tgl_update)); ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data->nama; ?></td>
                        <td><?= $data->alamat; ?></td>
                        <td><?= $data->no_hp; ?></td>
                        <td><?= date('d-m-Y', strtotime($data->tgl_update)); ?></td>
                    </tr>
            <?php   }
            }    ?>
        </table>
    </section>

</body>

</html>
<script type="text/javascript">
    window.print();
</script>