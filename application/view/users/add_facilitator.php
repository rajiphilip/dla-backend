<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Facilitator</h1>
    <?php require_once('alert.php');?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add New Facilitator</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="col-lg-6">
                    <form action="<?= URL; ?>users/saveFacilitator" method="post" class="user" id="add_course_form">
                        <div class="form-group">
                            <label>Firstname:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Lastname:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Other name:</label>
                            <input type="text" class="form-control" id="othername" name="othername"
                                   aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number:</label>
                            <input type="number" class="form-control" id="phone_number" name="phone_number"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   aria-describedby="emailHelp" required>
                        </div>
                        <div class="form-group">
                            <label>Gender:</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">-- Select Gender --</option>
                                <option value="FEMALE">FEMALE</option>
                                <option value="MALE">MALE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mariral Status:</label>
                            <select class="form-control" id="marital_status" name="marital_status" required>
                                <option value="">-- Select Mariral Status --</option>
                                <option value="SINGLE">SINGLE</option>
                                <option value="MARRIED">MARRIED</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Facebook:</label>
                            <input type="text" class="form-control" id="facebook" name="facebook"
                                   aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Instagram:</label>
                            <input type="text" class="form-control" id="instagram" name="instagram"
                                   aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label>Twitter:</label>
                            <input type="text" class="form-control" id="twitter" name="twitter"
                                   aria-describedby="emailHelp">
                        </div>
                        <input type="submit" class="btn btn-primary btn-user" value="Add Facilitator"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->