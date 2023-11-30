<?php
require('header.php');
require('connection.php');
require('functions.php');
$msg='';
if(isset($_POST['submit']))
{
    $name = get_safe_value($con, $_POST['name']);
    $email = 'sajjad18801@gmail.com';
    $password = get_safe_value($con, $_POST['password']);
    $mobile = get_safe_value($con, $_POST['mobile']);
    $sql = "select * from account where email = '$email'";
    $res = mysqli_query($con, $sql);
    $count = mysqli_num_rows($res);
    if($count>0)
    {
        $msg = "User Already Exist...";
    }
    else
    {
        mysqli_query($con,"insert into account(name,email,password,mobile) values('$name','$email','$password','$mobile')");
        header('location:login.php');
        die();
    }
}
?>
<div class="row">
    <div class="col-2">
        <div class="col-2">
            <img src="../images/image1.png" width="100%">
        </div> 
    </div>
    <div class="col-2">
        <div style="height: 20.625rem;" class="form-container">
            <h1>REGISTER</h1>
            <form method="post">
                <input type="text" id="name" name="name" placeholder="Enter your Name"required>
                <input type="text" id="email" name="email" placeholder="Enter your Email"required>
                <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                <input type="text" id="mobile" name="mobile" placeholder="Enter your Phone Number"required>
                <button type="button" id="send_otp" class="btn email_send_otp" name="send_otp" onclick="email_send_otp()">Send OTP</button>
                <input type="text" id="email_otp" name="email_otp" class="email_verify_otp" placeholder="Enter OTP"required>
                <button type="button" id="verify_otp" class="email_verify_otp" name="verify_otp" onclick="email_verify_otp()">Verify OTP</button>
                <span id="email_otp_result"></span>
                <button type="submit" id="register" class="btn" name="submit">Register</button>
                <?php echo $msg?>
            </form>
        </div>
    </div>
    <script>
        var send_otp = (Math.floor(Math.random() * 10000) + 10000).toString().substring(1);
        var email;
        jQuery('#register').attr('disabled', true);
        function email_send_otp()
        {
            email = jQuery('#email').val();
            jQuery('#email_otp_result').html('');
            if(email=='')
            {
                jQuery('#email_otp_result').html('Please enter Email ID...');
            }
            else
            {
                Email.send({
                    Host: "smtp.gmail.com",
                    Username: "azizmsajjad@gmail.com",
                    Password: "wwsutkahrmfqlpkt",
                    To: email,
                    From: "azizmsajjad@gmail.com",
                    Subject: 'OTP',
                    Body: send_otp
                }).then((message)=>alert("OTP has been Sent."));
                jQuery('#email').attr('disabled', true);
                jQuery('.email_verify_otp').show();
                jQuery('.email_send_otp').hide();
            }
        }
        function email_verify_otp()
        {
            jQuery('#email_otp_result').html('');
            var otp = jQuery('#email_otp').val();
            if(otp=='')
            {
                jQuery('#email_otp_result').html('Please enter OTP...');
            }
            if(otp==send_otp)
            {
                jQuery('.email_verify_otp').hide();
                jQuery('#register').attr('disabled', false);
            }
            else
            {
                jQuery('#email_otp_result').html('Incorrect Email ID or OTP');
            }
        }
    </script>
<?php
require('footer.php');
?>