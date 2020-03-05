<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Outline Time Table</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Time Table</h6>
        </div>
        <div class="card-body">
            <form action="<?= URL; ?>feedback/viewFeedbacks" method="post" class="user" id="add_course_form">
                <div class="form-group">
                    <label>Session:</label>
                    <select class="form-control" id="feedback_session_id" name="session_id" required>
                        <option value="">-- Select Session --</option>
                        <?php foreach ($sessions as $session) { ?>
                            <option value="<?= $session->id; ?>"><?= $session->theme .' - '. date('Y', strtotime($session->start_date)); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Facilitator:</label>
                    <select class="form-control" id="facilitator_id" name="facilitator_id" onchange="this.form.submit();" required>
                        <option value="">-- Select option --</option>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Question</th>
                            <th>Rating</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Type</th>
                            <th>Question</th>
                            <th>Rating</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        if (isset($feedbacks)) {
                            foreach ($feedbacks as $feedback) { ?>
                                <tr>
                                    <td><?= $feedback->type; ?></td>
                                    <td><?= $feedback->question; ?></td>
                                    <td><?= $feedback->rating; ?></td>
                                </tr>
                            <?php }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->