<script>
    $(function () {
        const targetSearch = $('[name="search"]'),
            baseUrl = window.location.origin + '/blog',
            initParameter = (getUrlParameter('date') ? '&date=' + getUrlParameter('date') : '') +
                (getUrlParameter('cat') ? '&cat=' + getUrlParameter('cat') : '');
        let redire = function () {
            window.location = baseUrl + '?q=' + targetSearch.val() + initParameter;
        };

        targetSearch.keyup(e => {
            if (e.keyCode == 13) {
                redire();
            }
        });

        targetSearch.next().click(function () {
            redire();
        });

        $(document).ready(function () {
            let paginateN = $('.pagination'),
                qN = targetSearch.val();
            $.each(paginateN.find('a'), function (i, val) {
                let $x = $(val),
                    pageSrc = $x.attr('href');
                $x.prop('href', pageSrc + initParameter + (qN ? '&q=' + qN : ''))
            })
        });

    });
</script>