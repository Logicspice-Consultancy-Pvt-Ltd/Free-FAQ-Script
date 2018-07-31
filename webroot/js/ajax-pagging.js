$(document).ready(function () { 
    $(document).on('click', '.ajshort a', function () { 
        var thisHref = $(this).attr('href'); 
        thisHref = decodeURIComponent(thisHref); 
        if (!thisHref) {
            return false;
        }
        $('#loaderID').show();
        $('#listID').load(thisHref, function () {
            $(this).fadeTo(200, 1);
        });
        return false;
    });
});


$(document).on('click', '.admin_ajax_search', function () {
    var thisHref = $(location).attr('href');
    thisHref = decodeURIComponent(thisHref);
    $('#loaderID').show();
    $.ajax({
        type: 'POST',
        url: thisHref,
        cache: false,
        data: $('#adminSearch').serialize(),
        success: function (result) {
            $("#listID").html(result);
        }
    });
    return false;
});



function ajaxSearch() {
    var thisHref = $(location).attr('href');
    thisHref = decodeURIComponent(thisHref);
    $('#loaderID').show();
    $.ajax({
        type: 'GET',
        url: thisHref,
        cache: false,
        data: $('#adminSearch').serialize(),
        success: function (result) {
            $("#listID").html(result);
        }
    });
    return false;
}
function actionFromAjax() {
    var thisHref = $(location).attr('href');
    $('#loaderID').show();
    $.ajax({
        type: 'POST',
        url: thisHref,
        cache: false,
        data: $('#actionFrom').serialize(),
        success: function (result) {
            $("#listID").html(result);
        }
    });
    return false;
}

function ajaxActionFunction() {
    if (isAnySelect()) {
        actionFromAjax();
    }
    return false;
}

$(document).ready(function () {
    $(document).on('click', '.right_acdc', function (e) {
        var clickId = this.id;
        var clickTitle = $(this).children("a").attr("title");
        var thisHref = $('#' + clickId).find('a').attr('href');
        if (thisHref != 'javascript:void(0)') {
            if (!confirm('Are you sure you want to ' + clickTitle + ' ?')) {
                e.preventDefault();
                return false;
            } else {

                $('#loder' + clickId).show();
                $.ajax({
                    type: 'GET',
                    url: thisHref,
                    cache: false,
                    success: function (result) {
                        $('#loder' + clickId).hide();
                        $("#" + clickId).html(result);
                    }
                });
                return false;
            }
        }
    });
});
