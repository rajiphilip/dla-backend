<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Facilitator</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Facilitator</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">
                    <form action="<?= URL; ?>users/updateFacilitator" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Firstname:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $facilitator->firstname;?>"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Lastname:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $facilitator->lastname;?>"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Other name:</label>
                            <input type="text" class="form-control" id="othername" name="othername" value="<?= $facilitator->othername;?>"
                                   aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Phone Number:</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number" value="<?= $facilitator->phone_number;?>"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">-- Select Gender --</option>
                                <option value="FEMALE" <?= ($facilitator->gender == 'FEMALE') ? 'selected' : '';?>>FEMALE</option>
                                <option value="MALE" <?= ($facilitator->gender == 'MALE') ? 'selected' : '';?>>MALE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mariral Status:</label>
                            <select class="form-control" id="marital_status" name="marital_status" required>
                                <option value="">-- Select Mariral Status --</option>
                                <option value="SINGLE" <?= ($facilitator->marital_status == 'SINGLE') ? 'selected' : '';?>>SINGLE</option>
                                <option value="MARRIED" <?= ($facilitator->marital_status == 'MARRIED') ? 'selected' : '';?>>MARRIED</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Facebook:</label>
                            <input type="text" class="form-control" id="facebook" name="facebook" value="<?= $facilitator->facebook;?>"
                                   aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Instagram:</label>
                            <input type="text" class="form-control" id="instagram" name="instagram" value="<?= $facilitator->instagram;?>"
                                   aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Twitter:</label>
                            <input type="text" class="form-control" id="twitter" name="twitter" value="<?= $facilitator->twitter;?>"
                                   aria-describedby="emailHelp">
                        </div>
                        <input type="hidden" value="<?= $facilitator->id;?>" name="profile_id" />
                        <input type="submit" class="btn btn-primary btn-user" value="Update Facilitator Details"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->