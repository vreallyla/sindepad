@if(!empty($user_cookie))
    <script>
        $( document ).ready(function() {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose:true,
                language: 'id'
                }
            );

        });
        {{--movement data personal--}}
        $(function ($) {
            $(".personal-change").click(function () {
                $("#form-personal-change").toggle(300);
                $("#edit_personal").toggle(300);
                $("#personal-content").toggle(300);
                $("#save_personal").toggle(300);
            });
        });

        {{--animate css--}}
        function testAnim(x, classid) {
            $(classid).addClass(x + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                $(this).removeClass(x + ' animated');
            });
        }

        $('.ed_tabs_left li').click(function () {

        })
    </script>
@endif