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
        $("#frmcomment").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,message,��سҡ�͡�����Դ��繢ͧ�س���¤��",
						"required,from,��سҡ�͡���ͧ͢�س���¤��"
                ]
        });

        $("#frmsearch").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,keyword,��سҡ�͡�ӷ��س��ͧ�������Ҵ��¤��"
                ]
        });

        $("#frmContact").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,contactname,��سҪ��ͧ͢��ҹ���¤��",
						"required,contactemail,��سҡ�͡������ͧ��ҹ���¤��",
						"valid_email,contactemail,��سҡ�͡������ͧ��ҹ���١��ͧ���¤��",
 						"required,contactphone,��سҡ�͡�����âͧ��ҹ���¤��",
						"required,contacttopic,��س���Ǣ�ͧ͢��ҹ���¤��",
						"required,contactdetail,��س���������´���¤��",
						"required,chkcode,��سҡ�͡�����Ѻ����ҹ��繴��¤��"
                ]
        });

        $("#frmregisterdev").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,fname,��سҪ��ͧ͢��ҹ���¤��",
						"required,email,��سҡ�͡������ͧ��ҹ���¤��",
						"valid_email,email,��سҡ�͡������ͧ��ҹ���١��ͧ���¤��",
						"required,pass,��سҡ�͡���ʼ�ҹ���¤��",
						"required,address1,��سҡ�͡���������¤��",
						"required,province,��س����͡�ѧ��Ѵ���¤��",
						"required,chkcode,��سҡ�͡�����Ѻ����ҹ��繴��¤��"
                ]
        });

        $("#frmaddnewapp").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,code,��سҡ�͡�����Թ��Ҵ��¤��",
						"required,title,��سҡ�͡�����Թ��Ҵ��¤��",
						"required,categorie,��س����͡������Թ��Ҵ��¤��",
						"required,detail,��سҡ�͡��������´�Թ��Ҵ��¤��"
                ]
        });

        $("#frmLoginBar").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,��س�����������ҹ���¤��",
			            "required,pname,��سҡ�͡���ʼ�ҹ���¤��"
                ]
        });

        $("#frmLogin").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,uname,��س�����������ҹ���¤��",
			            "required,pname,��سҡ�͡���ʼ�ҹ���¤��"
                ]
        });

        $("#frmreportdev").RSV({
          onCompleteHandler: frmComplete,
				rules: [
						"required,s_sdate,��س����͡�ѹ���������鹴��¤��",
						"required,s_edate,��س����͡�ѹ�������ش���¤��"
                ]
        });

        $("#frmforgetpass").RSV({
          onCompleteHandler: frmComplete,
				rules: [
			            "required,email,��سҡ�͡������ͧ��ҹ���¤��",
						"valid_email,email,��سҡ�͡������ͧ��ҹ���١��ͧ���¤��",
						"required,chkcode,��سҡ�͡�����Ѻ����ҹ��繴��¤��"
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
