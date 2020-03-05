<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">All Unapproved Transaction</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php'); ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Unapproved Transaction</h6>
        </div>
        <div class="card-body">
            <form action="<?= URL; ?>account/unapprovedTransactions" method="post" class="user" id="add_course_form">
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
                            <th>Student Name</th>
                            <th>Tran. Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Reference Number</th>
                            <th>Payment Date</th>
                            <th>Payment Date</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Student Name</th>
                            <th>Tran. Type</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Reference Number</th>
                            <th>Paid By</th>
                            <th>Payment Date</th>
                            <th></th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                        if (isset($accounts)) {
                            foreach ($accounts as $account) { ?>
                                <tr>
                                    <td><?= $account->firstname . ' ' . $account->lastname; ?></td>
                                    <td><?= strtoupper(str_replace('_', ' ',$account->type)); ?></td>
                                    <td><?= $account->amount; ?></td>
                                    <td><?= ($account->status == 1) ? 'Approved' : 'Unapproved'; ?></td>
                                    <td><?= $account->reference_number; ?></td>
                                    <td><?= $account->paid_by; ?></td>
                                    <td><?= date('d-m-Y', strtotime($account->payment_date)); ?></td>
                                    <td>
                                        <?php if ($account->status == 0) { ?>
                                            <a onclick="if (!confirm('Are you sure you want to APPROVE this transaction?')) {
                                                                        return false;
                                                                    }"
                                               href="<?= URL . 'account/activateTransaction/' . $account->id; ?>/u/<?= $account->user_id; ?>"
                                               class="btn btn-success btn-xs" title="APPROVE"><i
                                                        class="fa fa-check"></i></a>
                                        <?php } ?>
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