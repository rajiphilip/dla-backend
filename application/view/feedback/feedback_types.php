<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Feedback Types</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Feedback Types</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Feedback Type</th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Feedback Type</th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($feedback_types as $fq) { ?>
                        <tr>
                            <td><?= $fq->type; ?></td>
                            <td><?= date('d-m-Y', strtotime($fq->created_at)); ?></td>
                            <td><a href="<?= URL . 'feedback/editFeedbackType/' . $fq->id; ?>"
                                   class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a></td>
                            <td><a onclick="if (!confirm('Are you sure you want to DELETE this record?')) {
                                                                        return false;
                                                                    }" href="<?= URL . 'feedback/deleteFeedbackType/' . $fq->id; ?>"
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