<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Feedback Questions</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Feedback Questions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Feedback Type</th>
                        <th>Feedback Question</th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Feedback Type</th>
                        <th>Feedback Question</th>
                        <th>Date</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($feedback_questions as $fq) { ?>
                        <tr>
                            <td><?= $fq->type; ?></td>
                            <td><?= $fq->question; ?></td>
                            <td><?= date('d-m-Y', strtotime($fq->created_at)); ?></td>
                            <td><a href="<?= URL . 'feedback/editQuestion/' . $fq->id; ?>"
                                   class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a></td>
                            <td><a onclick="if (!confirm('Are you sure you want to DELETE this record?')) {
                                                                        return false;
                                                                    }" href="<?= URL . 'feedback/deleteFeedbackQuestion/' . $fq->id; ?>"
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