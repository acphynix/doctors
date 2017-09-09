<div class="container-fluid top-nav">
    <div class="container nav-top">
        <div class="row">
            <div class="col-xs-6 logo-label">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">
                        <!--<img src="images/neolafia.png" alt="neolafia_logo" class="img-responsive"/>-->
                        <h4>Neolafia</h4>
                        <p>Healthcare at your finger tips</p>
                    </a>
                </div>
            </div>
            <div class="col-xs-6 user-label">
                <a href="/new/doctor.php" class="pull-right">
                    <?php if($login > 0) :?>
                    <p class="ul-text">Welcome, <b><?php echo $displayname; ?></b></p>
                    <?php else: ?>
                    <p class="ul-text">Are you a specialist doctor?</p>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</div>
<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#neolafia-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container nav-butt">
        <div class="row">
            <div class="col-md-12">
                <div class="collapse navbar-collapse" id="neolafia-navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li id="homePage"><a href="/">Home</a></li>
                        <li id="aboutPage"><a href="/aboutus.php">About</a></li>
                        <li id="faqPage"><a href="/faq.php">FAQ</a></li>
                        <li id="contactPage"><a href="/contactus.php">Contact Us</a></li>
                    </ul>
                    <?php if($login > 0): ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="dashboardPage"><a href="/page/home.php">Dashboard</a></li>
                        <li class="navbar-text">|</li>
                        <li><a href="/logout.php">Sign out</a></li>
                    </ul>
                    <?php else: ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="signinPage"><a href="/login.php">Sign in</a></li>
                        <li class="navbar-text">|</li>
                        <li id="signupPage"><a href="/createaccount.php">Sign up</a></li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>             
</nav>