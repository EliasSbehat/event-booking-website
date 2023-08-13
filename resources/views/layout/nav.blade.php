<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                @if($status =='details')
                    <a href="/dashboard" class="list-group-item list-group-item-action py-2 ripple active" aria-current="true">
                    @else
                    <a href="/dashboard" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    @endif
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Details</span>
                </a>
                @if($status =='confirmation')
                    <a href="/confirmation" class="list-group-item list-group-item-action active py-2 ripple">
                    @else
                    <a href="/confirmation" class="list-group-item list-group-item-action py-2 ripple">
                    @endif
                    <i class="fas fa-globe fa-fw me-3"></i><span>Confirmation</span>
                </a>
				@if($status =='bookings')
                    <a href="/bookings" class="list-group-item list-group-item-action active py-2 ripple">
                    @else
                    <a href="/bookings" class="list-group-item list-group-item-action py-2 ripple">
                    @endif
                    <i class="fas fa-chart-bar fa-fw me-3"></i><span>Bookings</span>
                </a>
                @if($status =='events')
                    <a href="/events" class="list-group-item list-group-item-action active py-2 ripple">
                    @else
                    <a href="/events" class="list-group-item list-group-item-action py-2 ripple">
                    @endif
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Events</span>
                </a>
                @if($status =='settings')
                    <a href="/settings" class="list-group-item list-group-item-action active py-2 ripple">
                    @else
                    <a href="/settings" class="list-group-item list-group-item-action py-2 ripple">
                    @endif
                    <i class="fas fa-gear fa-fw me-3"></i><span>Settings</span>
                </a>
				
            </div>
        </div>
    </nav>
  <!-- Sidebar -->
  <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand website-title" href="#">
            </a>
        </div>
        <!-- Container wrapper -->
    </nav>
    
  <!-- Navbar -->
</header>
<div class="loading">
    <div class='uil-ring-css' style='transform:scale(0.79);'>
        <div></div>
    </div>
</div>
<script>
    $.get(
        "/settings/get",{}, function(res){
            if (res) {
                $(".website-title").html(res?.website_title);
            } else {
                $(".website-title").html('Somerset Smartphone Quizzes');
            }
        },'json'
    )
    var loadingOverlay = document.querySelector('.loading');
    function showLoading(){
        document.activeElement.blur();
        loadingOverlay.classList.remove('hidden');
    }
    function hideLoading(){
        document.activeElement.blur();
        loadingOverlay.classList.add('hidden');
    }
    hideLoading();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>