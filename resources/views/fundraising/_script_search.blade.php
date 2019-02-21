<script src="https://cdn.jsdelivr.net/autonumeric/2.0.0/autoNumeric.min.js"></script>

<script>
    $(function () {
        const targetSearch = $('[name="search"]'),
            baseUrl = window.location.origin + '/fundraising',
            initParameter = (getUrlParameter('date') ? '&date=' + getUrlParameter('date') : '') +
                (getUrlParameter('cat') ? '&cat=' + getUrlParameter('cat') : ''),
            myOptions = {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                maximumValue: '999999999999999',
                minimumValue: '0',
                currencySymbol: 'Rp. '
            }, curentRp = $('.input-rp'),
            loadPart = $('#loading'),
        sumbitrom=$('#forms');

        let redire = function () {
            window.location = baseUrl + '?q=' + targetSearch.val() + initParameter;
        };

        sumbitrom.on('submit', 'form', function (e) {
            e.preventDefault();
            let v = curentRp.autoNumeric('get');
            curentRp.val(v);
            let formFunc = new FormData($(this)[0]);
            loadPart.show();
            axios.post('{{route('api.public.postCont')}}', formFunc)
                .then(function (res) {
                    loadPart.hide();
                    console.log($('form')[0].reset());
                    swallCustom2(res.data.msg);
                }).catch(function (er) {
                    let erN=er.response;
                loadPart.hide();
                if (erN){
                    $.each(erN.data,function (i,val) {
                        sumbitrom.find('[name='+i+']').parent().children('.help-block').text(val);
                    });
                }
            });
        });

        targetSearch.keyup(e => {
            if (e.keyCode == 13) {
                redire();
            }
        });

        targetSearch.next().click(function () {
            redire();
        });

        $(document).ready(function () {
            curentRp.autoNumeric('init', myOptions);
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