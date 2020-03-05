<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Outline</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Outline</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">
                    <form action="<?= URL; ?>/outline/updateOutline" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Title:</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $outline->name; ?>"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea class="form-control" rows="5" id="description" name="description"
                                      required><?= $outline->description; ?></textarea>
                        </div>
                        <input type="hidden" name="outline_id" value="<?= $outline->id; ?>"/>
                        <input type="submit" class="btn btn-primary btn-user" value="Update Outline"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->