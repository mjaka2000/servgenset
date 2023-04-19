<html>

<head>
    <title>Cetak PDF</title>
    <style>
        .table {
            border-collapse: collapse;
            table-layout: fixed;
            width: 630px;
        }

        .table th {
            padding: 5px;
        }

        .table td {
            word-wrap: break-word;
            width: 20%;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h4 style="margin-bottom: 5px;">Data Pakai</h4>
    <?php echo $label ?>
    <table class="table" border="1" width="100%" style="margin-top: 10px;">
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
</body>

</html>
<script type="text/javascript">
    window.print();
</script>