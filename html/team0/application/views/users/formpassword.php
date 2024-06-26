<!-- Create by: Natakorn Phongsarikit, Patiphan Pansanga 07-09-2565-->
 <div class="row">
    <div class="col-12">
        <div class="card">
            <form class="" id="pwdForm" autocomplete="off">
                <div class="card-body">
                    <?php if (isset($personPassword)) { ?>
                        <div class="form-group">
                            <label for="curPwd" class="form-label">โปรดกรอกรหัสผ่านปัจจุบัน</label>
                            <input type="password" class="form-control" name="inputValue[]" id="curPwd" onkeyup="checkCurrentPassword()" placeholder="รหัสผ่านปัจจุบัน">
                            <font id="curPwdMsg" class="small text-danger"></font>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label for="pwd" class="form-label">โปรดกรอกรหัสผ่านใหม่</label>
                        <input type="password" class="form-control" name="inputValue[]" id="pwd" onkeyup="checkConfirmPassword()" placeholder="รหัสผ่าน">
                        <font id="pwdMsg" class="small text-danger"></font>
                    </div>
                    <div class="form-group">
                        <label for="cfPwd" class="form-label">โปรดกรอกรหัสผ่านใหม่อีกครั่ง</label>
                        <input type="password" class="form-control" name="inputValue[]" id="cfPwd" onkeyup="checkConfirmPassword()"  placeholder="ยืนยันรหัสผ่าน">
                        <font id="cfPwdMsg" class="small text-danger"></font>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="checkBoxPwd">
                        <label class="form-check-label" for="checkBoxPwd">แสดงรหัสผ่าน</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function checkCurrentPassword() {
        $.ajax({
            method: "post",
            url: 'Users/checkCurrentPassword',
            data: {
                pwd: $('#curPwd').val()
            }
        }).done(function(returnData) {
            if (returnData.result == 0) {
                $('#curPwdMsg').text('รหัสผ่านปัจจุบันไม่ถูกต้อง');
            } else {
                $('#curPwdMsg').text(' ');
            }
        })
    }

    function checkConfirmPassword() {
        if ($('#pwd').val() != $('#cfPwd').val()) {
            $('#pwdMsg').text('รหัสผ่านใหม่ไม่ตรงกัน');
            $('#cfPwdMsg').text('รหัสผ่านใหม่ไม่ตรงกัน');
        } else {
            $('#pwdMsg').text(' ');
            $('#cfPwdMsg').text(' ');
        }
    }

    $(document).ready(function() {
        $('#checkBoxPwd').click(function() {
            if ($(this).is(':checked')) {
                $('#curPwd').attr('type', 'text');
                $('#pwd').attr('type', 'text');
                $('#cfPwd').attr('type', 'text');
            } else {
                $('#curPwd').attr('type', 'password');
                $('#pwd').attr('type', 'password');
                $('#cfPwd').attr('type', 'password');
            }
        });
    });

    function submitPersonPassword() {
        // $('#fMsg').addClass('text-warning');
        // $('#fMsg').text('กำลังดำเนินการ ...');
        var formData = {};
        var result = null;
        $('[name^="inputValue"]').each(function() {
            formData[this.id] = this.value;
        });
        $.ajax({
            method: "post",
            url: 'Users/checkCurrentPassword',
            data: {
                pwd: $('#curPwd').val()
            }
        }).done(function(returnData) {
            result = returnData.result;
        })

        if (!formData.pwd || !formData.cfPwd) {
            $('#errMsg').addClass('text-danger');
            $('#errMsg').text('กรุณาระบุข้อมูลให้ครบถ้วน');
            !formData.pwd ? $('#cfPwd').focus() : '';
            !formData.cfPwd ? $('#pwd').focus() : '';
            !formData.pwd ? $('#curPwd').focus() : '';
            return false;
        } else if (result == 0) {
            $('#errMsg').addClass('text-danger');
            $('#errMsg').text('รหัสผ่านปัจจุบันไม่ถูกต้อง');
            !formData.pwd ? $('#curPwd').focus() : '';
            return false;
        } else if (formData.pwd != formData.cfPwd) {
            $('#errMsg').addClass('text-danger');
            $('#errMsg').text('รหัสผ่านไม่ตรงกัน');
            return false;
        }

        swal({
            title: "ยืนยันการเปลี่ยนรหัสผ่าน",
            text: "คุณต้องการเปลี่ยนรหัสผ่านใช่หรือไม่",
            type: "warning",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
        }).then(function(isConfirm) {
            if (isConfirm.value) {
                $.ajax({
                    method: "post",
                    url: 'Users/updatePassword',
                    data: formData
                }).done(function(returnData) {
                    if (returnData.status == 1) {
                        swal({
                            title: "สำเร็จ",
                            text: returnData.msg,
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        $('#pwdForm')[0].reset();
                        $('#mainModal').modal('hide');
                    } else {
                        swal({
                            title: "ล้มเหลว",
                            text: returnData.msg,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 2000,
                        });
                        $('#pwdForm')[0].reset();
                        $('#mainModal').modal('hide');
                    }
                });
            }
        });
    }
</script>