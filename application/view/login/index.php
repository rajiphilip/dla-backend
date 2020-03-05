<div class="row justify-content-center">

    <div class="col-xl-10 col-lg-12 col-md-9" style="margin-top: 100px;">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <?php require_once('alert.php');?>
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form action="<?= URL;?>/login/login" method="post" class="user" id="login_form">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email"  name="email" aria-describedby="emailHelp"  placeholder="Enter Email Address..." required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                                </div>

                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Login"/>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= URL;?>resetPassword">Forgot Password?</a>
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>