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
        <aside class="widget widget_categories">
            <h4 class="widget-title">Cari Kategori</h4>
            <ul>
                @foreach($dataN->cat as $row)
                    <li><a href="{{route('blog.all').'?cat='.$row->id}}"><i
                                    class="fa fa-chevron-right"></i> {{$row->name}}</a></li>
                @endforeach
            </ul>
        </aside>
    </div>
</div>