<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sessions</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Sessions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Course</th>
                        <th>Theme</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Event Start date</th>
                        <th>Event End Date</th>
                        <th>Reg.Start date</th>
                        <th>Reg.End Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Course</th>
                        <th>Theme</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Event Start date</th>
                        <th>Event End Date</th>
                        <th>Reg.Start date</th>
                        <th>Reg.End Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($sessions as $session) { ?>
                    <tr>
                        <td><?= $session->name; ?></td>
                        <td><?= $session->theme; ?></td>
                        <td><?= number_format($session->fee, 2, '.',','); ?></td>
                        <td><?= SESSION_STATES[$session->status]; ?></td>
                        <td><?= date('d-m-Y', strtotime($session->start_date)); ?></td>
                        <td><?= date('d-m-Y', strtotime($session->end_date)); ?></td>
                        <td><?= date('d-m-Y', strtotime($session->registration_start_date)); ?></td>
                        <td><?= date('d-m-Y', strtotime($session->registration_end_date)); ?></td>
                        <td><a href="<?= URL . 'session/editSession/' . $session->id; ?>"
                               class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a></td>
                        <td><a onclick="if (!confirm('Are you sure you want to DELETE this record?')) {
                                                                        return false;
                                                                    }" href="<?= URL . 'session/deleteSession/' . $session->id; ?>"
                               class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->