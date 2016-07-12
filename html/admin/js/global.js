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
        $("#frmlogin").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,กรุณากรอกอีเมล์ด้วยค่ะ",
						"required,pname,กรุณากรอกรหัสผ่านของคุณค่ะ"
                ]
        });

        $("#frmEngineerTest").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,sdate,กรุณาเลือกวันทดสอบด้วยค่ะ"
                ]
        });

        $("#frmthubadd").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,startnum,กรุณากรอกรหัสเริ่มต้นด้วยค่ะ",
						"required,endnum,กรุณากรอกรหัสสิ้นสุดด้วยค่ะ"
                ]
        });

        $("#frmImportLogAis").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,image1,กรุณาเลือกไฟล์ด้วยค่ะ"
                ]
        });

        $("#frmAddPermission").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,code,กรุณากรอกรหัสสิทธิ์ด้วยค่ะ",
						"required,title,กรุณากรอกชื่อรหัสสิทธิ์ด้วยค่ะ"
                ]
        });

        $("#frmPayment").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,cardcode,กรุณากรอกหมายเลขบัตรเติมเงินค่ะ",
			            "digits_only,cardcode,กรุณากรอกเฉพาะตัวเลขค่ะ"
                ]
        });

        $("#frmPayment2").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,price,กรุณากรอกจำนวนเงินค่ะ",
			            "digits_only,price,กรุณากรอกเฉพาะตัวเลขค่ะ"
                ]
        });

        $("#frmAddUser").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,กรุณากรอก Username ด้วยค่ะ",
			            "required,fname,กรุณากรอกชื่อเต็มผู้ใช้งานด้วยค่ะ",
						"required,pname,กรุณากรอก Password ด้วยค่ะ",
			            "required,email,กรุณากรอกอีเมล์ด้วยค่ะ",
			  			"valid_email,email,กรุณากรอกอีเมล์ให้ถูกต้องด้วยค่ะ"
                ]
        });

        $("#frmAddUserM").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,กรุณากรอกชื่อผู้ใช้งานด้วยค่ะ"
                ]
        });

        $("#frmAddProduct").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,title,กรุณากรอกชื่อร้านค้าด้วยค่ะ",
			            "required,categorie,กรุณาเลือกประเภทร้านค้าด้วยค่ะ",
						"required,detail,กรุณากรอกรายละเอียดด้วยค่ะ"
                ]
        });

        $("#frmUpdateUser").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,fname,กรุณากรอกชื่อเต็มผู้ใช้งานด้วยค่ะ",
			            "required,email,กรุณากรอกอีเมล์ด้วยค่ะ",
			  			"valid_email,email,กรุณากรอกอีเมล์ให้ถูกต้องด้วยค่ะ"
                ]
        });

        $("#frmAddOnlineMember").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,fname,กรุณากรอกชื่อเจ้าของเครื่องด้วยค่ะ",
			            "required,province,กรุณาเลือกจังหวัดเจ้าของเครื่องด้วยค่ะ",
						"required,mobileno,กรุณากรอกเบอร์โทรศัพท์เจ้าของเครื่องด้วยค่ะ"
                ]
        });

        $("#frmAddMember").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,fname,กรุณากรอกชื่อเจ้าของเครื่องด้วยค่ะ",
			            "required,email,กรุณากรอกอีเมล์ด้วยค่ะ",
			  			"valid_email,email,กรุณากรอกอีเมล์ให้ถูกต้องด้วยค่ะ",
			            "required,province,กรุณาเลือกจังหวัดเจ้าของเครื่องด้วยค่ะ",
						"required,mobileno,กรุณากรอกเบอร์โทรศัพท์เจ้าของเครื่องด้วยค่ะ"
                ]
        });

        $("#frmAddimeiData").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			  		    "required,type,กรุณากรอกรหัสประเภทด้วยค่ะ",
			            "required,imeicode,กรุณากรอกหมายเลข imei ด้วยค่ะ",
			            "required,docno,กรุณากรอก doc no ด้วยค่ะ",
						"required,docdate,กรุณาเลือกวันที่ด้วยค่ะ",
	                    "required,barcode,กรุณากรอกรหัส bar code ด้วยค่ะ"
                ]
        });

        $("#frmImportSData").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,image1,กรุณาเลือกไฟล์ที่ต้องการด้วยค่ะ"
                ]
        });

        $("#frmImportImeiData").RSV({
          onCompleteHandler: frmComplete,
				rules: [
				        "required,type,กรุณากรอกรหัสประเภทด้วยค่ะ",
			            "required,image1,กรุณาเลือกไฟล์ที่ต้องการด้วยค่ะ"
                ]
        });

        $("#frmAddPartner").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,title,กรุณากรอกชื่อผู้ร่วมค้าด้วยค่ะ",
						"required,email,กรุณากรอกอีเมล์ผู้ร่วมค้าด้วยค่ะ",
						"valid_email,email,กรุณากรอกอีเมล์ให้ถูกต้องด้วยค่ะ",
						"required,pname,กรุณาใส่รหัสผ่านด้วยค่ะ"
                ]
        });

        $("#frmUpdatePartner").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,title,กรุณากรอกชื่อผู้ร่วมค้าด้วยค่ะ"
                ]
        });

        $("#frmreport").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,s_sdate,กรุณาเลือกวันที่เริ่มต้นด้วยค่ะ",
						"required,s_edate,กรุณาเลือกวันที่สิ้นสุดด้วยค่ะ"
                ]
        });

        $("#frmreportdev1").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,partner,กรุณาเลือกชื่ผู้ร่วมค้าด้วยค่ะ"
                ]
        });

        $("#frmsearchuser").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,keyword,กรุณากรอกคำที่คุณต้องการใช้ค้นหาด้วยค่ะ"
                ]
        });
        
        $("#frmsearchref").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,refid,กรุณากรอกคำที่คุณต้องการใช้ค้นหาด้วยค่ะ"
                ]
        });

        $("#frmAddPhoneBrand").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,title,กรุณากรอกชื่อยี่ห้อมือถือด้วยค่ะ"
                ]
        });

        $("#frmAddPhoneModel").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,brand,กรุณาเลือกชื่อยี่ห้อมือถือด้วยค่ะ",
						"required,title,กรุณากรอกชื่อรุ่นมือถือด้วยค่ะ"
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
