<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Facilitators</h1>
    <!-- DataTales Example -->
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Facilitators</h6>
        </div>
        <div class="card-body">
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
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php foreach ($facilitators as $facilitator) { ?>
                        <tr>
                            <td><?= $facilitator->firstname.' '.$facilitator->lastname; ?></td>
                            <td><?= $facilitator->email; ?></td>
                            <td><?= $facilitator->phone_number; ?></td>
                            <td><?= $facilitator->gender; ?></td>
                            <td><?= $facilitator->marital_status; ?></td>
                            <td><a href="<?= URL . 'users/editFacilitator/' . $facilitator->id; ?>"
                                   class="btn btn-primary btn-xs" title="Edit"><i class="fa fa-edit"></i></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->