<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?= $forum->title . '<br />By '. $forum->firstname .' '. $forum->lastname .'<br />on '. date('d/m/Y H:i:s', strtotime($forum->posted_at)); ?></h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= $forum->post; ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>No of Likes</th>
                        <th>By</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>No of Likes</th>
                        <th>By</th>
                        <th>Date</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($comments as $comment) { ?>
                        <tr>
                            <td><?= $comment->post; ?></td>
                            <td><?= ($comment->status == 1) ? 'Approved' : 'Not Approved'; ?></td>
                            <td><?= $comment->no_of_likes; ?></td>
                            <td><?= $comment->firstname.' '.$comment->lastname; ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($comment->created_at)); ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->