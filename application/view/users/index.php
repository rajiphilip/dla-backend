<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Students</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Students</h6>
        </div>
        <div class="card-body">
            <form action="<?= URL; ?>users" method="post" class="user" id="add_course_form">
                <div class="form-group">
                    <label>Session:</label>
                    <select class="form-control" id="session_id" name="session_id" onchange="this.form.submit();"
                            required>
                        <option value="">-- Select Session --</option>
                        <?php foreach ($sessions as $session) { ?>
                            <option value="<?= $session->id; ?>"><?= $session->theme . ' - ' . date('Y', strtotime($session->start_date)); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Gender</th>
                            <th>Marital Status</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        if (isset($students)) {
                            foreach ($students as $student) { ?>
                                <tr>
                                    <td><?= $student->firstname . ' ' . $student->lastname; ?></td>
                                    <td><?= $student->email; ?></td>
                                    <td><?= $student->phone_number; ?></td>
                                    <td><?= $student->gender; ?></td>
                                    <td><?= $student->marital_status; ?></td>
                                    <td><a href="<?= URL . 'users/viewStudentDetail/' . $student->user_id; ?>"
                                           class="btn btn-primary btn-xs" title="VIEW DETAILS"><i class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                            <a onclick="if (!confirm('Are you sure you want to Reset this user password?')) {
                                                                        return false;
                                                                    }"
                                               href="<?= URL . 'users/resetPassword/' . $student->user_id; ?>"
                                               class="btn btn-danger btn-xs" title="RESET PASSWORD"><i
                                                        class="fa fa-lock-open"></i></a>
                                    </td>
                                    <td>
                                        <a onclick="if (!confirm('Are you sure you want to Block this user?')) {
                                                                        return false;
                                                                    }"
                                           href="<?= URL . 'users/blockUser/' . $student->user_id; ?>"
                                           class="btn btn-dark btn-xs" title="BLOCK"><i
                                                    class="fa fa-lock"></i></a>
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