<?php
$page = "Data Rekap";
require_once("./header.php");
// Start the session at the beginning of the script

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ta_absensi";

$koneksi = new mysqli($servername, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Data Rekap</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Data Rekap</li>
            </ol>
           
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <i class="fas fa-table mr-1"></i>
                        Data Rekap
                    </div>
                    <div class="row">
                        <div class="col-md-auto">
                            <select class="custom-select" id="jabatan_id" name="jabatan_id" autocomplete="off">
                                <?php
                                $sql = "SELECT * FROM `jabatan` ORDER BY `jabatan_id` ASC";
                                $result = $koneksi->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $jabatanId = $row['jabatan_id'];
                                        $jabatanNama = $row['jabatan_nama'];
                                        echo '<option value="' . $jabatanId . '">' . $jabatanNama . '</option>';
                                    }
                                } else {
                                    echo '<option value="">- Jabatan Tidak Ditemukan -</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-auto">
                            <input type="date" class="form-control" name="tanggal" id="tanggal" autocomplete="off">
                        </div>
                        <div class="col">
                            <button id="btn-rekap" class="btn btn-primary">Cari</button>
                            <button id="btn-export" class="btn btn-success no-print">Export</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="print-table">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Tanggal</th>
                                        <th>Masuk</th>
                                        <th>Foto Masuk</th>
                                        <th>Keluar</th>
                                        <th>Foto Keluar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    // Perbaikan query SQL untuk mengambil semua data absensi
                                   $sql = "SELECT absensi.*, karyawan.karyawan_nik, karyawan.face_id 
                                            FROM absensi 
                                            INNER JOIN karyawan ON absensi.karyawan_id = karyawan.karyawan_id 
                                            WHERE DAYOFWEEK(absensi.tgl) != 1 
                                            ORDER BY absensi.tgl ASC";
                                    $result = $koneksi->query($sql);
                                    while ($row = $result->fetch_assoc()) : ?>
                                        <tr>
                                            <td><?php echo $row['face_id']; ?></td>
                                            <td><?php echo $row['karyawan_nik']; ?></td>
                                            <td><?php echo $row['tgl']; ?></td>
                                            <td><?php echo $row['masuk']; ?></td>
                                            <td>
                                                <?php if (!empty($row['foto_masuk'])) : ?>
                                                    <img src="uploads/<?php echo $row['foto_masuk']; ?>" class="rounded-circle" alt="Foto Masuk <?php echo htmlspecialchars($row['face_id'], ENT_QUOTES, 'UTF-8'); ?>" width="80" height="80">
                                                <?php else : ?>
                                                    <span class="badge badge-danger">No Image Available</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $row['pulang']; ?></td>
                                            <td>
                                                <?php if (!empty($row['foto_pulang'])) : ?>
                                                    <img src="uploads/<?php echo $row['foto_pulang']; ?>" class="rounded-circle" alt="Foto Keluar <?php echo htmlspecialchars($row['face_id'], ENT_QUOTES, 'UTF-8'); ?>" width="80" height="80">
                                                <?php else : ?>
                                                    <span class="badge badge-danger">No Image Available</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] == 'Hadir Masuk') : ?>
                                                    <span class="badge badge-success">Hadir Masuk</span>
                                                <?php elseif ($row['status'] == 'Terlambat') : ?>
                                                    <span class="badge badge-warning">Terlambat</span>
                                                <?php elseif ($row['status'] == 'Alpa') : ?>
                                                    <span class="badge badge-danger">Alpa</span>
                                                <?php else : ?>
                                                    <?php echo $row['status']; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="edit_rekap.php?rekap_id=<?php echo  $row['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"> </i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    $koneksi->close();
    require_once("./footer.php");
    ?>
</div>
<script>
$(document).ready(function() {
    // Set the default selected option to the first index
    $('#jabatan_id option:first').attr('selected', 'selected');

    // Set the default value of the date input to today's date
    var today = new Date().toISOString().split('T')[0];
    $('#tanggal').val(today);

    $('#btn-rekap').on('click', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Collect the form data
        var jabatan_id = $('#jabatan_id').val();
        var tanggal = $('#tanggal').val();

        $.ajax({
            url: './rekap.php', // The server script to handle the form submission
            type: 'GET', // Use the GET method
            data: {
                jabatan_id: jabatan_id,
                tanggal: tanggal
            },
            success: function(response) {
                // Handle the successful response
                if (response.hasOwnProperty('message')) {
                    // Display the message
                    alert(response.message);
                } else {
                    // Clear the existing table data
                    $('#dataTable').DataTable().clear();

                    // Add the new data from the response
                    response.forEach(function(row) {
                        var badgeClass;
                        switch (row.status) {
                            case 'Hadir Masuk':
                                badgeClass = 'badge-success';
                                break;
                            case 'Terlambat':
                                badgeClass = 'badge-warning';
                                break;
                            case 'Alpa':
                                badgeClass = 'badge-danger';
                                break;
                            default:
                                badgeClass = 'badge-secondary';
                        }
                        var statushtml = '<span class="badge ' + badgeClass + '">' + row.status + '</span>';

                        let imgMasuk = '';
                        if (row.foto_masuk !== null && row.foto_masuk !== '') {
                            imgMasuk = `<img src="uploads/${row.foto_masuk}" class="rounded-circle" alt="Foto Masuk ${row.face_id}" width="80" height="80">`;
                        } else {
                            imgMasuk = '<span class="badge badge-danger">No Image Available</span>';
                        }

                        let imgPulang = '';
                        if (row.foto_pulang !== null && row.foto_pulang !== '') {
                            imgPulang = `<img src="uploads/${row.foto_pulang}" class="rounded-circle" alt="Foto Keluar ${row.face_id}" width="80" height="80">`;
                        } else {
                            imgPulang = '<span class="badge badge-danger">No Image Available</span>';
                        }
                        $('#dataTable').DataTable().row.add([
                            row.face_id,
                            row.karyawan_nik,
                            row.tgl,
                            row.masuk,
                            imgMasuk,
                            row.pulang,
                            imgPulang,
                            statushtml,
                            '<a href="edit_rekap.php?rekap_id=' + row.id + '" class="btn btn-primary"><i class="fas fa-edit"> </i></a>'
                        ]).draw();
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error('Error:', status, error);
            }
        });
    });

    $('#btn-export').click(function() {
        var table = $('#dataTable').DataTable();
        table.destroy(); // Destroy DataTable
        window.print(); // Print the plain HTML table
        location.reload(); // Reload the page to reinitialize DataTable
    });

    // Initialize DataTables
    $('#dataTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "order": [[2, 'desc']]
    });
});
</script>
