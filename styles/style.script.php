<script defer>
    $(function () {
        $(document).on('click', '.btn-quickview', function (e) {
            e.preventDefault();
            let pid = $(this).attr('data-id');
            $.fancybox.open({
                src  : ajax + '?action=QuickViewRender&id=' + pid + '&csrf_test_name=' + encodeURIComponent(getCookie('csrf_cookie_name')),
                type : 'ajax',
                opts : {
					touch: false,
                    onComplete : function () {
                        console.log(pid);
                    }
                }
            });
        });
        $(document).on('click', '.fancybox-close-small', function() {
            $.fancybox.close();
        });
    });
</script>