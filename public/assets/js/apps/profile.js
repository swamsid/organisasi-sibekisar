$(document).ready(function () {
    $('#formusers').submit(function (e) {
        e.preventDefault();

        var formData = new FormData($("#formusers")[0]);

        $.ajax({
            url: base_url + "/module/users/update_users",
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                //console.log(response);
                var m = JSON.parse(response);
                if (m.status === "ok") {
                    $.toast({
                        heading: 'Success',
                        text: m.message,
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                    });
                   window.location.href=base_url+'/auth';
                } else {
                    $.toast({
                        heading: 'Danger',
                        text: m.message,
                        showHideTransition: 'slide',
                        icon: 'error',
                        loaderBg: '#f2a654',
                        position: 'top-right'
                    })
                }
                $("#formusers")[0].reset();

            }
        });
    });
});