<div id='DivExp' class="container">

    <center>
        <h1>@yield('exp_title')</h1>
    </center>
    <div class="col-lg-12">
        <!-- Left column-->
        <div class="col-lg-5"> 
            <@yield('left') 
        </div>
        <!-- END Left column-->

        <!-- Right column-->
        <div class="col-lg-7">
            @yield('right')
        </div>
        <!-- END Right column-->
    </div>
    
    <!-- Begin Explanation -->
    <div class="row" >
        <div class="col-md-12"><br><br></div>
        <div class="col-md-6"  style="padding:10px; margin-left:10px; background-color: #eee; border: 1px solid #ddd;">
            <div class="row">
                <div class="col-md-2"><img src="img/oque.png"/></div>
                <div class="col-md-10">
                    <p align="justify">
                        @yield('o_que')
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-5" style="padding:10px; margin-left:10px; background-color: #eee; border: 1px solid #ddd;">
            <div class="row">
                <div class="col-md-2"><img src="img/como.png"/></div>
                <div class="col-md-10"> 
                    <p align="justify">
                        @yield('como')
                    </p>
                </div>
        </div>
    </div>
    <!-- End Explanation --> 
</div>