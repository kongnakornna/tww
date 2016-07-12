var confirmMsg  = 'คุณต้องการที่จะ';
function confirmLink(theLink, theSqlQuery)
{
if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
	return true;
}

var is_confirmed = confirm(confirmMsg + theSqlQuery);
return is_confirmed;
}

$(document).ready(function() {
        $("#frmcomment").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,message,กรุณากรอกความคิดเห็นของคุณด้วยค่ะ",
						"required,from,กรุณากรอกชื่อของคุณด้วยค่ะ"
                ]
        });

        $("#frmsearch").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,keyword,กรุณากรอกคำที่คุณต้องการใช้ค้นหาด้วยค่ะ"
                ]
        });

        $("#frmContact").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,contactname,กรุณาชื่อของท่านด้วยค่ะ",
						"required,contactemail,กรุณากรอกอีเมล์ของท่านด้วยค่ะ",
						"valid_email,contactemail,กรุณากรอกอีเมล์ของท่านให้ถูกต้องด้วยค่ะ",
 						"required,contactphone,กรุณากรอกเบอร์โทรของท่านด้วยค่ะ",
						"required,contacttopic,กรุณาหัวข้อของท่านด้วยค่ะ",
						"required,contactdetail,กรุณารายละเอียดด้วยค่ะ",
						"required,chkcode,กรุณากรอกรหัสลับที่ท่านเห็นด้วยค่ะ"
                ]
        });

        $("#frmregisterdev").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,fname,กรุณาชื่อของท่านด้วยค่ะ",
						"required,email,กรุณากรอกอีเมล์ของท่านด้วยค่ะ",
						"valid_email,email,กรุณากรอกอีเมล์ของท่านให้ถูกต้องด้วยค่ะ",
						"required,pass,กรุณากรอกรหัสผ่านด้วยค่ะ",
						"required,address1,กรุณากรอกที่อยู่ด้วยค่ะ",
						"required,province,กรุณาเลือกจังหวัดด้วยค่ะ",
						"required,chkcode,กรุณากรอกรหัสลับที่ท่านเห็นด้วยค่ะ"
                ]
        });

        $("#frmaddnewapp").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,code,กรุณากรอกรหัสสินค้าด้วยค่ะ",
						"required,title,กรุณากรอกชื่อสินค้าด้วยค่ะ",
						"required,categorie,กรุณาเลือกกลุ่มสินค้าด้วยค่ะ",
						"required,detail,กรุณากรอกรายละเอียดสินค้าด้วยค่ะ"
                ]
        });

        $("#frmLoginBar").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,กรุณาอีเมล์ผู้ใช้งานด้วยค่ะ",
			            "required,pname,กรุณากรอกรหัสผ่านด้วยค่ะ"
                ]
        });

        $("#frmLogin").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,กรุณาอีเมล์ผู้ใช้งานด้วยค่ะ",
			            "required,pname,กรุณากรอกรหัสผ่านด้วยค่ะ"
                ]
        });

        $("#frmreportdev").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,s_sdate,กรุณาเลือกวันที่เริ่มต้นด้วยค่ะ",
						"required,s_edate,กรุณาเลือกวันที่สิ้นสุดด้วยค่ะ"
                ]
        });

        $("#frmforgetpass").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,email,กรุณากรอกอีเมล์ของท่านด้วยค่ะ",
						"valid_email,email,กรุณากรอกอีเมล์ของท่านให้ถูกต้องด้วยค่ะ",
						"required,chkcode,กรุณากรอกรหัสลับที่ท่านเห็นด้วยค่ะ"
                ]
        });

        $("#frmchnpass").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,cname,กรุณาใส่รหัสผ่านเดิมด้วยค่ะ",
			            "required,npass1,กรุณาใส่รหัสผ่านใหม่ด้วยค่ะ",
						"required,npass2,กรุณายืนยันรหัสผ่านใหม่ด้วยค่ะ",
			            "function,DoCustomValidation"
                ]
        });

		$("#btnCancelClose").click(function(){
            self.close();
	    }); 
});

function DoCustomValidation() {
     if (document.getElementById("npass1").value == '') {
		return [[document.getElementById("npass1"), "กรุณาใส่รหัสผ่านใหม่อีกครั้ง"]];
    }else if (document.getElementById("npass1").value!=document.getElementById("npass2").value) {
		return [[document.getElementById("npass1"), "รหัสผ่านไม่ตรงกัน!! กรุณาลองใหม่อีกครั้ง"]];
        document.getElementById("npass1").value = "";
		document.getElementById("npass2").value = "";
	}else{
        return true;
	}
}

function frmComplete() {
	return true;
}
