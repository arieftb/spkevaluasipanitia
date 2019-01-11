    <br/>
    <br/>
    <br/>
    <section class="">
        <div class="container-fluid">
            <div class="block-header col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3">
                <center><h4>Sistem Pendukung Keputusan Kinerja Panitia <br/>Amikom Computer Club</h4></center>
            </div>
            <br/>
            <br/>
            <br/>
            <!-- Widgets -->
            <!-- Vertical Layout | With Floating Label -->
            <div class="row clearfix">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3"">
                    <div class="card">
                        <div class="header">
                            <h2>LOGIN</h2>
                        </div>
                        <div class="body">
                            <form method="POST" action="<?= base_url(). 'user/login' ?>"">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="email" id="email_address" class="form-control" name="email" required>
                                        <label class="form-label">Email Address</label>
                                    </div>
                                </div>

                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="password" id="password" class="form-control" name="password" required>
                                        <label class="form-label">Password</label>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-primary m-t-15 waves-effect" value="LOGIN" name="submit"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Vertical Layout | With Floating Label -->
        </div>
    </section>
