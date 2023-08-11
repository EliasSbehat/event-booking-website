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
            <a class="navbar-brand" href="#">
                Somerset Smartphone Quizzes
            </a>
            <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#pwd_modal">
                Password Setting
            </button>
        </div>
        <!-- Container wrapper -->
    </nav>
    <div class="modal fade" id="pwd_modal" tabindex="-1" aria-labelledby="requestLabels" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestLabels">Set Password</h5>
                    <!-- <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input
                                type="text"
                                class="form-control form-control-lg w-50"
                                id="password"
                                name="password"
                            />
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="password">Confirm Password</label>
                            <input
                                type="password"
                                class="form-control form-control-lg w-50"
                                id="confirm_password"
                                name="password"
                            />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary cancel_btn">Cancel</button>
                    <!-- <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button> -->
                    <button type="button" class="btn btn-primary submit-btn">Save</button>
                </div>
            </div>
        </div>
    </div>
  <!-- Navbar -->
</header>
<div class="loading">
    <div class='uil-ring-css' style='transform:scale(0.79);'>
        <div></div>
    </div>
</div>
<script>
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
    $('.submit-btn').click(function(){
        if ($("#password").val()==$("#confirm_password").val()) {
            $.get(
                "/pwdset",
                {
                    password: $("#password").val()
                }, function() {
                    window.location.reload();
                }
            )
        } else {
            alert("please confirm the password.");
        }
    });
</script>