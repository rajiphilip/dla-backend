<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Feedback Type</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Feedback Type</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-8">
                    <form action="<?= URL; ?>/feedback/saveFeedbackType" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Type:</label>
                            <input type="text" class="form-control" id="type" name="type"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <input type="submit" class="btn btn-primary btn-user" value="Add Feedback Type"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->