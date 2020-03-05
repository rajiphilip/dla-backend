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
            <form action="<?= URL; ?>/outline/viewOutlineTimeTable" method="post" class="user" id="add_course_form">
                <div class="form-group">
                    <label>Session:</label>
                    <select class="form-control" id="session_id" name="session_id" onchange="this.form.submit();" required>
                        <option value="">-- Select Session --</option>
                        <?php foreach ($sessions as $session) { ?>
                            <option value="<?= $session->id; ?>"><?= $session->theme .' - '. date('F, Y', strtotime($session->start_date)); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Theme</th>
                            <th>Facilitator</th>
                            <th>Outline</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Theme</th>
                            <th>Facilitator</th>
                            <th>Outline</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        if (isset($outlines)) {
                            foreach ($outlines as $outline) { ?>
                                <tr>
                                    <td><?= $outline->theme; ?></td>
                                    <td><?= $outline->firstname.' '.$outline->lastname; ?></td>
                                    <td><?= $outline->name; ?></td>
                                    <td><?= date('d-m-Y', strtotime($outline->date)); ?></td>
                                    <td><?= date('H:i', strtotime($outline->start_time)); ?></td>
                                    <td><?= date('H:i', strtotime($outline->end_time)); ?></td>
                                    <td><a href="<?= URL . 'outline/editOutlineTimeTable/' . $outline->id; ?>"
                                           class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a>
                                    </td>
                                    <td><a onclick="if (!confirm('Are you sure you want to DELETE this record?')) {
                                                                        return false;
                                                                    }"
                                           href="<?= URL . 'outline/deleteOutlineTimeTable/' . $outline->id; ?>"
                                           class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
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