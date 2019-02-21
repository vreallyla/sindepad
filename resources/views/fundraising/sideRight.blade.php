<div class="col-lg-3 col-md-3 col-sm-3">
    <div class="sidebar_wrapper">
        <aside class="widget widget_search">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="search"
                       value="{{isset($_GET['q'])?$_GET['q']:''}}">
                <span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
							</span>
            </div>
        </aside>
        <aside class="widget widget_calendar">
            <div class="jquery-calendar"></div>
        </aside>

    </div>
</div>