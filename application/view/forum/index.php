<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Forum</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Topics</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Post</th>
                        <th>No of Likes</th>
                        <th>Posted By</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Title</th>
                        <th>Post</th>
                        <th>No of Likes</th>
                        <th>Posted By</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($forums as $forum) { ?>
                        <tr>
                            <td><?= $forum->title; ?></td>
                            <td><?= $forum->post; ?></td>
                            <td><?= $forum->no_of_likes; ?></td>
                            <td><?= $forum->firstname.' '.$forum->lastname; ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($forum->posted_at)); ?></td>
                            <td>
                                <a href="<?= URL . 'forum/comments/' . $forum->id; ?>"
                                   class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->