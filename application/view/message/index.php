<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Messages</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All My Messages</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Read?</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>To</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Read?</th>
                        <th>Date</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($messages as $message) { ?>
                        <tr>
                            <td><?= $message->firstname.' '.$message->lastname; ?></td>
                            <td><?= $message->subject; ?></td>
                            <td><?= $message->body; ?></td>
                            <td><?= ($message->is_read == 1) ? 'Yes' : 'No'; ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($message->time_sent)); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->