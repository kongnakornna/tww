var confirmMsg  = '�س��ͧ��÷���';
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
			            "required,uname,��سҡ�͡��������¤��",
						"required,pname,��سҡ�͡���ʼ�ҹ�ͧ�س���"
                ]
        });

        $("#frmEngineerTest").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,sdate,��س����͡�ѹ���ͺ���¤��"
                ]
        });

        $("#frmthubadd").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,startnum,��سҡ�͡����������鹴��¤��",
						"required,endnum,��سҡ�͡��������ش���¤��"
                ]
        });

        $("#frmImportLogAis").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,image1,��س����͡�����¤��"
                ]
        });

        $("#frmAddPermission").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,code,��سҡ�͡�����Է�����¤��",
						"required,title,��سҡ�͡���������Է�����¤��"
                ]
        });

        $("#frmPayment").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,cardcode,��سҡ�͡�����Ţ�ѵ�����Թ���",
			            "digits_only,cardcode,��سҡ�͡੾�е���Ţ���"
                ]
        });

        $("#frmPayment2").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,price,��سҡ�͡�ӹǹ�Թ���",
			            "digits_only,price,��سҡ�͡੾�е���Ţ���"
                ]
        });

        $("#frmAddUser").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,��سҡ�͡ Username ���¤��",
			            "required,fname,��سҡ�͡������������ҹ���¤��",
						"required,pname,��سҡ�͡ Password ���¤��",
			            "required,email,��سҡ�͡��������¤��",
			  			"valid_email,email,��سҡ�͡���������١��ͧ���¤��"
                ]
        });

        $("#frmAddUserM").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,��سҡ�͡���ͼ����ҹ���¤��"
                ]
        });

        $("#frmAddProduct").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,title,��سҡ�͡������ҹ��Ҵ��¤��",
			            "required,categorie,��س����͡��������ҹ��Ҵ��¤��",
						"required,detail,��سҡ�͡��������´���¤��"
                ]
        });

        $("#frmUpdateUser").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,fname,��سҡ�͡������������ҹ���¤��",
			            "required,email,��سҡ�͡��������¤��",
			  			"valid_email,email,��سҡ�͡���������١��ͧ���¤��"
                ]
        });

        $("#frmAddOnlineMember").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,fname,��سҡ�͡������Ңͧ����ͧ���¤��",
			            "required,province,��س����͡�ѧ��Ѵ��Ңͧ����ͧ���¤��",
						"required,mobileno,��سҡ�͡�������Ѿ����Ңͧ����ͧ���¤��"
                ]
        });

        $("#frmAddMember").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,fname,��سҡ�͡������Ңͧ����ͧ���¤��",
			            "required,email,��سҡ�͡��������¤��",
			  			"valid_email,email,��سҡ�͡���������١��ͧ���¤��",
			            "required,province,��س����͡�ѧ��Ѵ��Ңͧ����ͧ���¤��",
						"required,mobileno,��سҡ�͡�������Ѿ����Ңͧ����ͧ���¤��"
                ]
        });

        $("#frmAddimeiData").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			  		    "required,type,��سҡ�͡���ʻ��������¤��",
			            "required,imeicode,��سҡ�͡�����Ţ imei ���¤��",
			            "required,docno,��سҡ�͡ doc no ���¤��",
						"required,docdate,��س����͡�ѹ�����¤��",
	                    "required,barcode,��سҡ�͡���� bar code ���¤��"
                ]
        });

        $("#frmImportSData").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,image1,��س����͡������ͧ��ô��¤��"
                ]
        });

        $("#frmImportImeiData").RSV({
          onCompleteHandler: frmComplete,
				rules: [
				        "required,type,��سҡ�͡���ʻ��������¤��",
			            "required,image1,��س����͡������ͧ��ô��¤��"
                ]
        });

        $("#frmAddPartner").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,title,��سҡ�͡���ͼ��������Ҵ��¤��",
						"required,email,��سҡ�͡��������������Ҵ��¤��",
						"valid_email,email,��سҡ�͡���������١��ͧ���¤��",
						"required,pname,��س�������ʼ�ҹ���¤��"
                ]
        });

        $("#frmUpdatePartner").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,title,��سҡ�͡���ͼ��������Ҵ��¤��"
                ]
        });

        $("#frmreport").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,s_sdate,��س����͡�ѹ���������鹴��¤��",
						"required,s_edate,��س����͡�ѹ�������ش���¤��"
                ]
        });

        $("#frmreportdev1").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,partner,��س����͡�����������Ҵ��¤��"
                ]
        });

        $("#frmsearchuser").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,keyword,��سҡ�͡�ӷ��س��ͧ�������Ҵ��¤��"
                ]
        });
        
        $("#frmsearchref").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,refid,��سҡ�͡�ӷ��س��ͧ�������Ҵ��¤��"
                ]
        });

        $("#frmAddPhoneBrand").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,title,��سҡ�͡������������Ͷ�ʹ��¤��"
                ]
        });

        $("#frmAddPhoneModel").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,brand,��س����͡������������Ͷ�ʹ��¤��",
						"required,title,��سҡ�͡���������Ͷ�ʹ��¤��"
                ]
        });

        $("#frmchnpass").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,cname,��س�������ʼ�ҹ������¤��",
			            "required,npass1,��س�������ʼ�ҹ������¤��",
						"required,npass2,��س��׹�ѹ���ʼ�ҹ������¤��",
			            "function,DoCustomValidation"
                ]
        });

		$("#btnCancelClose").click(function(){
            self.close();
	    }); 
});

function DoCustomValidation() {
     if (document.getElementById("npass1").value == '') {
		return [[document.getElementById("npass1"), "��س�������ʼ�ҹ�����ա����"]];
    }else if (document.getElementById("npass1").value!=document.getElementById("npass2").value) {
		return [[document.getElementById("npass1"), "���ʼ�ҹ���ç�ѹ!! ��س��ͧ�����ա����"]];
        document.getElementById("npass1").value = "";
		document.getElementById("npass2").value = "";
	}else{
        return true;
	}
}

function frmComplete() {
	return true;
}
