function setAction(val) {
    document.getElementById('action').value = val;
}

function checkAll(checkEm) {
    var cbs = document.getElementsByTagName('input');
    for (var i = 0; i < cbs.length; i++) {
        if (cbs[i].type == 'checkbox') {
            if (cbs[i].name == 'chkRecordId[]') {
                cbs[i].checked = checkEm;
            }
        }
    }
}

function ajaxFormPost(url, formId) {
    $.ajax({
        url: url,
        type: 'POST',
        data: $('#' + formId).serialize(),
        success: function(result) {

        }
    });
}


function isAllSelect(frmObject) {
    var flgChk = 0;
    for (i = 1; i < frmObject.chkRecordId.length; i++)
    {
        if (frmObject.chkRecordId[i].checked == false)
        {
            flgChk = 1;
            break;
        }
    }
    if (flgChk == 1) {
        frmObject.chkRecordId[0].checked = false;
    } else {
        frmObject.chkRecordId[0].checked = true;
    }
}

function confirmAction(action) {
    var con = confirm("Are you sure want to "+action+"?");
    if(con){
    return true;    
    } else {
    return false;
    }
}

function isAnySelect() {
    var checkaction = 1;
    var checkselect = 1;
    var action = document.getElementById('action').value;
    if (action == "") {
        checkaction = 0;
    }
    var cbs = document.getElementsByTagName('input');

    for (var i = 0; i < cbs.length; i++) {
        if (cbs[i].type == 'checkbox') {
            if (cbs[i].name == 'chkRecordId[]') {

                if (cbs[i].checked == true) {
                    checkselect = 1;
                    break;
                } else {
                    checkselect = 0;
                }
            }
        }
    }
    if (checkselect == 0) {
        alert("Please select atleast one record");
        return false;
    } else if (checkaction == 0) {
        alert("Please select atleast one action");
        return false;
    } else {
        return true;
    }
//        document.getElementById('idList').value = varAllId;
//        return true;

}

function isAnySelectAction() {
    var action = document.getElementById('action').value;

    if (action == "") {
        alert("Please select atleast one action");
        return false;
    } else {
        return true;
    }

}

function showMessage(msg) {
    msg = "Records are " + msg + " successfully.";
    document.getElementById('listingJS').style.display = '';
    document.getElementById('listingJS').innerHTML = msg;
}


function checkSelect(frmObject, id) {
    varAllId = "";
    for (i = 1; i < frmObject.chkRecordId.length; i++)
    {
        if (frmObject.chkRecordId[i].checked == true) {
            if (varAllId == "") {
                varAllId = frmObject.chkRecordId[i].value;
            }
            else {
                varAllId += "," + frmObject.chkRecordId[i].value;
            }
        }
    }
    //alert(varAllId+"xs");

    if (varAllId == "") {
        alert("Please select atleast one record");
        return false;
    } else {
        document.getElementById(id).value = varAllId;
        return true;
    }
}

function disable()
{
    var service;
    service = document.getElementById('service').value;

    if (service != '')
    {
        document.getElementById('add1').disabled = false;
        document.getElementById('add2').disabled = true;
        document.getElementById('add3').disabled = true;
        document.getElementById('add4').disabled = true;
    }

}
function disables()
{
    var procedure;

    procedure = document.getElementById('procedure').value;

    if (procedure != '')
    {
        document.getElementById('add1').disabled = true;
        document.getElementById('add2').disabled = false;
        document.getElementById('add3').disabled = true;
        document.getElementById('add4').disabled = true;
    }

}
function disabless()
{
    var condition;

    condition = document.getElementById('condition').value;

    if (condition != '')
    {
        document.getElementById('add1').disabled = true;
        document.getElementById('add3').disabled = false;
        document.getElementById('add2').disabled = true;
        document.getElementById('add4').disabled = true;
    }

}
function disablesss()
{
    var symptom;

    symptom = document.getElementById('symptom').value;

    if (symptom != '')
    {
        document.getElementById('add1').disabled = true;
        document.getElementById('add3').disabled = true;
        document.getElementById('add2').disabled = true;
        document.getElementById('add4').disabled = false;
    }
}
function active()
{
    document.getElementById('add5').disabled = false;
}