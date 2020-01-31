<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>DCS</b>Login</a>
        </div>
        
        <div class="login-box-body">
            <p class="login-box-msg">เข้าสู่ระบบ</p>
            <!-- <h5 class="text-center text-danger" id="err-block-msg">ไม่สามารถเข้าสู่ระบบได้ชั่วคราว</h5> -->
            <!-- <h5 class="text-center text-danger" id="err-block-msg" style="padding-bottom:20px;"></h5> -->
            <form action="" method="post" id="form_login">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group">
                    <!-- <span style="color:red">ไม่พบ Username นี้</span> -->
                    <!-- <span style="color:red" id="error_msg">Password ไม่ถูกต้อง</span> -->
                    <span style="color:red" id="err-msg"></span>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-flat">Sign In</button>
                </div>
            </form>
        </div>
    </div>